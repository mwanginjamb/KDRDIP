<?php

namespace api\modules\v1\controllers;

use yii;
use app\models\Payments;
use app\models\MpesaTransactions;
use app\models\Orders;
use app\models\PlanOptions;
use app\models\Profiles;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

include_once 'includes/send_sms.php';

/**
 * Payments Controller API
 *
 * @author Joseph
 */
class BankController extends ActiveController
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
		unset($actions['update']);
		unset($actions['delete']);
		unset($actions['view']);
		unset($actions['create']);
		return $actions;
	}

	public function actionConfirmation()
	{
		//echo Yii::$app->getRequest()->getUserIP();  exit;
		$ip = Yii::$app->getRequest()->getUserIP();
		
		$postdata = file_get_contents('php://input');
		
		if (get_magic_quotes_runtime()) {
			$postdata = stripslashes($postdata);
		}
		$filename = 'log/' . (string)time() . 'validation.log';
		$req_dump = print_r($_REQUEST, true);
		$fp = fopen($filename, 'a');
		
		fwrite($fp, $ip);
		fwrite($fp, $postdata);
		fclose($fp);
		
		if ($ip == '196.201.214.206' || $ip == '196.201.214.207' || $ip == '196.201.214.208' ||
				$ip == '196.201.214.200' || $ip == '41.79.9.66' || $ip == '196.201.213.44' ||
				$ip == '196.201.213.114' || $ip == '154.152.212.38') {
			$params = json_decode($postdata);
			
			if (isset($params->TransID)) {
				$exists = MpesaTransactions::findOne(['TransID' => $params->TransID]);
			} else {
				$exists = [];
			}

			$transaction = new MpesaTransactions();
			$transaction->TransactionType = 'MPESA';
			$transaction->TransAmount = $params->TransAmount;
			$transaction->MSISDN = $params->MSISDN;
			$transaction->FirstName = $params->FirstName;
			$transaction->MiddleName = $params->MiddleName;
			$transaction->LastName = $params->LastName;
			$transaction->BillRefNumber = trim($params->BillRefNumber);
			$transaction->BusinessShortCode = $params->BusinessShortCode;
			$transaction->TransTime = $params->TransTime;
			$transaction->TransID = $params->TransID;
			
			if ($transaction->save()) {
				if (empty($exists)) {
					$order = Orders::findOne($transaction->BillRefNumber);
					if (!empty($order)) {
						$payment = new Payments();
						$payment->PaymentDate = date('Y-m-d');
						$payment->Amount = $transaction->TransAmount;
						$payment->ProfileID = $order->ProfileID;
						$payment->PlanID = $order->PlanID;
						$payment->PlanOptionID = $order->PlanOptionID;
						$payment->TransID = $transaction->TransID;
						$payment->PaymentMethodID = 1;
						$payment->OrderID = $order->OrderID;
						$payment->save();

						$planoption = PlanOptions::findOne($order->PlanOptionID);
						if (!empty($planoption)) {
							
							$profile = Profiles::findOne($order->ProfileID);
							// echo $planoption->Days. "/n";
							// echo date('Y-m-d',strtotime('+' . $planoption->Days . ' day', strtotime($profile->PlanExpiry))); exit;
							$profile->PlanExpiry = date('Y-m-d',strtotime('+' . $planoption->Days . ' day', strtotime($profile->PlanExpiry)));
							$profile->save();
						}
					
						// send_sms($transaction->MSISDN, 'Your Payment of ' . $transaction->TransAmount . ' has been received.', 'SHINDA');
					}
				}
			}
		}
		
		$channel = [
							'ResultCode' => '0',
							'ResultDesc' => 'Service processing successful',
						];
						
		return $channel;
	}
	
	public function actionValidation()
	{
		/* $postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		$filename = 'log/'.(string)time().'confirmation.log';
		$req_dump = print_r($_REQUEST, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $postdata);
		fclose($fp); */
		
		$channel = [
							'ResultCode' => '0',
							'ResultDesc' => 'Service processing successful',
						];
			
		return $channel;
	}
	
	public function actionTimeout()
	{
		$ip = Yii::$app->getRequest()->getUserIP();
		//echo $ip; exit;
		
		$postdata = file_get_contents('php://input');
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		
		$filename = 'log/' . (string)time() . 'timeout.log';
		$req_dump = print_r($_REQUEST, true);
		$fp = fopen($filename, 'a');
		fwrite($fp, $ip);
		fwrite($fp, $postdata);
		fclose($fp);
		
		$channel = [
							'ResultCode' => '0',
							'ResultDesc' => 'Service processing successful',
						];
							
		return $channel;	
	}
}
