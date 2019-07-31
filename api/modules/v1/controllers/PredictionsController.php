<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Predictions;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Predictions Controller API
 *
 * @author Joseph 
 */
class PredictionsController extends ActiveController
{
	public $modelClass = 'app\models\Predictions';   

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
					// restrict access to
					'Origin' => ['https://localhost'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Method' => ['POST', 'PUT'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Request-Headers' => ['X-Wsse'],
					// Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
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
		$Date = $_GET['date'];
		$model = Predictions::find()->joinWith('regions')->joinWith('leagues')
										->where("predictions.Deleted = 0 AND Date(GameTime) = '$Date'")
										->orderBy('GameTime')
										->asArray()
										->all();
		return $model;
	}
}
