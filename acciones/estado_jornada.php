<?php  session_start();

	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/jornada.php');

	$arreglo_jornadas= $_POST["jornada"];

	if (isset($_POST["accion_jornada"])){
		if ($_POST["accion_jornada"]!=-1){	
			if(!(empty($arreglo_jornadas))){
				foreach($arreglo_jornadas as $obj){
				
					$jornada= new Jornada();
					$jornada->jornada_id=$obj;
					$jornada->horas= $_POST["horas".$obj];
					$jornada->user_id=$_POST["usuario".$obj];
					
					if ($_POST["accion_jornada"]=="Aprobar"){
						$jornada->estado="Aprobada";
						
					}elseif($_POST["accion_jornada"]=="Rechazar"){
						$jornada->estado="Rechazada";
					}
					$jornada->updateAdmin();
				}
			}
		}
	}
?>
<meta http-equiv="refresh" content="0;url=../"/>