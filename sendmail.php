<?php 
    $why = trim(strip_tags($_POST['why']));
    $email = trim(strip_tags($_POST['email']));
    $something = trim(strip_tags($_POST['something']));
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');


    $message = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->
   
</head>
<body>
    <b>Why</b>: '. $why .'<br>
    <b>Email</b>: '. $email .'<br>
    <b>Say Something</b>: '. $something .'<br>
    
</body>
</html>';
$email_from = $name.'<'.$email.'>';
$to = 'hello@nuu.co,luis@nuu.co';
$subject    = 'Contact Form NUU Site';
$headers .= 'From: '.$email_from . "\r\n";
$headers .= "MIME-Version: 1.0"."\r\n";
$headers .= "Content-type: text/html;charset=UTF-8"."\r\n";

mail($to, $subject, $message, $headers);

 $success = [ "success" => true ];
echo json_encode($success);

 ?>