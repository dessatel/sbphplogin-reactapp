<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Request-Method: GET');

include_once("../REST/encoder/auth.inc");

// need to add change for authenictaion


$emailAddresses = $_GET['emailAddresses'];
$hostName = $_GET['hostName'];
$emailTitle = $_GET['emailTitle'];
$sessionID = $_GET['sessionID'];

use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
// $mail->SMTPDebug = 2;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->IsHTML(true);
$mail->Username = "session@streambox.com";
$mail->Password = "moon-is-rising-over-me";
#$mail->Password = $_ENV['MAIL_PASSWORD'];

$emailsArray = explode(",", $emailAddresses);
foreach ($emailsArray as $email) {
    $mail->AddAddress($email);
}
$server='liveus.streambox.com';
if (strtolower(substr($sessionID, 0, 1)) === 'r') {
    $server = 'broker.streambox.com';
} else {
    $server = 'live.streambox.com';
}

$mail->setFrom('session@streambox.com', 'Streambox Sessions');
//
$mail->Subject = "Session Invitation from " . $hostName;
$mail->Body    = "Session Name:  $emailTitle
<br>
<br>
Join Streambox Libe Session: 
https://$server/ls/launchsession.php?sessionId=$sessionID
<br>
<br>
Streambox Media Players:
<br>
To receive this video stream you will need a Streambox Media Player/Decoder. 
<br>
You can download instructions for various Streambox Players/Decoders here:
<br>
https://streambox-mediaplayer.s3.us-west-2.amazonaws.com/latest/streambox_mediaplayer_sessions.pdf 
<br>
<br>
If you have any questions, please feel free to contact Streambox at:
<br>
Email: support@streambox.com
<br>
Phone: +1 206.956.0544, Option 2";
$text = 'Text version of email';
$html = '<html><body>HTML version of email</body></html>';
$crlf = "\n";
$hdrs = array(
    'email' => 'djklu31@gmail.com',
    'Subject' => 'Test subject message',
    'comment' => 'Test comment',
);
if ($mail->send($hdrs))
//if (mail($subject,$message, $headers))
{
    echo "Emails sent successfully to: " . $emailAddresses;
} else {
    echo "Mailed Error: " . $mail->ErrorInfo;
}
