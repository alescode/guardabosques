<?php  session_start();
	
	date_default_timezone_set('America/Caracas');

	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/usuario.php');
	
    
    $usuarios = new usuario();
    $usuarios->estado = $_POST["estado_usr"];
    $usuarios->tipo = $_POST["tipo_usr"];
    if ($_POST["carnet"]=="") $usuarios->carnet = $_POST["carnet"];
    if ($_POST["cedula"]=="") $usuarios->cedula = $_POST["cedula"];
    $usuarios->nombres = $_POST["nombres"];
    $usuarios->apellidos = $_POST["apellidos"];
    if (isset($_POST["codigo_carrera"])) { $usuarios->codigo_carrera = $_POST["codigo_carrera"]; }
    if (isset($_POST["lim_med"])) { $usuarios->limitacionesM = $_POST["lim_med"]; }
    if (isset($_POST["lim_fis"])) { $usuarios->limitacionesF = $_POST["lim_fis"]; }
    
	$usuarios = $usuarios->get(NULL);
	
?>


<script>
$(document).ready(function() {
        $(".editarU").click(function(){
		var idj = $(this).attr("name");
		$('#contenido_center').load('vistas/admin_estudiante.php?usr='+idj);
        });   
	});
</script>

<center>
<div id=bitacoraT style="margin-left: -5px;">
<br> 
<table style="text-align:left;">
		<tr style="text-align:center;"> 
			<td style="width:75px;"><em>Carnet</em></td>
			<td style="width:200px;"><em>Nombres y Apellidos </em></td>
			<td style="width:200px;"><em> Carrera </em></td>
			<td style="width:75px;"><em> Horas <br> Aprobadas </em></td>
			<td style="width:75px;"><em> Horas <br> Laboradas </em></td>
			<td style="width:100px;"><em> Tipo de Usuario </em></td>
		</tr>
		<?php
		$cnt = -1;
		foreach ($usuarios as $resultado){ 
            $cnt++;
    		?>
            <tr>
                <td> <a id="editarU" class="editarU" href="#" name="<?php echo $resultado->user_id;?>"> <?php echo $resultado->carnet; ?> </a> </td>
    			<td> <?php echo $resultado->nombres." ".$resultado->apellidos; ?> </td>
                <?php $carreras= usuario::carreras(); ?>
    			<td> <?php echo $carreras[''.$resultado->codigo_carrera]; ?> </td>
    			<td> <?php echo $resultado->horas_aprobadas;  ?></td>
    			<td> <?php echo $resultado->horas_laboradas;  ?></td>
    			<td> <?php echo $resultado->tipo;  ?></td>
    		</tr>
            <?php
        }
		?>
</table>	
</div>
</center>