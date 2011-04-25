<?php session_start();

	chdir("../");
	include ('./BD/query.php');
	include ('./clases/jornada.php');
	//include ('./clases/realiza.php');
	include ('./acciones/security.php');

    $size= $_POST["size"];
	$fecha=date('Y-m-d', strtotime( $_POST["date"]));



    $jornada= new Jornada();
    $jornada->jornada_id=$_SESSION["id_jornada"];
	$jornada=$jornada->get(NULL);
	$jornada=$jornada[0];
	
	//Recolectamos los atributos de la plantilla actual
	$objetivos="00000";
	$arreglo_obj= $_POST["objetivo"];
	if(!(empty($arreglo_obj))){
		foreach($arreglo_obj as $obj){
		  $objetivos[$obj]='1';
		}
	}
	$actividades;
	$horas=0;
	$i_a=0;
	for($i=0; $i<$size; $i++){
	    
		if (isset($_POST["actividad".(int)$i.""])){
			$actividad_id=$_POST["actividad".(int)$i.""];
			if($actividad_id!=-1){
				$actividad_id=$_POST["actividad".(int)$i.""][5];
				$descripcion=$_POST["descripcion".$i];
				$hora_ini=(($_POST["h_i_".$i]<10)?"0":"").$_POST["h_i_".$i].":".(($_POST["m_i_".$i]<10)?"0":"").$_POST["m_i_".$i].":00";
				$hora_fin=$_POST["h_f_".$i].":".$_POST["m_f_".$i].":00";
				$actividades[$i_a]= array($actividad_id,$hora_ini,$hora_fin,$descripcion);
				$i_a=$i_a+1;
				$horas= $horas + (($_POST['h_f_'.$i]+($_POST['m_f_'.$i]/60))-($_POST['h_i_'.$i]+($_POST['m_i_'.$i]/60)));
			}
		}
	}
	//for de ver cuales son update cuales delete y cuales inserts
	$deletes=array();
	$inserts=NULL;
	$updates=array();
	$i_u=0;
	$i_i=0;
	$i_d=0;
	
	for( $i=0 ; $i<count($actividades) ; $i++ ){
	
		$act=$actividades[$i];
		$esta=false;
		foreach ( ($jornada->list_realiza) as $realiza_id ){
		    
			/*
				$realiza= new realiza();
				$array= $jornada->list_realiza;
				echo $array[0];
				$realiza->realiza_id=$realiza_id;
				$realiza=$realiza->get(NULL);
				$realiza=$realiza[0];
			*/
			
			
		   if ($act[0]==$realiza_id->act_id){ 
				$esta=true;
				$updates[$i_u]=array($realiza_id->realiza_id , $act[1] , $act[2] , $act[0], $act[3]);
				$i_u=$i_u+1;
			}
		}
		if (!$esta){
		   $inserts[$i_i]=$actividades[$i];
		   $i_i=$i_i+1;
		}
	}
	
	foreach ( $jornada->list_realiza as $realiza_id ){
		    
		/*
			$realiza= new realiza();
			$realiza->realiza_id=$realiza_id;
			$realiza=$realiza->get(NULL);
			$realiza=$realiza[0];
		*/	
		$elim=true;
		
		for( $i=0 ; $i<count($actividades) ; $i++ ){
		  $act=$actividades[$i];
		  if ($act[0]==$realiza_id->act_id){ $elim=false;}
		}
		if ($elim){ 
			$deletes[$i_d]=$realiza_id->realiza_id;
			$i_d=$i_d+1;
		}
	}
	
	
	//$array1=array($_SESSION["k_user_id"],$fecha,$horas,$objetivos);
	$horas_objetivos=array($horas,$objetivos);
	$jornada::update($jornada->jornada_id,$horas_objetivos,$inserts,$deletes,$updates);
	$_GET["id_jornada"]=NULL;

?>
<meta http-equiv="refresh" content="0;url=../"/>