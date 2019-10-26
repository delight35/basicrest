<?php


//use yii\rest\UrlRule;
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [        
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ]
    ],    
    'components' => [
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://tbdbUser:12345678@localhost:27017/tbdb',
        ],        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'NTFOfxUoBsTvrLlwNq7LFL2jp9QQR2vP',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format' => 'json',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->isSuccessful) {
                    if ($response->data !== null) {
                        $response->statusCode = 200;
                        $response->data = [
                            'status' => 'Success',
                            'message' => 'Успешно',
                            'data' => $response->data
                        ];
                    } else {
                        $response->statusCode = 404;
                        $response->data = [
                            'status' => 'RecordNotFound',
                            'message' => 'Запись не найдена',
                            'data' => [],
                        ];                        
                    }
                }
                
                if ($response->statusCode == 404) {
                    $response->data = [
                        'status' => 'UrlNotFound',
                        'message' => 'URL не найден',
                        'data' => [],
                    ]; 
                }
                
                if ($response->statusCode == 500) {
                    $response->data = [
                        'status' => 'GeneralInternalError',
                        'message' => 'Произошла ошибка',
                        'data' => [],
                    ]; 
                }                
            },
        ],       
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['user'],
                    'tokens' => [
                            '{id}' => '<id:[a-z0-9]*>'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/post'],
                    'except' => ['create', 'update', 'delete', 'options'],
                    'prefix' => 'api',
                    'tokens' => [
                            '{id}' => '<id:[a-z0-9]*>'
                    ],                
                ]
            ],
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    
    $config['bootstrap'][] = 'giiMongoDB';
    $config['modules']['giiMongoDB'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'mongoDbModel' => [
                'class' => 'yii\mongodb\gii\model\Generator'
            ]
        ]
    ];    
}

return $config;
