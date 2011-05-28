<?php if (!(isset($_SESSION["k_user_id"]))) {
		session_start();
	}?>
<div id="principal_top"></div>
<div id="principal_center"> 

<div id="menu">
<?php 
	$_SESSION["path"]=getcwd();
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];

	if($usuario->tipo == "Coordinador"){
		if($usuario->complete_admin()){
			include "menu_admin.php";
		}else{
			include "menu_basico.php";
		}
	}else{
		if($usuario->tipo == "Estudiante"){
			if($usuario->complete()){
				include "menu_usuario.php";	
			}
			else{
					include "menu_basico.php";
			}
		}
	}
?>
</div>

<div id="contenido_top">
</div>

<div id="contenido_center">	
<?php 
	
	if($usuario->tipo == "Coordinador"){
		if($usuario->complete_admin()){
			include "admin_inicio.php";
		}else{
			include "plantilla_admin.php";
		}
	}else{
		if($usuario->tipo == "Estudiante"){
			if($usuario->complete()){
				include "estudiante_inicio.php";	
			}
			else{
					include "plantilla.php";
			}
		}
	}
	/*if ($usuario->tipo == "Coordinador") {
		include "admin_inicio.php";
	} else if ($usuario->tipo == "Estudiante" && $usuario->complete()) {
		include "estudiante_inicio.php";
	}else{
	   include "plantilla.php";
	}*/
?>
</div>

<div id="contenido_bottom">
</div>

</div>
<div id="principal_bottom"></div>
