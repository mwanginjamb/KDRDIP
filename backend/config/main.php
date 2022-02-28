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
	'modules' => [
		'api' => [
			'class' => 'backend\modules\api\Module'
		]
	],
	'components' => [
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			//'timeZone' => 'Africa/Nairobi'
		],
		'request' => [
			'csrfParam' => '_csrf-backend',
			// 'csrfParam' => '_backendCSRF',
			'enableCsrfValidation' => false,
			'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ]
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => false,
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 60*60 // If user is inactive for 10 min , log them out
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
            //'timeout' => 60*20, // If user is inactive for 10 min , log them out
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/projects',
                        'api/groups'
                    ]
                ],
            ],
		],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest']
        ],
		'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['/app-assets/js/jquery.min.js'],
                ]
            ],
            'appendTimestamp' => true,
        ],
		
	],
	'params' => $params,
];
