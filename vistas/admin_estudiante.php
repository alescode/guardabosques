<?php session_start();
	
	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/usuario.php');

	
	if ((isset($_GET["usr"]))) {
		$user = new usuario();
		$user->user_id = $_GET["usr"];
		$usuario = $user->get(NULL);
		$usuario = $usuario[0];
	
	
?>

	
	
<h2> <?php echo $usuario->nombres."&nbsp"?>   <?php echo $usuario->apellidos?></h2>

<div id="ficha">
<center>
<table>
		<tr>
               <td><em>Horas laboradas: </em><?php echo $usuario->horas_laboradas?> </td>
               <td><em>Horas aprobadas: </em><?php echo $usuario->horas_aprobadas?></td>
			   <td rowspan="4" style="width:230px; text-align:center;"> <?php $ss = "./fotos/".$usuario->foto.".jpg"?> <img src="<?php echo $ss?>"  height="150" width="150"/></td>
               </tr>

       <tr>
               <td><em>Carnet: </em><?php echo $usuario->carnet?> </td>
               <td><em>Carrera: </em><?php echo $usuario->codigo_carrera?></td>
               
       </tr>
       
       <tr>
               <td colspan="2"><em>C&eacute;dula: </em><?php echo $usuario->cedula ?></td>
       </tr>
       
       <tr>
			<?php
				if ($usuario->tlf2) { 
			?>
			<td><em>Tel&eacute;fono1: </em><?php echo $usuario->tlf1 ?></td>
			<td><em>Tel&eacute;fono2: </em><?php echo $usuario->tlf2 ?></td>
			<?php
			} else { 
			?>
			<td colspan="2"><em>Tel&eacute;fono1: </em><?php echo $usuario->tlf1 ?></td>
			<?php } ?>
	   </tr>
	
	<tr>
		<td colspan="2"><em>E-mail: </em><?php echo $usuario->email ?></td>
		<td><em>Tipo: </em><?php echo $usuario->tipo ?></td>
	</tr>
	
	<tr>
		<td colspan="2"><em>Direcci&oacute;n: </em><?php echo $usuario->direccion ?></td>
		<td><em>Estado: </em><?php echo $usuario->estado ?></td>
	</tr>
	
	<tr> <td colspan="2"><em>Limitaciones F&iacute;sicas: </em>
		<?php if ($usuario->limitacionesF){ echo $usuario->limitacionesF; } ?>
		</td>
		<td><em>Fecha de inicio: </em><?php echo $usuario->fecha_inicio ?></td>
	</tr>
	
	<tr> <td colspan="2"><em>Limitaciones M&eacute;dicas: </em>
		<?php if ($usuario->limitacionesM){ echo $usuario->limitacionesM; } ?>
		</td>
		<td><em>Fecha de culminaci&oacute;n: </em><?php echo $usuario->fecha_fin ?></td>
	</tr>
	
	<tr> <td colspan="2"><em>Agrupaciones: </em>
		<?php if ($usuario->agrupaciones){ echo $usuario->agrupaciones; } ?>
		</td>
	</tr>		
	
	<tr> <td colspan="2"><em>Otro servicio comunitario: </em>
		<?php if ($usuario->servicio_extra){ echo $usuario->servicio_extra[0]."&nbsp &nbsp <em>Horas: </em>".$usuario->servicio_extra[1]; }?>
		</td>
	</tr>
</table>
</div>
<br>
<br>
<?php }?>
