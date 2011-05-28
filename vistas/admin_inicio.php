<?php 
	chdir("../");
	if (!(isset($_SESSION["k_user_id"]))) {
		
		session_start();
		
		include ('./BD/query.php');
		include ('./clases/usuario.php');
	}
	
	
	
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];

	
?>

<script>
$(document).ready(function() {
        $('#editarPerfil_admin').click(function(){
			$('#contenido_center').load('vistas/plantilla_admin.php');
        });   
	});

</script>




<h2> <?php echo $usuario->nombres."&nbsp"?>   <?php echo $usuario->apellidos?></h2>

<div id="ficha">
<center>
<table>
		<tr>
               <td><em>Carnet: </em><?php echo $usuario->carnet?> </td>
               <td><em>C&eacute;dula: </em><?php echo $usuario->cedula?></td>
			   <td rowspan="4" style="width:230px; text-align:center;"> <?php $ss = "./fotos/".$usuario->foto.".jpg"?> <img src="<?php echo $ss?>"  height="150" width="150"/></td>
               </tr>

       <tr>
               <td><em>Tel&eacute;fono 1: </em><?php echo $usuario->tlf1?> </td>
               <td><em>Tel&eacute;fono 2: </em><?php echo $usuario->tlf2?></td>
               
       </tr>
       
       <tr>
               <td colspan="2"><em>E-mail: </em><?php echo $usuario->email?> </td>
       </tr>
       
       <tr>
			<td colspan="2";><em>Zona de residencia: </em><?php echo $usuario->zona ?></td>
	   </tr>
	
	<tr>
		<td colspan="2"; rowspan="2"; class="editarb"> <a id="editarPerfil_admin" href ="#"> <img src="./images/editarB.png" style="border:0;" width="100"/> </a> </td>
		<td><em>Tipo: </em><?php echo $usuario->tipo ?></td>
	</tr>
	
	<tr>
		<td><em>Estado: </em><?php echo $usuario->estado ?></td>
	</tr>
</table>
</div>
