<?php  session_start();
	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/busqueda.php');
	include ('./clases/usuario.php');	
?>

<h2> Bùsquedas </h2>

<div id="tabs" style="width:95%;margin-left:25px ;font-size:75%">
   <center>
	   <ul>
			<li><a href="#tab-usr"><span>Búsqueda de Usuarios</span></a></li>
			<li><a href="#tab-jor"><span>Búsqueda de Jornadas</span></a></li>
			<li><a href="#tab-res"><span>Resultados</span></a></li>
		</ul>
	</center>
    <div id="tab-usr">
     <div id="ficha" class="busqueda"> <br>
	  <form  action="vistas/admin_resultados_estudiantes.php" method="post" id="buscar_usr" name="buscar_usr" enctype="multipart/form-data" >
	 <center> <table>
	  <tr>
		<td class="busqueda"><em>Estado Usuario:</em>
			<select name="estado_usr">
				<option id="Activo" selected > Activo </option>';
				<option id="Inactivo" value='Aprobada' > Inactivo </option>';
				<option id="Bloqueado" value='Reachazada' > Bloqueado </option>';
			</select> <br>
		</td>
		<td class="busqueda"><em>Tipo:</em>
			<select name="tipo_usr">
				<option value= "Coordinador">Coordinador</option>
				<option value= "Estudiante" selected>Estudiante Inscrito</option>
				<option value= "Estudiante_No">Estudiante No Inscrito</option>
			</select> <br>
		</td>	
	   </tr>
		<tr>
			<td class="busqueda"><em>Carnet:</em>
				<input type="text" name="carnet" id="act" /> <br>
			</td>
			<td class="busqueda"><em>Cedula:</em>
				<input type="text" name="cedula" id="act" /> <br>
			</td>
		</tr><tr>	
			<td class="busqueda"><em>Nombres:</em>
				<input type="text" name="nombres" id="act" /> <br>
			</td>
			<td class="busqueda"><em>Apellidos:</em>
				<input type="text" name="apellidos" id="act" /> <br>
			</td>
		</tr>
		<tr>
			<td class="busqueda" colspan="2"><em>Carrera:</em>
				<?php $carreras= usuario::carreras(); ?>
				<select  name="codigo_carrera">
					<option id="codigo_carrera" value="" SELECTED>-Seleccionar-</option>';
					<?php foreach( $carreras as $codigo => $name){
						echo '<option id="codigo_carrera" value="'.$codigo.'" >'.$name.'</option>';
					} ?>
				</select> <br>
			</td>
		</tr><tr>	
			<td><em>Limitaciones:</em><br>
				<input type="checkbox" name="lim_med" value="m" /> M&eacute;dicas
				<input type="checkbox" name="lim_fis" value="f" /> F&iacute;sicas <br> <br>
			</td>
		
		<td class="busqueda">
		<center><a id="submit_search_usr" href="#" ><img src="./images/search.png" style="border:0;" /></a></center>
		</td>
		</tr>
		</table></center>
	   </form>
	   </div>

    </div>
    <div id="tab-jor">
		<div id="ficha" class="busqueda"> <br>
		<form  action="vistas/admin_resultados_jornadas.php" method="post" id="buscar_jornada" name="buscar_jornada" enctype="multipart/form-data" > 
			<center>
			 <table>
				 <tr>
					<td class="busqueda"><em>Nombres:</em>
						<input type="text" name="nombres" id="act" /> <br>
					</td>
					<td class="busqueda"><em>Actividad:</em>
						<input type="text" name="act" id="act" /> <br>
					</td>
				</tr>
				 <tr>	
					<td class="busqueda"><em>Apellidos:</em>
						<input type="text" name="apellidos" id="act" /> <br> <br>
					</td>
					<td><em>Estado Jornada:</em>
						<select name="estado_jor">
							<option  value='Pendiente'  > Pendiente </option>';
							<option  value='Aprobada' > Aprobada </option>';
							<option  value='Reachazada' > Rechazada </option>';
							<option  value='' selected='SELECTED'> Ver todas </option>';

						</select>
					</td>
				 </tr>
				 <tr>
					<td class="busqueda"><em>Cedula:</em>
						<input type="text" name="cedula" id="act" /> <br>
					</td>
					<td class="busqueda" ><em>Fecha:</em>
						<div id="datepicker" style="float:left"> </div> <input type="text" id="date" name="fecha" readonly="true" size="8" /> <br>
					</td>
				 </tr>
				 <tr>
						<td class="busqueda"><em>Carnet:</em>
						<input type="text" name="carnet" id="act" /> <br>
					</td>
					<td class="busqueda" rowspan="3"><center><a id="submit_search_jor" href="#" ><img src="./images/search.png" style="border:0;" /></a></center>
					</td>
				 </tr>
				 <tr>
					<td class="busqueda"><em>Tipo:</em>
						<select name="tipo_usr">
							<option value= "Coordinador">Coordinador</option>
							<option value= "Estudiante" selected>Estudiante Inscrito</option>
							<option value= "Estudiante_No">Estudiante No Inscrito</option>
						</select> <br>
					</td>
				 </tr>
				 <tr>
					<td class="busqueda"><em>Estado Usuario:</em>
						<select name="estado_usr">
							<option id="Activo" selected > Activo </option>';
							<option id="Inactivo" value='Aprobada' > Inactivo </option>';
							<option id="Bloqueado" value='Reachazada' > Bloqueado </option>';
						</select>
					</td>
				 </tr>
			</table>
		</form>		
		</div>
    </div>
    <div id="tab-res">
		<div id="resultados"><h1>No ha realizado ninguna búsqueda aún. </h1></div>
    </div>
</div>



<script type="text/javascript" src="js/estudiante_jornada.js"></script>
<script>
 
$('#submit_search_jor').click(function() { // catch the form's submit event - should I use the form id?
    $.ajaxSetup({ 
    	        scriptCharset: "utf-8" , 
    				        contentType: "application/json; charset=utf-8"
    });

    $.ajax({ // create an AJAX call...
        data: $("#buscar_jornada").serialize(), // get the form data
        type: $("#buscar_jornada").attr('method'), // GET or POST
        url: $("#buscar_jornada").attr('action'), // the file to call
        success: function(response) { // on success..
            $('#resultados').html(response); // update the DIV - should I use the DIV id?
			$('#tabs').tabs('select', '#tab-res');
        }
	});
	return false; // cancel original event to prevent form submitting
});

$('#submit_search_usr').click(function() { // catch the form's submit event - should I use the form id?
    $.ajax({ // create an AJAX call...
        data: $("#buscar_usr").serialize(), // get the form data
        type: $("#buscar_usr").attr('method'), // GET or POST
        url: $("#buscar_usr").attr('action'), // the file to call
        success: function(response) { // on success..
            $('#resultados').html(response); // update the DIV - should I use the DIV id?
			$('#tabs').tabs('select', '#tab-res');
        }
	});
	return false; // cancel original event to prevent form submitting
});
 

$(document).ready(function() {
	$("#tabs").tabs();
});
</script>


