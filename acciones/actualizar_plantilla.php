<?php session_start();
	
	chdir("../");
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./acciones/security.php');
	$foto_path = "fotos/";
	$foto_path = $foto_path.basename($_SESSION["k_user_id"].".jpg"); 
	$usuario = new usuario();
	$usuario->user_id = $_SESSION["k_user_id"];
	$usuario = $usuario->get(NULL);
	$usuario=$usuario[0];
	$usuario->nombres=$_POST['nombres'];
	$usuario->apellidos=$_POST['apellidos'];
	if ($usuario->tipo=='Estudiante'){
		$usuario->carnet=$_POST['carnet'];
	    $usuario->fecha_inicio=date('Y-m-d', strtotime( $_POST['fecha_inicio']));
	    $usuario->codigo_carrera=$_POST['codigo_carrera'];
		$usuario->limitacionesM=$_POST['limitacionesM'];
	    $usuario->limitacionesF=$_POST['limitacionesF'];
	    $usuario->agrupaciones=$_POST['agrupaciones'];
		if ($_POST['servicio_extra0']==""){$usuario->servicio_extra=NULL;}else{ $usuario->servicio_extra=array($_POST['servicio_extra0'],(int)$_POST['servicio_extra1']);}
	
	}
	$usuario->cedula=$_POST['cedula'];
	if (!($_POST['correo_nuevo_1']=='')) {$usuario->email=$_POST['correo_nuevo_1'];}
	if (!($_POST['clave1']=='')) { $usuario->password= $_POST['clave1']; } else { $usuario->password=NULL; }
	$usuario->tlf1=$_POST['tlf1'];
	$usuario->tlf2=$_POST['tlf2'];
	
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $foto_path)){
		//$usuario->foto=$foto_path;
		$usuario->foto=$_SESSION["k_user_id"];
	}
	
	
	$usuario->direccion=$_POST['direccion'];
	

	$usuario->update(NULL);
?>
<meta http-equiv="refresh" content="0;url=../"/>