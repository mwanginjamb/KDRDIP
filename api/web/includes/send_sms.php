<?php

/*

*/
// use app\models\Smsoutgoing;

require_once('AfricasTalkingGateway.php');

function send_sms($recipients, $message, $Origin)
{
	$username   = 'shinda';
	$apikey     = 'c95e230880143b61b2ece23509e875e8cd961a1de4529c12eb19512afd28021d';

	// Create a new instance of our awesome gateway class
	$gateway    = new AfricasTalkingGateway($username, $apikey);
	try {
		// Thats it, hit send and we'll take care of the rest.
		$results = $gateway->sendMessage($recipients, $message, $Origin);
		
		//print_r($result);
				
		foreach ($results as $result) {
			/*
			// status is either "Success" or "error message"
			echo " Number: " .$result->number;
			echo " Status: " .$result->status;
			echo " MessageId: " .$result->messageId;
			echo " Cost: "   .$result->cost."\n";
			*/
			
			return true;
		}
	} catch (AfricasTalkingGatewayException $e) {
		return false;
		//echo "Encountered an error while sending: ".$e->getMessage();
	}
}
