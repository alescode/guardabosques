<?php session_start();
 	function createRandomPassword() {
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$pass = '' ;
		for ($i = 0; $i < 8; $i++) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
		}
		return $pass;
	}
	
	/**function emailUsuario($username,$password,$email,$subject,$content) {
		$mail = new PHPMailer();

		$mail->Username = "guardabosquesusb@gmail.com";
		$mail->Password = "bucare2008";
		$mail->From = "guardabosquesusb@gmail.com";
		$mail->FromName = "Guardabosques USB";
		$mail->Subject = $subject;


		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		//$mail->AltBody = "Hola, te doy mi nuevo numero\nxxxx.";

		$mail->MsgHTML($content);

		//    $mail->AddAttachment("files/files.zip");
		//      $mail->AddAttachment("files/img03.jpg");


		$mail->AddAddress($email, "Destinatario");
		$mail->IsHTML(true);
		if(!$mail->Send()) {
			echo "Error: " . $mail->ErrorInfo;
		} else {
			echo "Mensaje enviado correctamente";
		}
	}*/
	
	
	chdir("../");
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./acciones/security.php');
    include ('./acciones/notificacion.php');

	//Comprobacion del envio del nombre de usuario y password
	
	$user = new usuario();
	$user->user_id=prepare($_SESSION["k_user_id"]);
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];
	if ($usuario->tipo =="Coordinador"){
		$size = $_POST['escondido'];
		$usuarios=Array();
		$cnt=0;
		for ($i = 0; $i < $size; $i++){
			if ($_POST['usbid'.$i] && $_POST['correo'.$i]) {
				$usr = new usuario();
				$usr->login=$_POST['usbid'.$i];
				$usr->password="hola";  //createRandomPassword();
				$usr->email=$_POST['correo'.$i];
				$usr->tipo=$_POST['tipo'.$i];
                $usr->estado="Activo";
				$usuarios[$cnt]=$usr;
				$cnt++;
			}
		}
		
        usuario::save($usuarios);
        //( $To, $ToName, $From, $FromPass, $FromName, $Subject, $Content, $Attachments)
		/*foreach($usuarios as $usuario)
            notificacion( $usuario->email, $usuario->nombres."".$usuario->apellidos, "servicioguardabosqueusb@gmail.com", "bucare2008", "Sistema de Bitacoras Guardabosques USB", "Ingreso al Sistema", "Bienvenido al Sistema de Bitacoras de los Guardabosques de la USB.<br><br>Su informaci&oacute;n de acceso es:<br>&nbsp;&nbsp;- Usuario: ".$usuario->login."<br>&nbsp;&nbsp;- Clave: ".$usuario->password, NULL);
	    */
	}

?>
<meta http-equiv="refresh" content="0;url=../"/>

