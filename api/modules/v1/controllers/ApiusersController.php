<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Apiusers;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Apiusers Controller API
 *
 * @author Joseph 
 */
class ApiusersController extends ActiveController
{
    public $modelClass = 'app\models\Apiusers';   
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
    /*
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),	
        ];
        */
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];	
 
        return $behaviors;
    }	

	protected function verbs()
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'index'  => ['get'],
					'view'   => ['get'],
					'create' => ['get', 'post'],
					'update' => ['get', 'put', 'post'],
					'delete' => ['post', 'delete'],
				],
			],
		];
	}

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}

	public function actionIndex()
	{
		$model = Apiusers::find()->where(['Deleted'=> 0])->orderBy('Username')->all();
		return $model;
	}
}
