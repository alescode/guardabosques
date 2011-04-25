<?php  session_start();
	
	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./clases/jornada.php');
	include ('./clases/actividad.php');
	include ('./pdf/class.ezpdf.php');

	echo '<p align="center">
		<img src="../images/loading.gif"  height="400" width="400" border="0" />
		<br>Generando PDF, por favor espere...</p>';
	
function obtener_jornadas(){
	$resultado = array();	
	
	$jornada = new jornada();
	$jornada->estado = "Aprobada";
    $jornada->user_id = $_SESSION["k_user_id"];
    $jornadas = $jornada->get(NULL);	

	$actividad= new actividad();
	$actividades = $actividad->get(NULL);
	
	$i = 0;
	foreach ($jornadas as $jornada){ 
		$actividadesdeservicio="";
		$j = -1;
		$jlen = count($jornada);
		foreach ($jornada->list_realiza as $realiza) {
				$j++;
				$actividadesdeservicio.= $actividades[$realiza->act_id]->nombre.
				(($realiza->desc) ?
				" (".$realiza->desc.")" : "").(($j==$jlen)? "." : ", ");
		}
		
		$obj0 = substr($jornada->objetivos,0,1) == 1 ? "X" : " ";
		$obj1 = substr($jornada->objetivos,1,1)== 1 ? "X" : " ";
		$obj2 = substr($jornada->objetivos,2,1)== 1 ? "X" : " ";
		$obj3 = substr($jornada->objetivos,3,1)== 1 ? "X" : " ";
		$obj4 = substr($jornada->objetivos,4,1)== 1 ? "X" : " ";
		
		$resultado[$i]= array(
			'actividad'=>$actividadesdeservicio,
			'obj0'=>$obj0,'obj1'=>$obj1,'obj2'=>$obj2,'obj3'=>$obj3,'obj4'=>$obj4,
			'fecha'=>$jornada->fecha,
			'hora'=>$jornada->list_realiza[0]->hora_inicio." a ".$jornada->list_realiza[$j]->hora_fin,
			'duracion'=>$jornada->horas
		);
		$i++;
	}
	
	return $resultado;
}

//////////////////////////////////////////////////////////////////////////////



function generar_pdf(){
//////////////////////////////ENCABEZADO////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];	

	error_reporting(0);  
	 
	$nombre = $usuario->nombres." ".$usuario->apellidos;
	$carnet = $usuario->carnet;
	
	//$nombre = "Maximiliano Rondon";
	$carrera = "Ingenieria de la Computacion";


	$pdf = new Cezpdf('LETTER');
	$pdf->selectFont('./pdf/fonts/Helvetica.afm');
	$pdf->ezSetCmMargins(2,2,2,2);
	$datacreator = array (
					'Title'=>$carnet." - Bitacora",
					'Author'=>"Guardabosques USB",
					'Subject'=>"Servicio Comunitario",
	);
	$pdf->addInfo($datacreator);
	
	$pagelen = $pdf->ez['pageWidth']-$pdf->ez['leftMargin']-$pdf->ez['rightMargin'];
	$pdf->ezImage("./images/longLogo.jpg",0,$pagelen,"none","left");

	$pdf->ezText("<b>BITACORA</b>\n",14,array('justification' => 'center'));

	
//////////////////////////////DATOS PERSONALES//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
	$pdf->ezText("Estudiante: <b>".$nombre.
				 "</b>\nCarnet: <b>".$carnet.
				 "</b>\nCarrera: <b>".$carrera."</b>\n",10,array('justification' => 'left'));

				 
//////////////////////////////GENERANDO TABLA //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
	$data = obtener_jornadas($nombre);	
	
	$pdf->ezTable($data,array(
						'actividad'=>'<b>Actividad</b>',
						'obj0'=>'<b>1</b>','obj1'=>'<b>2</b>','obj2'=>'<b>3</b>','obj3'=>'<b>4</b>','obj4'=>'<b>5</b>',
						'fecha'=>'<b>Dia</b>',
						'hora'=>"<b>Hora Inicio -\nHora Fin</b>",
						'duracion'=>'<b>Duracion</b>'
					), "",
					array('width' =>$pagelen)
	);
	

/////////////////////////////AUTORIZACION //////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
	$total = 0;
	foreach ($data as $row){
		$total +=$row["duracion"];
	}
	$pdf->ezText("\nTotal: <b>".$total." horas.</b>\n",10,array('justification' => 'right'));

	$pdf->line($pdf->ez['leftMargin']+135,
				$pdf->y-60,
				$pdf->ez['leftMargin'],
				$pdf->y-60);
	$pdf->ezText("\n\n\n\n\nFIRMA DEL COORDINADOR",10,array('justification' => 'left'));
					
	
/////////////////////////////FINALIZACION///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
	$pdfText = $pdf->ezOutput(1);
	$filename =$carnet.".pdf";
	$path = "./bitacoras/";
	$file = fopen($path.$filename,"w");
	fprintf($file,"%s",$pdfText);
	fclose($file);
	
	return $path.$filename;
}
	//if (isset($_SESSION["k_username"])) {
	
		$file = generar_pdf($_SESSION["k_username"]);
		echo '<meta http-equiv="Refresh" content="0;url=../'.$file.'">';

	//}

?>