<?php session_start();
	
    require($_SERVER['DOCUMENT_ROOT'].'/guardabosques/acciones/mail/correos.php');
	chdir("../");
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./acciones/security.php');
	include ('./lib/utilities.php');

	//Comprobacion del envio del nombre de usuario y password
	$user = new usuario();
	$user->user_id=prepare($_SESSION["k_user_id"]);
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];
	if ($usuario->tipo =="Coordinador"){
		$size = $_POST['escondido'];
		$usuarios=Array();
		$cnt=0;
		
		//@2
		
		
		for ($i = 0; $i < $size; $i++){
			if ($_POST['usbid'.$i] && $_POST['correo'.$i]) {
				$usr = new usuario();
				$usr->login=$_POST['usbid'.$i];
				$usr->password=createRandomPassword();
				$usr->email=$_POST['correo'.$i];
				$usr->tipo=$_POST['tipo'.$i];
                $usr->estado="Activo";
				$usuarios[$cnt]=$usr;
				$cnt++;
                enviarCorreoDeRegistro($usr->email, $usr->login, $usr->password);
			}
		}
		
        usuario::save($usuarios);
        //( $To, $ToName, $From, $FromPass, $FromName, $Subject, $Content, $Attachments)
	}

?>
<meta http-equiv="refresh" content="0;url=../"/>

