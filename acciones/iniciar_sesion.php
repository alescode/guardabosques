<?php session_start();
 	
	chdir("../");
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./acciones/security.php');

	//Comprobacion del envio del nombre de usuario y password
	
	$user = new usuario();
	$user->login=prepare($_POST['usuario']);
	$user->password=prepare($_POST['clave']);
	$usuario = $user->get(NULL);
	if (!$usuario){
	    session_destroy(); 
		$_SESSION = array();
		echo "<script type=\"text/javascript\">alert(\"Sus datos de ingreso son incorrectos. Verifique su usuario y clave.\");</script>";
	} else if ($usuario[0]->estado != "BLOQUEADO" ){	
			$_SESSION["k_user_id"] = $usuario[0]->user_id;
	} else {
			echo "<script type=\"text/javascript\">alert(\"Su cuenta de usuario ha sido bloqueada, pongase en contacto con el Administrador.\");</script>";
			session_destroy(); 
			$_SESSION = array();
	}

?>
<meta http-equiv="refresh" content="0;url=../"/>

