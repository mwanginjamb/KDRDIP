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
	'bootstrap' => [
							'log',
							'backend\controllers\Rights',
						],
	'modules' => [],
	'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			//'timeZone' => 'Africa/Nairobi'
		],
		'request' => [
			'csrfParam' => '_csrf-backend',
			// 'csrfParam' => '_backendCSRF',
			'enableCsrfValidation' => false,
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => false,
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
            'timeout' => 10*60, // If user is inactive for 10 min , log them out
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest']
        ],
		
	],
	'params' => $params,
];
