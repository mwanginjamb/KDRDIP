<?php

namespace api\modules\v1\controllers;

use yii;
use app\models\Payments;
use app\models\Profiles;
use app\models\Orders;

use yii\helpers\ArrayHelper;

use yii\rest\ActiveController;

include_once 'includes/send_sms.php';

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

	public function actionCreate()
	{
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

	public function actionCreateorder()
	{
		$model = new Orders();
		$params['Orders'] = Yii::$app->request->post();

		if ($model->load($params) && $model->save()) {
			return $model;
		} else {
			throw new \yii\web\HttpException(400, 'Failed to Create order');
		}
	}

	public function actionConfirm($id)
	{
		$model = Orders::findOne($id);
		if (!empty($model)) {
			$payment = Payments::find()->where('OrderID = ' . $id)->sum('Amount');
			if ($model->Amount <= $payment) {
				return $model;
			} else {
				throw new \yii\web\HttpException(400, 'Not Paid');
			}
		} else {
			throw new \yii\web\HttpException(400, 'Not Found');
		}
	}

	public function actionDirectdeposit()
	{
		$params = Yii::$app->request->post();

		if (!empty($params) && isset($params['OrderID']) && isset($params['Amount']) && isset($params['Mobile'])) {
			// Format Mobile
			$Mobile = $params['Mobile'];
			$Mobile = ltrim($Mobile, '+');
			$Mobile = ltrim($Mobile, ' ');
			if ($Mobile[0]=='0') {
				$Mobile = substr($Mobile, 1, 15);
			}
			$Mobile = '254' . $Mobile;

			$Amount = $params['Amount'];

			
				$plaintext = '8378d2931742ea3999f53dd8700c5db34afbeffdf582ac89e5a4ae670bc522dc';

				$timestamp = date('Ymdhis');
				$en_password =  base64_encode('290890' . $plaintext . $timestamp);
				$Token = $this->getToken();

				$url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Authorization:Bearer ' . $Token]); //setting custom header

				$curl_post_data = [
											//Fill in the request parameters with valid values
											'BusinessShortCode' => '290890', //159285
											'Password' => $en_password,
											'Timestamp' => $timestamp,
											'TransactionType' => 'CustomerPayBillOnline',
											'Amount' => $Amount,
											'PartyA' => $Mobile,
											'PartyB' => '290890',
											'PhoneNumber' => $Mobile,
											'CallBackURL' => 'https://api.citybet.co.ke/v1/bank/confirmation',
											'AccountReference' => $params['OrderID'],
											'TransactionDesc' => 'Order Payment for Shinda Scores'
										];

				$data_string = json_encode($curl_post_data);

				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

				$result = curl_exec($curl);
				if (curl_errno($curl)) {
					throw new \yii\web\HttpException(400, 'Failed to send Request');
				} else {
					return ['code' => '00', 'message' => 'Success'];
				}
		} else {
			throw new \yii\web\HttpException(400, 'Missing Parameters');
		}
	}

	public static function getToken()
	{
		$url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		$credentials = base64_encode('hIw1WaEgdcFkCFrdzuMowIow1IYJvOVM:0ZrpD9JkjupjlB3M');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]); //setting a custom header
		//curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($curl);
		
		if (curl_errno($curl)) {
			//echo 'Curl error: ' . curl_error($curl);
			$res = '';
		} else {
			$r = json_decode($result);
			$res = $r->access_token;
		}
		return $res;
	}
}
