<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

if (isset($_POST['why']) && isset($_POST['email']) && isset($_POST['something']) ) {
$why = trim(strip_tags($_POST['why']));
$email = trim(strip_tags($_POST['email']));
$something = trim(strip_tags($_POST['something']));

require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->setFrom('luisd@dccolorweb.com', ' ');
$mail->addAddress('jadher.11x2@gmail.com', 'NUU');
$mail->Subject  = 'New Contact from NUU';
$mail->Body =  "Why:". $why ."/n";
$mail->Body .=  "Email:". $email ."/n";
$mail->Body .=  "Something:". $something ."/n";

if(!$mail->send()) {
  $success = [ "success" => false ];
} else {
  $success = [ "success" => true ];
}
echo json_encode($success);

} else {
    $success = [ "Data" => "No data found" ];
    echo json_encode($success);
}
