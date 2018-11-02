# Yii2 LogTargetFile

Customize the log message

Show and ordering message units


Installation
--

Just run in your console:

    composer require donsimon/yii2-log-target-file "*"

or add 

    "donsimon/yii2-log-target-file": "*"

to the require section of your composer.json file.

Usage
--

Add following code your configuration

        'bootstrap' => ['log'],

Then,
 
Add following code configurations components
```php
        'log' => [
        //          'traceLevel' => YII_DEBUG ? 3 : 0,
                    'targets' => [
                          [  
                                'class' => 'donsimon\log\logTargetFile',  
                                'levels' => ['info','warning','error'],
                                'categories' => ['user','application'],
                                'logVars' => ['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_SERVER']
                                'logFile' => '@backend/runtime/logs/appAndUser.log',
                                'showLogMessageOrder' =>['timestamp','prefix','level','category','message']
                                'prefixWithSession'=>true
                            ]
                    ],
        ],
```
After `Yii::info($text, 'user');` your log will update.

What you can do here,
--

You can change log file name using `logFile`.

You can add many `categories`.

You can add many `levels` (refer Yii2 logging)

You can print vars using `logVars`.

`showLogMessageOrder` is a array with full log message. You can customize and change the order of message units. 

`prefixWithSession` can use for show, hide seesionId from prefix. 
 

