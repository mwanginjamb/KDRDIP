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
		if (!empty($params)) 
		{
			$Mobile = Yii::$app->request->post()['Mobile'];

			$model = Profiles::findOne([ 'Mobile'=> $Mobile, 'ProfileStatusID' => 2 ]);
			
			if (!empty($model))
			{
				if (Yii::$app->security->validatePassword($params['Password'], $model->PasswordHash))
				{	
					$model = Profiles::find()->select('
																	profiles.ProfileID,
																	profiles.FirstName,
																	profiles.LastName,
																	profiles.Email,
																	profiles.Mobile,																
																	profiles.ProfileStatusID,
																	profiles.PlanID,
																	profiles.PlanOptionID,
																	profiles.PlanExpiry'
																)
										->where([ 'Mobile'=> $Mobile ])->asArray()->one();

					return array('code' => '00', 'message' => 'Successful', 'data' => $model);
				} else
				{
					return array('code' => '01', 'message' => 'Invalid Email or Password');				
				}
			} else
			{
				return array('code' => '01', 'message' => 'Invalid Email or Password1');
			}
		} else
		{
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
			$data = array(
				'ProfileID' => $model->ProfileID,
				'FirstName' => $model->FirstName,
				'LastName' => $model->LastName,
				'Email' => $model->Email,
				'Mobile' => $model->Mobile,
				'ProfileStatusID' => $model->ProfileStatusID,
				'PlanID' => $model->PlanID,
				'PlanOptionID' => $model->PlanOptionID,
				'PlanExpiry' => $model->PlanExpiry
			);

			$channel = array(
					'code' => '00',
					'message' => 'Successful',
					'data' => $data
				);
	  	} else {
			$channel = array(
				'code' => '01',
				'message' => 'Failed to Create Record',
				'data' => $model->getErrors()
			);
		}
		return $channel;
	}

	public function doRegister($params)
	{
		$model = new Members();
		$CountryID = $params['CountryID'];
		$params['Mobile'] = ltrim(Yii::$app->request->post()['Mobile'], '0');
		$params = array('Members' => $params);
		$password = Yii::$app->request->post()['Password'];	
		
		$model->AuthKey = \Yii::$app->security->generateRandomString();
		$model->PasswordHash = \Yii::$app->security->generatePasswordHash($password);
		$model->MemberStatusID = 0;
		$model->ProfileUpdated = 0;
		$model->CompanyID = $CountryID == 2 ? 2 : 1;
		$model->ConfirmationCode = (string) rand(1000, 9999);
		
		if ($model->load($params) && $model->save()) 
		{
			$country = Countries::findOne($model->CountryID);
			$mobile = trim($model->Mobile);
			if ($mobile[0]=='0')
			{
				$mobile = substr($mobile,1,15);
			} 
			$mobile = $country->Code . $mobile;
			// send_sms1($mobile, 'Your Code is '. $model->ConfirmationCode, 'TBAG');

			$IDDescription = $model->MemberTypeID == 1 ? 'PCA NPI/UMPI' :'MA Number';
			$data = array(
								'MemberID' => $model->MemberID,
								'FirstName' => $model->FirstName,
								'MiddleName' => $model->MiddleName,
								'LastName' => $model->LastName,
								'Gender' => $model->Gender,
								'DOB' => $model->DOB,
								'IDNumber' => $model->IDNumber,
								'Email' => $model->Email,
								'Mobile' => $model->Mobile,
								'Photo' => $model->Photo,
								'CountryID' => $model->CountryID,
								'Location' => $model->Location,
								'MemberStatusID' => $model->MemberStatusID,
								'Latitude' => $model->Latitude,
								'Longitude' => $model->Longitude,
								'HourlyRate' => $model->HourlyRate,
								'PlaceRequests' => $model->PlaceRequests,
								'ServiceProvider' => $model->ServiceProvider,
								'ProfileUpdated' => $model->ProfileUpdated,
								'MemberTypeID' => $model->MemberTypeID,
								'IDDescription' => $IDDescription,
								'PlaceID' => $model->PlaceID,
								'signatureImage' => $model->signatureImage
							);

			$channel = array(
						'code' => '00',
						'message' => 'Successful',
						'data' => $data
					);
		} else
		{ 
			$channel = array(
				'code' => '01',
				'message' => 'Failed to Save Record',
				'data' => $model->getErrors()
			);
		}
		return $channel;
	}

	public function actionExists()
	{
		if (!empty(Yii::$app->request->post())) 
		{
			$Mobile = Yii::$app->request->post()['Mobile'];
			$Mobile = str_replace("-","",$Mobile);
			$Mobile = str_replace("(","",$Mobile);
			$Mobile = str_replace(")","",$Mobile);
			// $Mobile = ltrim($Mobile, '0');
			
			$model = Profiles::findOne(['Mobile' => $Mobile]);
			if (!empty($model))
			{
				return array('ProfileID' => $model->ProfileID, 'ProfilestatusID' => $model->ProfilestatusID);				
			} else
			{
				throw new \yii\web\HttpException(401, 'Record Not found');
			}			
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionGetrating() {
		return 0;
	}

	public function actionResendcode()
	{
		if (!empty(Yii::$app->request->post())) 
		{
			$model = Profiles::findOne(Yii::$app->request->post()['ProfileID']);
			if (!empty($model))
			{
				$model->ConfirmationCode = (string) rand(1000, 9999);
				if ($model->save())
				{
					$country = Countries::findOne($model->CountryID);
					$mobile = trim($model->Mobile);
					if ($mobile[0]=='0')
					{
						$mobile = substr($mobile,1,15);
					} 
					$mobile = $country->Code . $mobile;
					send_sms1($mobile, 'Your Code is '. $model->ConfirmationCode, 'TBAG');
					return [];
				} else
				{
					throw new \yii\web\HttpException(400, 'Failed to retrieve Code');
				}				
			} else
			{
				throw new \yii\web\HttpException(400, 'Record Not found');
			}			
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionConfirm()
	{
		$channel = [];
		
		$params = array('Profiles' => Yii::$app->request->post());
		$model = Profiles::findOne(Yii::$app->request->post()['ProfileID']);

		if ($model->ConfirmationCode == Yii::$app->request->post()['ConfirmationCode'])
		{
			$channel = array(
							'code' => '00',
							'message' => 'Successful',
							'data' => []
						);
		} else
		{
			$channel = array(
				'code' => '02',
				'message' => 'Invalid Confirmation Code',
				'data' => $model->getErrors()
			);
		}
		return $channel;
	}

	public function actionForgotpassword()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) 
		{
			$Password = $params['NewPassword'];
			$ProfileID = $params['ProfileID'];

			$model = Profiles::findOne($ProfileID);
			if ($model)
			{
				$model->PasswordHash = \Yii::$app->security->generatePasswordHash($Password);
				if ($model->save())
				{
					return [];
				} else
				{
					throw new \yii\web\HttpException(400, 'Unable to Change Password');
				}
			
			} else
			{
				throw new \yii\web\HttpException(400, 'User Not Found');
			}
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionChangepassword() {
		$params = Yii::$app->request->post();
		if (!empty($params)) 
		{
			$OldPassword = $params['OldPassword'];
			$Password = $params['NewPassword'];
			$ProfileID = $params['ProfileID'];

			$model = Profiles::findOne($ProfileID);
			//print_r($model); exit;
			if ($model)
			{
				if (Yii::$app->security->validatePassword($params['OldPassword'], $model->PasswordHash))
				{
					$model->PasswordHash = \Yii::$app->security->generatePasswordHash($Password);
					if ($model->save())
					{
						return [];
					} else
					{
						throw new \yii\web\HttpException(400, 'Unable to Change Password');
					}
				} else
				{
					throw new \yii\web\HttpException(400, 'Invalid Password');
				}
			} else
			{
				throw new \yii\web\HttpException(400, 'User Not Found');
			}
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}
}
