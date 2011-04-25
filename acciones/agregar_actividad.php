<?php session_start();

	chdir($_SESSION["path"]);
	
	include ('./BD/query.php');
	include ('./clases/actividad.php');
	include ('./clases/usuario.php');

	$user = new usuario();
	$user->user_id=$_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];
	
	if ($usuario->tipo =="Coordinador"){
		$size = $_POST['escondido'];
		$actividades=Array();
		$cnt=0;
		for ($i = 0; $i < $size; $i++){
		
			if ($_POST['nombre_act'.$i]) {
				$actividad = new actividad();
				$actividad->nombre=$_POST['nombre_act'.$i];
				
				
				$objetivos="00000";
       
	   
				$arreglo_obj= $_POST["object_act".$i];
				echo $arreglo_obj;
				if (!empty($arreglo_obj)){
    				foreach($arreglo_obj as $obj){
    					$objetivos[$obj-1]='1';
    				}
				}
				$actividad->objetivos=$objetivos;
				
				$actividades[$cnt]=$actividad;
				$cnt++;
			}
		}
		
		if (!empty($actividades)){
        actividad::save($actividades);}
	
	}
	
?>
<meta http-equiv="refresh" content="0;url=../"/>