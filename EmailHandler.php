<?php

require('phpmailer/class.phpmailer.php');
require('phpmailer/class.pop3.php');
require('phpmailer/class.smtp.php');
require('phpmailer/PHPMailerAutoload.php');

//$subject="WB test";
//$message="sdf dfg dfg";
//$email="dilanka.test@gmail.com,dilanka.champ@gmail.com";
//$emails=array("dilanka.test@gmail.com","dilanka.champ@gmail.com");
//sendEmail($subject, $message, $emails);

function sendEmail($subject, $message, $emails, $file_path = null, $file_name = null) {
    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->DKIM_domain = '127.0.0.1';
    $mail->ContentType = 'text/html';
    $mail->Debugoutput = 'html';
    $mail->CharSet = 'UTF-8';
    //Set the hostname of the mail server
    $mail->Host = "smtp.gmail.com";
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 587;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = "admin@nanaska.com";
    //Password to use for SMTP authentication
   //$mail->Password = "Nanaska1234#";
    $mail->Password = "Tech@89#12365%$789";
    $mail->SMTPSecure  = 'tls';
    //Set who the message is to be sent from
    $mail->setFrom('admin@nanaska.com', 'nanaska');
    //Set who the message is to be sent to				
    //$mail->addAddress($email);
    //Set the subject line
    $mail->Subject = ($subject);
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message);

    if ($file_path != "" && $file_name != "") {
        $mail->AddAttachment($file_path, $file_name);
    }

    if (is_array($emails)) {
        //for multiple emails
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }
    } else {
        //for single email
        $email = $emails;
        $mail->addAddress($email);
    }

    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }

}