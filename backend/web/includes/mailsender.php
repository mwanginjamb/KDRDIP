<?php
require_once __DIR__ .'/../PHPMailer-master/PHPMailerAutoload.php';

function SendMail($EmailArray,$Subject,$Message)
{
	// Send mail
	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
			
			// SMTP Configuration
	$mail->Port = 465;
	//$mail->SMTPDebug = 3;
	$mail->SMTPAuth = true;                  // enable SMTP authentication
	$mail->Host = "ssl://smtp.gmail.com"; // SMTP server
	$mail->Username = "josephmailer2@gmail.com";
	$mail->Password = "M@yaiMbili2"; 
	           
	//$mail->Port = 25; // optional if you don't want to use the default 
			
	$mail->From = "ngugi.joseph@gmail.com";
	$mail->FromName = "Joseph Ngugi";
	$mail->Subject = $Subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	//$mail->MsgHTML($issue . "<br /><br />" . $comment);
	$mail->MsgHTML($Message);
			
	// Add as many as you want
	foreach($EmailArray AS $key => $row)
	{
		extract($row);
		$mail->AddAddress($Email, $Name);
	}		
	// If you want to attach a file, relative path to it
	//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
	$response= NULL;
	if(!$mail->Send()) 
	{
		$msg = "Mailer Error: " . $mail->ErrorInfo;
		$Sent = 0;
	} else {
		$msg = "Message sent!";
		$Sent = 1;
	}
	return $Sent;
}	