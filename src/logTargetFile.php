<?php

/**
 * @copyright 2018 Don Simon P C S Ariyathilaka
 * customize the log message
 * show and ordering message units
 */
namespace donsimon\log;

use Yii; 
use yii\web\Request;
use yii\helpers\VarDumper;
use yii\log\Logger;

class LogTargetFile extends \yii\log\FileTarget{

    public $categories = [];
    public $logMessageContainer =['timestamp','prefix','level','category','message'];
    private $message;
    public $prefixContainer=['ip','userId','sessionId'];

    public function formatMessage($message){
        $this->message = $message;
        list($text, $level, $category, $timestamp) = $message;
        $level = Logger::getLevelName($level);
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }
        }
        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        $prefix = $this->getMessagePrefix($message);
        $messageAppend = '';
        foreach($this->logMessageContainer as $showing){
            if($showing=='timestamp'){
               $messageAppend .= " ".$this->getTime($timestamp);
            }
            if($showing=='level'){
               $messageAppend .= "[$level]";
            }
            if($showing=='category'){
               $messageAppend .= "[$category]";
            }
            if($showing=='prefix'){
               $messageAppend .= "{$prefix}";
            }
            if($showing=='message'){
               $messageAppend .= " $text";
            }
            
        }
            return trim($messageAppend," ")
                    . (empty($traces) ? '' : "\n    " . implode("\n    ", $traces));
    }
    
    public function getMessagePrefix($message){
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }
        if (Yii::$app === null) {
            return '';
        }
        $prefixAppend = '';
        foreach($this->prefixContainer as $prefixUnit){
            if($prefixUnit=='ip'){
                $request = Yii::$app->getRequest();
                $ip = $request instanceof Request ? $request->getUserIP() : '-';
                $prefixAppend .= "[$ip]";
            }
            if($prefixUnit=='userId'){
                /* @var $user \yii\web\User */
                $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                if ($user && ($identity = $user->getIdentity(false))) {
                    $userID = $identity->getId();
                } else {
                    $userID = '';
                }
               $prefixAppend .= "[$userID]"; 
            }
            if($prefixUnit=='sessionId'){
                /* @var $session \yii\web\Session */
                $session = Yii::$app->has('session', true) ? Yii::$app->get('session') : null;
                $sessionID = $session && $session->getIsActive() ? $session->getId() : '-';
                $prefixAppend .= "[$sessionID]"; 
            }
        }
        return $prefixAppend;
    }
}