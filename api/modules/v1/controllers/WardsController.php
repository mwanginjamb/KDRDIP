<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Wards;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Wards Controller API
 *
 * @author Joseph 
 */
class WardsController extends ActiveController
{
    public $modelClass = 'app\models\Wards';   
	
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
		$model = Wards::find()->joinWith([
												'users as u' => function($query){
														$query->select('u.UserID, u.FirstName, u.LastName');
												}
											])
										->where(['wards.Deleted'=> 0])
										->orderBy('WardName')->all();
		return $model;
	}
}
