<?php session_start();

	chdir("../");
	include ('./BD/query.php');
	include ('./clases/jornada.php');
	include ('./acciones/security.php');

    $size= $_POST["size"];
	$fecha=date('Y-m-d', strtotime( $_POST["date"]));
	$jornada= new Jornada();
    $objetivos="00000";
	$arreglo_obj= $_POST["objetivo"];
	if(!(empty($arreglo_obj))){
		foreach($arreglo_obj as $obj){
		  $objetivos[$obj]='1';
		}
	}
	$actividades;
	$horas=0;
		
	for($i=0; $i<$size; $i++){
	    
        $actividad_id=$_POST["actividad".(int)$i.""];
		if($actividad_id!=-1){
		    $actividad_id=$_POST["actividad".(int)$i.""][5];
			$descripcion=$_POST["descripcion".$i];
			$hora_ini=(($_POST["h_i_".$i]<10)?"0":"").$_POST["h_i_".$i].":".(($_POST["m_i_".$i]<10)?"0":"").$_POST["m_i_".$i].":00";
			$hora_fin=$_POST["h_f_".$i].":".$_POST["m_f_".$i].":00";
			$actividades[$i]= array($actividad_id,$hora_ini,$hora_fin,$descripcion);
			$horas= $horas + (($_POST['h_f_'.$i]+($_POST['m_f_'.$i]/60))-($_POST['h_i_'.$i]+($_POST['m_i_'.$i]/60)));
		}
	}
	$array1=array($_SESSION["k_user_id"],$fecha,$horas,$objetivos);
	$jornada::save($array1,$actividades);

?>
<meta http-equiv="refresh" content="0;url=../"/>