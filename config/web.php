<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'admin'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'Uu-uQHjO4c-jp8ltoBvq9CSAeiH7SQBW',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'rules' => [
                'update-status' => 'peminjaman-arsip/update-status',
            ],
        ],
        'db' => $db,
    ],

    'modules' => [
    'admin' => [
        'class' => 'mdm\admin\Module',
        'controllerMap' => [
            'default' => 'app\controllers\RbacRedirectController', // Ganti default controller admin
            ],
        ],
    ],

    // ✅ Tambahkan container override
    'container' => [
        'definitions' => [
            // Override mdmsoft search model
            'mdm\admin\models\searchs\AuthItem' => 'app\models\searchs\AuthItem',
        ],
    ],

    // Access control sementara bisa diaktifkan jika butuh testing
    /*
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'rbac-ui/*',
            'folder/*',
            'arsip/*',
            'peminjaman-arsip/*',
        ],
    ],
    */

    'params' => $params,
];

return $config;
