<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Payments;
use app\models\Profiles;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Payments Controller API
 *
 * @author Joseph 
 */
class PaymentsController extends ActiveController
{
	public $modelClass = 'app\models\Payments';   

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
					'Origin' => ['capacitor://localhost',
  'ionic://localhost',
  'http://localhost',
  'http://localhost:8080',
  'http://localhost:8100'],
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
		unset($actions['create']);
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

	public function actionCreate() {
		$model = new Payments();

		$params['Payments'] = Yii::$app->request->post();

		if ($model->load($params) && $model->save()) {
			$ProfileID = Yii::$app->request->post()['ProfileID'];
			$profile = Profiles::findOne($ProfileID);
			$profile->PlanID = $model->PlanID;
			$profile->PlanOptionID = Yii::$app->request->post()['PlanOptionID'];
			$profile->PlanExpiry = '2019-09-01';
			$profile->save();
			return array(
				'code' => '00',
				'message' => 'Successful',
				'data' => []
			);

		} else {
			return array(
				'code' => '01',
				'message' => 'Failed to Create Record',
				'data' => $model->getErrors()
			);
		}

	}
}
