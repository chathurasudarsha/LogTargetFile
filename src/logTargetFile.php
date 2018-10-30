<?php

/**
 * @copyright 2018 Don Simon P C S Ariyathilaka
 */
namespace donsimon\log;


use Yii; 
use yii\web\Request;

class LogTargetFile extends \yii\log\FileTarget
{
    /**
     * @inheritdoc
     */
    public $categories = [];
    private $message;
    
    public function formatMessage($message)
    {
        $this->message = $message;
      // list($text, $level, $category, $timestamp) = $message;
        if (isset($message[4])) {
            $message[4] = [];
        }
        //$prefix = $this->getMessagePrefix($message);
        return parent::formatMessage($message);
    }
    
    public function getMessagePrefix($message){
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }

        if (Yii::$app === null) {
            return '';
        }

        $request = Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';

        /* @var $user \yii\web\User */
        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
        if ($user && ($identity = $user->getIdentity(false))) {
            $userID = $identity->getId();
        } else {
            $userID = '';
        }
        return "[$ip][$userID]";
    }
    

    
}