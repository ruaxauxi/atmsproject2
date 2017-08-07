<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'  => 'vi',
    'timezone'  =>  'Asia/Ho_Chi_Minh',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    	'urlManager' => [
    				'enablePrettyUrl' => true,
    				'showScriptName' => false,
    				'rules' => [
    				],
    	],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles'  => ['ADMIN', "STAFF", "COLLABORATOR", "CUSTOMER"]
        ],
    ],
	'modules'	=> [
		/* 'user'	=> [
				'class' => 'dektrium\user\Module',
				'enableConfirmation' => true,
				'enablePasswordRecovery'	=> true,
				'confirmWithin' => 21600,
				'cost' => 12,
				'admins' => ['admin']
		],	 */
	],
];
