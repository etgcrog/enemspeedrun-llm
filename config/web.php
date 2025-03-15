<?php

use app\models\WebUserIdentity;
use yii\helpers\Url;
use yii\symfonymailer\Mailer;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'pt-BR',
    'defaultRoute' => '/sign-in',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'asdkasj12iu37ncadm,saojd81h3om12,o,cxa.;sd;as´dl12j3i12j3i12j',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => WebUserIdentity::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
            'rules' => [
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


Yii::$container->set(ActiveField::class, [
    'options' => [
        'class' => 'relative z-0 w-full group',
    ],
    'inputOptions' => [
        'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-none block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500'
    ],
    'labelOptions' => [
        'class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'
    ],
    'errorOptions' => [
        'class' => 'mb-4 text-xs text-red-800'
    ]
]);
Yii::$container->set(LinkPager::class, [
    'linkOptions' => [
        'role' => 'button',
        'class' => 'cursor-pointer text-xs truncate text-gray-900 bg-white font-medium border border-gray-300 rounded text-sm px-1 py-0.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700',
    ],
    'linkContainerOptions' => [

    ],
//    'lastPageCssClass' => 'cursor-pointer text-xs text-gray-900 bg-white font-medium border border-gray-300 rounded-sm text-sm px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700',
//    'firstPageCssClass' => 'cursor-pointer text-xs text-gray-900 bg-white font-medium border border-gray-300 rounded-sm text-sm px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700',
    'activePageCssClass' => 'bg-gray-500 border-gray-500',
//    'disabledPageCssClass' => 'text-xs text-gray-900 bg-gray-100 font-medium border border-gray-100 rounded-sm text-sm px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700',
//    'pageCssClass' => 'cursor-pointer text-xs truncate text-gray-900 bg-white font-medium border border-gray-300 rounded text-sm px-1 py-0.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700',
    'lastPageLabel' => 'Última página',
    'firstPageLabel' => 'Início',
    'prevPageLabel' => false,
    'nextPageLabel' => false,
    'options' => [
        'class' => 'flex flex-row gap-1',
        'hx-boost' => 'true',
        'hx-target' => '#content',
    ]
]);
Yii::$container->set(ActiveForm::class, ['options' => ['class' => 'flex flex-col gap-4']]);


return $config;
