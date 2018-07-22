<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'shirt',
    'language' => 'ru',
    'charset' => 'utf-8',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute' => 'site/page',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapThemeAsset' => false,
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
                    ],
                ],
            ],
        ],
        'request' => ['cookieValidationKey' => 'Nl9YGElTnCay5XjDbUNmOVhc0Ux2ggdf'],
        'cache' => ['class' => 'yii\caching\FileCache'],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => ['errorAction' => 'site/error'],
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
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => '.html',
            'rules' => [
                'katalog/<cat_parent_alias:[\w\-]+>/<cat_alias:[\w\-]+>/tovar-<id:[\w\-]+>' => 'site/cart',
                'katalog/<cat_parent_alias:[\w\-]+>/<cat_alias:[\w\-]+>' => 'site/product',
                'katalog/<cat_alias:[\w\-]+>' => 'site/category',
                [
                    'pattern' => 'api/<action:[\w\-]+>',
                    'route' => 'api/<action>',
                    'suffix' => '.json',
                ],
                'admin/<controller:[\w\-]+>/<action:[\w\-]+>' => 'admin/<controller>/<action>',
                'admin' => 'admin/home/index',
                '<view:[\w\-]+>' => 'site/page',
                '' => 'site/page',
            ],
        ],
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
}

return $config;
