<?php

namespace api\modules\v1\controllers;

use yii;
use app\models\Profiles;
use app\models\Countries;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

include_once 'includes/send_sms.php';

/**
 * Profiles Controller API
 *
 * @author Joseph 
 */
class ProfilesController extends ActiveController
{
	public $modelClass = 'app\models\Profiles';   

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
		$model = Profiles::find()->select('Profiles.ProfileID,
													Profiles.FirstName,
													Profiles.LastName,
													Profiles.Mobile,
													Profiles.Email,
													Profiles.ProfilestatusID,
													Profiles.CreatedDate,
													Profiles.CreatedBy')
										->joinWith([
											'profiles as u' => function($query){
													$query->select('u.ProfileID, u.FirstName, u.LastName');
											}
										])
										->where(['profiles.Deleted'=> 0])->orderBy('FirstName')->all();
		return $model;
	}

	public function actionLogin()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) {
			$Mobile = Yii::$app->request->post()['Mobile'];

			$model = Profiles::findOne([ 'Mobile'=> $Mobile, 'ProfileStatusID' => 2 ]);
			
			if (!empty($model)) {
				if (Yii::$app->security->validatePassword($params['Password'], $model->PasswordHash)) {
					$model = Profiles::find()->select('profiles.ProfileID,
																	profiles.FirstName,
																	profiles.LastName,
																	profiles.Email,
																	profiles.Mobile,
																	profiles.ProfileStatusID,
																	profiles.PlanID,
																	profiles.PlanOptionID,
																	profiles.PlanExpiry')
										->where([ 'Mobile'=> $Mobile ])->asArray()->one();

					return ['code' => '00', 'message' => 'Successful', 'data' => $model];
				} else {
					return ['code' => '01', 'message' => 'Invalid Email or Password'];
				}
			} else {
				return ['code' => '01', 'message' => 'Invalid Email or Password1'];
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionRegister()
	{
		$params = Yii::$app->request->post();

		if (!empty($params)) {
			$password = $params['Password'];
			$params['AuthKey'] = \Yii::$app->security->generateRandomString();
			$params['PasswordHash'] = \Yii::$app->security->generatePasswordHash($password);
		}

		$_params['Profiles'] = $params;
		$model = new Profiles();
		$model->ProfileStatusID = 2;
		if ($model->load($_params) && $model->save()) {
			$data = [
						'ProfileID' => $model->ProfileID,
						'FirstName' => $model->FirstName,
						'LastName' => $model->LastName,
						'Email' => $model->Email,
						'Mobile' => $model->Mobile,
						'ProfileStatusID' => $model->ProfileStatusID,
						'PlanID' => $model->PlanID,
						'PlanOptionID' => $model->PlanOptionID,
						'PlanExpiry' => $model->PlanExpiry
					];

			$channel = [
							'code' => '00',
							'message' => 'Successful',
							'data' => $data
						];
		} else {
			$channel = [
							'code' => '01',
							'message' => 'Failed to Create Record',
							'data' => $model->getErrors()
						];
		}
		return $channel;
	}

	public function actionValidate()
	{
		if (!empty(Yii::$app->request->post())) {
			$Mobile = Yii::$app->request->post()['Mobile'];
			$Mobile = str_replace('-', '', $Mobile);
			$Mobile = str_replace('(', '', $Mobile);
			$Mobile = str_replace(')', '', $Mobile);
			// $Mobile = ltrim($Mobile, '0');
			
			$model = Profiles::findOne(['Mobile' => $Mobile]);
			if (!empty($model)) {
				$model->ValidationCode = $this->generatecode($Mobile);
				if ($model->save()) {
					$mobile = trim($model->Mobile);
					if ($mobile[0]=='0') {
						$mobile = substr($mobile, 1, 15);
					}
					$mobile = '254' . $mobile;
					send_sms($mobile, 'Your Code is ' . $model->ValidationCode, 'SHINDA');
					return ['ProfileID' => $model->ProfileID];
				} else {
					throw new \yii\web\HttpException(401, 'Failed to Validate');
				}
			} else {
				throw new \yii\web\HttpException(401, 'Mobile Not found');
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionGetrating()
	{
		return 0;
	}

	public static function generateCode($Mobile)
	{
		$model = Profiles::findOne(Yii::$app->request->post()['Mobile']);
		return (string) rand(1000, 9999);
	}

	public function actionGeneratecode()
	{
		if (!empty(Yii::$app->request->post())) {
			$model = Profiles::findOne(Yii::$app->request->post()['Mobile']);
			if (!empty($model)) {
				$model->ValidationCode = $this->generatecode(Yii::$app->request->post()['Mobile']);
				if ($model->save()) {
					$mobile = trim($model->Mobile);
					if ($mobile[0]=='0') {
						$mobile = substr($mobile, 1, 15);
					}
					$mobile = '254' . $mobile;
					send_sms($mobile, 'Your Code is ' . $model->ValidationCode, 'SHINDA');
					return [];
				} else {
					throw new \yii\web\HttpException(400, 'Failed to retrieve Code');
				}
			} else {
				throw new \yii\web\HttpException(400, 'Record Not found');
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionConfirm()
	{
		$channel = [];
		
		$params = ['Profiles' => Yii::$app->request->post()];
		$model = Profiles::findOne(Yii::$app->request->post()['ProfileID']);

		if ($model->ValidationCode == Yii::$app->request->post()['ValidationCode']) {
			$channel = [
							'code' => '00',
							'message' => 'Successful',
							'data' => []
						];
		} else {
			$channel = [
				'code' => '02',
				'message' => 'Invalid Confirmation Code',
				'data' => $model->getErrors()
			];
		}
		return $channel;
	}

	public function actionForgotpassword()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) {
			$Password = $params['NewPassword'];
			$ProfileID = $params['ProfileID'];

			$model = Profiles::findOne($ProfileID);
			if ($model) {
				$model->PasswordHash = \Yii::$app->security->generatePasswordHash($Password);
				if ($model->save()) {
					return [];
				} else {
					throw new \yii\web\HttpException(400, 'Unable to Change Password');
				}
			} else {
				throw new \yii\web\HttpException(400, 'User Not Found');
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionChangepassword()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) {
			// Fetch the Profile Record
			$model = Profiles::findOne(['Mobile' => $params['Mobile']]);
			if ($model) {
				// Validate the Reset Code
				if ($params['ResetCode'] === $model->ValidationCode) {
					// Change Pasword
					$model->PasswordHash = \Yii::$app->security->generatePasswordHash($params['Password']);
					if ($model->save()) {
						return [];
					} else {
						throw new \yii\web\HttpException(400, 'Unable to Change Password');
					}
				} else {
					throw new \yii\web\HttpException(400, 'Invalid Reset Code');
				}
			} else {
				throw new \yii\web\HttpException(400, 'Invalid Mobile Number');
			}
		} else {
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}
}
