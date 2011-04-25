<?php  session_start();
	
	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	include ('./clases/jornada.php');
	include ('./clases/actividad.php');
	
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];	

	$jornada= new jornada();
    $jornada->user_id = $_SESSION["k_user_id"];
    $jornadas = $jornada->get(NULL);
	
?>

<script>
$(document).ready(function() {
        $(".editarJ").click(function(){
		var idj = $(this).attr("name");
		$('#contenido_center').load('vistas/estudiante_jornada.php?idj='+idj);
        });   
	});
</script>


<h2> Bit&aacute;cora </h2>




<div id=bitacoraT>
<table>
		<tr> 
			<td style="width:150px;"><em>Estudiante </em><br><br> <?php echo htmlentities($usuario->nombres)."&nbsp;".htmlentities($usuario->apellidos)."<br><br>".$usuario->carnet;?></td>
			<td><em>Vinculada con Objetivo </em><br><br> 1. Educaci&oacute;n y sensibilizaci&oacute;n a visitantes y vecinos de la USB 
										 <br> 2. Manejo y restauraci&oacute;n ambiental
										 <br> 3. Protecci&oacute;n ambiental y de los visitantes
										 <br> 4. Seguimiento e informaci&oacute;n ambiental
										 <br> 5. Institucionalizaci&onacute; y promoci&oacute;n del programa<br>
			<td style="width:250px;"><em><center>Ejecuci&oacute;n</center></em></td>
			<td><em> Supervisor <em></td>
		</tr>
</table>
<table>



		<tr> 
			<td style="width:324px;"> <em>Actividades de Servicio </em></td>
			<td class="objetivo"><em> 1 </em></td>
			<td class="objetivo"><em> 2 </em></td>
			<td class="objetivo"><em> 3 </em></td>
			<td class="objetivo"><em> 4 </em></td>
			<td class="objetivo"><em> 5 </em></td>
			<td style="width:80px;"><em> D&iacute;a </em></td>
			<td style="width:90px;"><em> Hora inicio y fin </em></td>
			<td style="width:73px;"><em> Total horas </em></td>
			<td style="width:72px;"><em> Firma </em></td>
		</tr>
		
		
		<?php
		
		$actividad= new actividad();
		$actividades = $actividad->get(NULL);
		
		
		foreach ($jornadas as $jornada){ 
			$j = -1;
			$actividadesdeservicio="";
			$jlen = count($jornada);
			foreach ($jornada->list_realiza as $realiza) {
				$j++;
				$actividadesdeservicio.= $actividades[$realiza->act_id]->nombre.
				(($realiza->desc) ?
				" (".$realiza->desc.")" : "").(($j==$jlen)? "." : ", ");
			}
		?>
		<tr> 
			<td> <?php echo htmlentities($actividadesdeservicio); ?>	
			</td>
			
			
			<?php
			
			
			for ($k = 0; $k <= 4; $k++){
				if (substr($jornada->objetivos,$k,1)=="1"){ ?> <td class="cruz"> X </td>
				<?php }else {?> <td></td> <?php } 
			}?>
				
			
			<td><?php echo $jornada->fecha; ?></td>
			
			<td><?php echo $jornada->list_realiza[0]->hora_inicio." a ".$jornada->list_realiza[$j]->hora_fin;  ?></td>
			
			<td><?php echo $jornada->horas; ?></td>
		
			<td class="checkI"><?php if ($jornada->estado == "Aprobada"){?> <img src="./images/aprobado.png" /> <?php }else if ($jornada->estado == "Rechazada") {?> <img src="./images/rechazada.png" /> <?php }else { ?> <a id="editarJ" class="editarJ" href="#" name="<?php echo $jornada->jornada_id;?>"><img src="./images/editable.png"  border="0" /></a><?php } ?></td>
		
		</tr>
			
			
			
			
			
			<?php
			}
			?>
</table>
	<a href="./acciones/jornada_pdf.php" target="blank" border="0">
	<br>
		<img src="./images/pdf.png"   border="0" />		
	</a>
</div>