<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'cookieValidationKey' => '[DIFFERENT UNIQUE KEY]',
            'csrfParam' => '_backendCSRF',
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
////                    '@app/views' => '@app/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
////                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                ],
//            ],
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'class' => 'yii\web\User',
            'enableAutoLogin' => false,
            'identityCookie' => [
                'name' => '_backendUser', // unique for backend
            ]
        ],
        'admin' => [
            'identityClass' => 'common\models\Admin',
            'class' => 'yii\web\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_backendAdmin', // unique for backend
            ]
        ],
        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => sys_get_temp_dir(),
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => ['login'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
//    'as beforeRequest' => [
//        'class' => 'yii\filters\AccessControl',
//        'rules' => [
//            [
//                'allow' => true,
//                'actions' => ['login'],
//            ],
//            [
//                'allow' => true,
//                'roles' => ['@'],
//            ],
//        ],
//        'denyCallback' => function () {
//            return Yii::$app->response->redirect(['site/login']);
//        },
//    ],
    'params' => $params,
];
