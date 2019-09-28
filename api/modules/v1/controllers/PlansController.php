<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Plans;
use app\models\PlanBenefits;
use app\models\PlanOptions;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Plans Controller API
 *
 * @author Joseph 
 */
class PlansController extends ActiveController
{
	public $modelClass = 'app\models\Plans';   

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
		return $actions;
	}

	public function actionIndex()
	{
		$model = Plans::find()->all();
		$AllPlans = [];
		foreach ($model as $key => $plan) {
			$AllPlans[$key] = ['PlanID' => $plan->PlanID, 'PlanName' => $plan->PlanName];
			$AllPlans[$key]['benefits'] = PlanBenefits::find()->where(['PlanID' => $plan->PlanID])->joinWith('benefits')->asArray()->all();  
			$AllPlans[$key]['options'] = PlanOptions::find()->where(['PlanID' => $plan->PlanID])->asArray()->all();  
		}	
		return $AllPlans;
	}

	public function actionOption($id) {
		return PlanOptions::findOne($id);
	}
}
