<?php

namespace api\modules\v1\controllers;
use yii;
use app\models\Users;
use app\models\Countries;
use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;
include_once 'includes/send_sms.php';

/**
 * Users Controller API
 *
 * @author Joseph 
 */
class UsersController extends ActiveController
{
    public $modelClass = 'app\models\Users';   
	
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
		$model = Users::find()->select('users.UserID,
													users.FirstName,
													users.LastName,
													users.Mobile,
													users.Email,
													users.UserStatusID,
													users.CreatedDate,
													users.CreatedBy')
										->joinWith([
											'users as u' => function($query){
													$query->select('u.UserID, u.FirstName, u.LastName');
											}
										])
										->where(['users.Deleted'=> 0])->orderBy('FirstName')->all();
		return $model;
	}

	public function actionLogin()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) 
		{
			$Mobile = Yii::$app->request->post()['Mobile'];
			$CountryID 	= Yii::$app->request->post()['CountryID'];

			$model = Users::findOne([ 'Mobile'=> $Mobile, 'CountryID' => $CountryID ]);
			
			if (!empty($model))
			{
				if (Yii::$app->security->validatePassword($params['Password'], $model->PasswordHash))
				{	
					$model = Users::find()->select('users.UserID,
																users.FirstName,
																users.LastName,
																users.Mobile,
																users.Email,
																users.UserStatusID,
																users.UserGroupID,
																users.UserTypeID,
																users.FacilityID,
																users.CountryID,
																users.CountyID,
																users.SubCountyID,
																users.CreatedDate,
																users.CreatedBy,
																facilities.ReSupplyPeriod'
																)
										->joinWith('facilities')
										->joinWith('counties')
										->joinWith('subcounties')
										->where([ 'Mobile'=> $Mobile, 'CountryID' => $CountryID ])->asArray()->one();

					return array('code' => '00', 'message' => 'Successful', 'data' => $model);
				} else
				{
					return array('code' => '01', 'message' => 'Invalid Mobile or Password');				
				}
			} else
			{
				return array('code' => '01', 'message' => 'Invalid Mobile or Password');
			}
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
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
			
			$CountryID 	= isset(Yii::$app->request->post()['CountryID']) ? Yii::$app->request->post()['CountryID'] : 2;
			
			$model = Users::findOne(['Mobile' => $Mobile, 'CountryID' => $CountryID]);
			if (!empty($model))
			{
				return array('UserID' => $model->UserID, 'UserStatusID' => $model->UserStatusID);				
			} else
			{
				throw new \yii\web\HttpException(401, 'Record Not found');
			}			
		} else
		{
			throw new \yii\web\HttpException(400, 'There are no query string');
		}
	}

	public function actionGetplace() 
	{
		if (!empty(Yii::$app->request->get())) 
		{
			$lat = Yii::$app->request->get()['lat'];
			$lng = Yii::$app->request->get()['lng'];

			$url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDwrqeGJkJafSRjKyXsX4G6pBf_Epk3qp4&latlng='.$lat.','.$lng.'&sensor=false';
			
			$ch = curl_init($url);                                                                                                                                           
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $body);                                                                 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
																			"Content-Type: application/x-www-form-urlencoded",
																			"Accept: application/json"
																	));                                                                                                                                           
			$result = curl_exec($ch);
			if(curl_errno($ch))
			{
				echo curl_error($ch);
			} else {
				$resp = json_decode ($result) ;
				return $resp;			
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
			$model = Users::findOne(Yii::$app->request->post()['UserID']);
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
		
		$params = array('Users' => Yii::$app->request->post());
		$model = Users::findOne(Yii::$app->request->post()['UserID']);

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
			$UserID = $params['UserID'];

			$model = Users::findOne($UserID);
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
			$UserID = $params['UserID'];

			$model = Users::findOne($UserID);
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
