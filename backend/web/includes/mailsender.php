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
	$mail->Host = env('SMTP_HOST'); // SMTP server
	$mail->Username = env('SMTP_USERNAME');
	$mail->Password = env('SMTP_PASSWORD');

	// $mail->Port = 25; // optional if you don't want to use the default
			
	$mail->From = env('SMTP_FROM');
	$mail->FromName = env('SMTP_NAME');
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
