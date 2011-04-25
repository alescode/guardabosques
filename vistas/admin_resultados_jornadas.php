<?php  session_start();
	
	date_default_timezone_set('America/Caracas');

	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/busqueda.php');
	
		$fecha = $_POST["fecha"];
		$estado_jornada = $_POST["estado_jor"];
		
		$actividad = $_POST["act"];
		
		$estado_usr = $_POST["estado_usr"];
		$cedula = $_POST["cedula"];
		$carnet = $_POST["carnet"];
		$nombre = $_POST["nombres"];
		$apellido = $_POST["apellidos"];
		
		$busquedas = new busqueda();
		$busquedas->limite_inicial = 0;
		$busquedas->actividad_nombre = $actividad;
		$busquedas->jornada_estado = $estado_jornada;
        $busqueda->jornada_fecha = $fecha;
		
		$busqueda->usuario_estado = $estado_usr;
	  //$busqueda->usuario_tipo = $tipo;
        $busqueda->usuario_carnet = $carnet;
        $busqueda->usuario_cedula = $cedula;
        $busqueda->usuario_nombres = $nombre;
        $busqueda->usuario_apellidos = $apellido;
		
		
		$busquedas->limite_final = 10;
		$busquedas = $busquedas->search_jornadas(NULL,NULL);
	
?>

<script>
$(document).ready(function() {
        $("#submit_accion").click(function(){
			document.jornada_estado.submit();
        });   

        $(".editarU").click(function(){
		var idj = $(this).attr("name");
		$('#contenido_center').load('vistas/admin_estudiante.php?usr='+idj);
        });   
	});
</script>
<form id ="jornada_estado"  name="jornada_estado" action="acciones/estado_jornada.php" method="post" enctype="multipart/form-data">
<center>
<div id=bitacoraT style="margin-left: -5px;">
<div id="accion">
	<em>Acci&oacute;n:</em>
	<select  name="accion_jornada" id="accion_jornada">
	    <option id="accion_jornada" SELECTED value="-1">--Seleccione--</option>
		<option id="accion_jornada" value="Aprobar">Aprobar</option>
		<option id="accion_jornada" value="Rechazar">Rechazar</option>					
	</select>
	</div>
<br><br><br> 
<table style="text-align:left;">
		<tr style="text-align:center;"> 
			<td style="width:75px;"> <em>Carnet</em></td>
			<td style="width:290px;"> <em>Actividades de Servicio </em></td>
			<td class="objetivo"><em> 1 </em></td>
			<td class="objetivo"><em> 2 </em></td>
			<td class="objetivo"><em> 3 </em></td>
			<td class="objetivo"><em> 4 </em></td>
			<td class="objetivo"><em> 5 </em></td>
			<td style="width:80px;"><em> Dia </em></td>
			<td style="width:80px;"><em> Hora Inicio<br>Hora Fin</em></td>
			<td style="width:45px;"><em> Horas</em></td>
			<td style="width:70px;"><em> Aprobada </em></td>
		</tr>
		
		<?php
		$cnt = -1;
		foreach ($busquedas as $resultado){ 
            $cnt++;
    		?>
            <tr>
                <td class="usr" name="<?php echo $cnt; ?>"><a id="editarU" class="editarU" href="#" name="<?php echo $resultado->usuario_id;?>"><?php echo $resultado->usuario_carnet; ?> </a></td>
    			<td> <?php echo htmlentities($resultado->actividad_nombre); ?>	
    			</td>
    			
    			
    			<?php
    			
    			
    			for ($k = 0; $k <= 4; $k++){
    				if (substr($resultado->jornada_objetivos,$k,1)=="1"){ ?> <td class="cruz"> X </td>
    				<?php }else {?> <td></td> <?php } 
    			}?>
    				
    			
    			<td><?php echo $resultado->jornada_fecha; ?></td>
    			
    			<td><?php echo date("h:i a",strtotime($resultado->jornada_hi))."<br>".date("h:i a",strtotime($resultado->jornada_hf));  ?></td>
    			
    			<td><?php echo $resultado->jornada_horas; ?></td>
    		
    			<td class="checkI"><?php if ($resultado->jornada_estado == "Aprobada"){?> <img src="./images/aprobado.png" /> <?php }else if ($resultado->jornada_estado == "Rechazada") {?> <img src="./images/rechazada.png" /> <?php }else { echo '<input type="hidden" name="usuario'.$resultado->jornada_id.'" id="escondido" value="'.$resultado->usuario_id.'"/>
																																																													  <input type="hidden" name="horas'.$resultado->jornada_id.'" id="escondido" value="'.$resultado->jornada_horas.'"/>
																																																													  <input type="checkbox" name="jornada[]" id="jornada'.$cnt.'" value="'.$resultado->jornada_id.'" />'; } ?></td>
    		
    		</tr>
			
		<?php
        }
		?>
</table>	
</div>
</center>
<br><br>
    <a id="submit_accion" href="#" ><img src="./images/guardarB.png" style="border:0;" width="100"/></a>

</form>
