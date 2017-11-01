<?php
header('Access-Control-Allow-Origin: *'); 

if (isset($_POST['why']) && isset($_POST['email']) && isset($_POST['something']) ) {
$why = trim(strip_tags($_POST['why']));
$email = trim(strip_tags($_POST['email']));
$something = trim(strip_tags($_POST['something']));

$msg = '';
//Don't run this unless we're handling a form submission
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');

    require 'phpmailer/PHPMailerAutoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->Port = 26;

    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('luisd@dccolorweb.com', '');
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addAddress('jacomerej@hotmail.com', '');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addReplyTo($_POST['email'], " ")) {
        $mail->Subject = 'PHPMailer contact form';
        //Keep it simple - don't use HTML
        $mail->isHTML(false);
        //Build a simple message body
        $mail->Body =  "Why:". $why ."/n";
        $mail->Body .=  "Email:". $email ."/n";
        $mail->Body .=  "Something:". $something ."/n";

        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            $success = [ "success" => false ];
        } else {
            $success = [ "success" => true ];
        }
    } else {
        $success = [ "success" => false ];
    }
}

}else {
   $success = [ "success" => true ];
}


header('Content-Type: application/json');

echo json_encode($success);