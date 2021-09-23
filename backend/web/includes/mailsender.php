<?php

require_once __DIR__ . '/../PHPMailer-master/PHPMailerAutoload.php';

function SendMail($EmailArray, $Subject, $Message)
{
	// Send mail
	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
			
			// SMTP Configuration
	$mail->Port = 465;
	//$mail->SMTPDebug = 3;
	$mail->SMTPAuth = true;                  // enable SMTP authentication
	$mail->Host = 'ssl://smtp.sendgrid.net'; // SMTP server
	$mail->Username = 'apikey';
	$mail->Password = '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';

	// $mail->Port = 25; // optional if you don't want to use the default
			
	$mail->From = 'ngugijmn@gmail.com';
	$mail->FromName = 'System Admin';
	$mail->Subject = $Subject;
	$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional, comment out and test
	//$mail->MsgHTML($issue . "<br /><br />" . $comment);
	$mail->MsgHTML($Message);
			
	// Add as many as you want
	foreach ($EmailArray as $key => $row) {
		extract($row);
		$mail->AddAddress($Email, $Name);
	}
	// If you want to attach a file, relative path to it
	//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
	$response= null;
	if (!$mail->Send()) {
		$msg = 'Mailer Error: ' . $mail->ErrorInfo;
		$Sent = 0;
	} else {
		$msg = 'Message sent!';
		$Sent = 1;
	}
	return $Sent;
}
