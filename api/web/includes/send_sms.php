<?php
//use app\models\Smsoutgoing; 

require_once('AfricasTalkingGateway.php');

function send_sms($Message, $Mobile)
{
	$Username = 'attain';
	$Password = 'M@yaiMbili1';
	$url = "https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0?";
	$_message = urlencode($Message);
	$url .= "username=$Username&password=$Password&message=$_message&msisdn=$Mobile";
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($ch);
	curl_close($ch);
	//return $data;	
	$SMSOutgoingStatusID = 40;
	$ReferenceNumber = '';
	if ($data != '')
	{
		$DataArray = explode('|',$data);
		$SMSOutgoingStatusID = $DataArray[0];
		$ReferenceNumber = $DataArray[2];	
	}
	$model = new Smsoutgoing();  
	$model->Message = $Message;
	$model->Origin = '';
	$model->Destination = $Mobile;
	$model->SMSOutgoingStatusID = $SMSOutgoingStatusID;
	$model->ReferenceNumber = $ReferenceNumber;
	$model->save();
}

function send_sms1($recipients, $message, $Origin)
{
	$username   = "tafutaa";
	$apikey     = "2875712da58e790d0414f723fe79b416d150e48b3a52a6ca898f601b43babad1";

	// Create a new instance of our awesome gateway class
	$gateway    = new AfricasTalkingGateway($username, $apikey);
	try 
	{ 
		// Thats it, hit send and we'll take care of the rest. 
		$results = $gateway->sendMessage($recipients, $message, $Origin);
		
		//print_r($result);
				
		foreach($results as $result) 
		{
			/*
			// status is either "Success" or "error message"
			echo " Number: " .$result->number;
			echo " Status: " .$result->status;
			echo " MessageId: " .$result->messageId;
			echo " Cost: "   .$result->cost."\n";
			*/
			
			return true;
		}
	}
	catch ( AfricasTalkingGatewayException $e )
	{
		return false; 
		//echo "Encountered an error while sending: ".$e->getMessage();
	}
}
?>