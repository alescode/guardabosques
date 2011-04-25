<?php
    require("./acciones/PHPMailer/class.phpmailer.php");
	function notificacion( $To, $ToName, $From, $FromPass, $FromName, $Subject, $Content, $Attachments) {
		$mail = new PHPMailer();

		$mail->Username = $From;
		$mail->Password = $FromPass;
		$mail->From = $FromPass;
		$mail->FromName = $FromName;
		$mail->Subject = $Subject;

		$mail->IsSMTP();
		$mail->SMTPAuth = true;
$mailer->Host = 'ssl://smtp.gmail.com:465';
	//	$mail->SMTPSecure = "ssl";
		//$mail->Host = "smtp.gmail.com";
		//$mail->Port = 465;
		//$mail->AltBody = "Hola, te doy mi nuevo numero\nxxxx.";

		//$mail->MsgHTML($Content);
		$mail->Body=$Content;
        
        /*foreach($Attachments as $Attach) {
            $mail->AddAttachment("files/files.zip");
		}*/


		$mail->AddAddress($To, $ToName);
		$mail->IsHTML(true);
		if(!$mail->Send()) {
			echo "Error: " . $mail->ErrorInfo;
		} else {
			echo "Mensaje enviado correctamente";
		}
	}
?>