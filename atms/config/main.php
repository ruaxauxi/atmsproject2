<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'atms-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'atms\controllers',
    'bootstrap' => ['log'],
    'language'  => 'vi',
    'modules' => [
    		/* 'user'	=> [
    				'class' => 'dektrium\user\Module'
    		] */
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    		
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
           
        ],
       
        'user' => [
            'identityClass' => 'atms\models\User',
             'class' => 'atms\components\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-atms', 'httpOnly' => true],
        	'loginUrl'	=> array('dashboard/login'),
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'atmsproject-atms',
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
            'errorAction' => 'dashboard/error',
        ],
      
        'urlManager' => [
            //'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
            		'/login'	=> '/dashboard/login',
            		'/logout'	=> 'dashboard/logout',
            		'/'	        => '/dashboard/index',
                    '/forbidden'    => '/dashboard/forbidden',
            		'/error'      => '/dashboard/error',
                    '/customer'   =>  '/customer/index',
                    '/permission'   => '/permission/index',
            ],
        ],
        /*'view' => [
            'theme' => [
                'basePath' => '@app/themes/default',
                'baseUrl' => '@web/themes/default',
                'pathMap' => [
                    '@app/views' => '@app/themes/default',
                ],
            ],
        ],

        */
        
    ],
    'params' => $params,
    'defaultRoute' => 'dashboard',
];
