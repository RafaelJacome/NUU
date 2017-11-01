<?php
	if (isset($_POST['nombre']) && !empty($_POST['nombre']) ) {
		$nombre = trim(strip_tags($_POST['nombre']));
		$telefono = trim(strip_tags($_POST['telefono']));
		$email = trim(strip_tags($_POST['email']));
		$empresa = trim(strip_tags($_POST['empresa']));
		$mensaje = trim(strip_tags($_POST['mensaje']));
		$fecha = date('d/m/Y', time());
		$hora = date('h:i:s a', time());

		if ( !empty($_FILES["cv"]["name"]) ) {

			$allowedExts = array("doc", "docx", "xls", "xlsx", "pdf");
			$allowedMimes = array("application/pdf", "application/msword", "application/excel", "application/vnd.ms-excel", "application/x-excel", "application/x-msexcel", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			$fileArray = $_FILES["cv"];
			$redirectPath = "/career-opportunities";

			$temp = explode(".", $fileArray["name"]);
			$extension = end($temp);

			if (in_array($fileArray["type"], $allowedMimes) && in_array($extension, $allowedExts) ) {

					if ($fileArray["error"] > 0) {
						header("location: {$redirectPath}?status=uploaderror");
					} else {
			      $d = "uploads/";
			      $de = $d . basename($fileArray['name']);
			  		move_uploaded_file($fileArray["tmp_name"], $de);
						$fileName = $fileArray['name'];
			  		$filePath = $fileArray['tmp_name'];
			    }
			} else {
		  	header("location: {$redirectPath}?status=notvalid");
		  }
		}

		//SENDING EMAIL
		///////////////////////////////////////////////////////////////////////
    require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $subject = "Nuevo CV de " . $nombre . " - lexincorp.com";

    $mail->CharSet = "UTF-8";
    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.sendgrid.net';                 // Specify main and backup server
    $mail->Port = 587;                                    // Set the SMTP port
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'samuelbran';      // SMTP username
    $mail->Password = 'P!nkp4nd4man';           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $mail->From = "no-reply@lexincorp.com";
    $mail->FromName = $nombre;
    $mail->AddReplyTo($email, $nombre);

    $mail->AddAddress("info@lexincorp.com");

    $mail->IsHTML(true); // Set email format to HTML
    $mail->Subject = $subject;

		$mail->Body    = '<div style="padding: 40px; background: #005F99"><br/><br/>';
		$mail->Body 	 .= '<div style="padding: 40px 60px 100px 60px; background: #f9f9f9; border-radius: 10px; font-size: 14px; line-height: 21px;"><br/><br/>';
		$mail->Body    .= '<hr style="border: none; border-bottom:1px solid #d7d7d7;" />';

		$mail->Body    .= '<br><h3 style="color: #333;">'. $subject .'</h3>';
    $mail->Body .= "<strong>Nombre</strong>: " . $nombre . "<br>";
    $mail->Body .= "<strong>Telefono</strong>: " . $telefono . "<br>";
    $mail->Body .= "<strong>Email</strong>: " . $email . "<br>";
    $mail->Body .= "<strong>Empresa</strong>: " . $empresa . "<br><br>";
    $mail->Body .= "<strong>Mensaje</strong>: " . $mensaje . "<br><br>";
    $mail->Body .= "<strong>Fecha/Hora</strong>: " . $fecha . " - ". $hora . "<br><br>";
		$mail->Body    .= '<hr style="border: none; border-bottom:2px solid #d7d7d7;" />';
		$mail->Body    .= '</div></div>';

		if ( !empty($fileArray['name']) ) {
			$mail->AddAttachment($fileArray['tmp_name'], $fileArray['name']);
		}

  	//RETURNING RESULTS
  	///////////////////////////////////////////////////////////////////////
		if ( $mail->Send() ) {
			header("location: {$redirectPath}?status=ok");
		} else {
			header("location: {$redirectPath}?status=error");
		}
	} else {
		header("location: /");
	}
?>