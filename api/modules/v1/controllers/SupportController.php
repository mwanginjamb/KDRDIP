<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Support;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

/**
 * Support Controller API
 *
 * @author Joseph 
 */
class SupportController extends ActiveController
{
	public $modelClass = 'app\models\Support';   

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
                'Origin' => ['capacitor://localhost',
										'ionic://localhost',
										'http://localhost',
										'http://localhost:8080',
										'http://localhost:8100'],
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
		$Mobile = isset($_GET['Mobile']) ? $_GET['Mobile'] : '0';
		$model = Support::find()->joinWith('supportstatus')
										->where("support.Deleted = 0 AND Mobile = '$Mobile'")
										->orderBy('CreatedDate DESC')
										->asArray()
										->all();
		return $model;
	}

	public function actionOption($id) {
		return PlanOptions::findOne($id);
	}
}
