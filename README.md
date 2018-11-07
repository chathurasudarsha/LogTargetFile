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

Add following line to your  main configuration file (e.g. config/main.php),

        'bootstrap' => ['log'],

Then,
 
Add following lines to the components section in configuration file,
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
                                'logMessageContainer' =>['timestamp','prefix','level','category','message']
                                'prefixContainer'=>['ip','userId','sessionId']
                            ]
                    ],
        ],
```
To write on log file client should call something like this,

 `Yii::info($message, $category);` 

Here $message and $category are variables.

your log will update.

What you can do here,
--

You can change log file name using `logFile`.

    -eg: @backend/runtime/logs/user-activities.log

You can add many `categories`.

    -eg: ['yii\web\HttpException:*','yii\base\ErrorException:*','user','application']

You can add many `levels` 

    -eg: ['info','warning','error']

[Refer for details](https://www.yiiframework.com/doc/guide/2.0/en/runtime-logging)

You can print vars using `logVars`.

``` New ```

`logMessageContainer` is a array of log messages units ['timestamp','prefix','level','category','message']. 

You can sort or remove log messages units using `logMessageContainer` 

`prefixContainer` is a array of prefix units ['ip','userId','sessionId'].

You can sort or remove log messages prefix using `prefixContainer`
 

