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
        	'loginUrl'	=> array('main/login'),
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
            'errorAction' => 'main/error',
        ],
      
        'urlManager' => [
            //'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
            		'/login'	=> '/main/login',
            		'/logout'	=> 'main/logout',
            		'/'	=> '/main/index',
            		'/error'      => '/main/error',
                                '/airport'   =>  '/airport/index',
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
    'defaultRoute' => 'main',
];
