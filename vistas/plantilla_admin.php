<?php
	if (!(isset($_SESSION["k_user_id"]))) {
		session_start();
		chdir($_SESSION["path"]); 
		include ('./BD/query.php');
		include ('./clases/usuario.php');
	}else{
	 	chdir($_SESSION["path"]); 
    }


//Variables
	
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];
	
$_POST['nombres']=$usuario->nombres;
$_POST['apellidos']=$usuario->apellidos;
$_POST['carnet']=$usuario->carnet;
$_POST['password']=$usuario->password;
$_POST['clave1']='';
$_POST['clave2']='';
$_POST['cedula']=$usuario->cedula;
$_POST['email']=$usuario->email;
$_POST['correo_nuevo_1']='';
$_POST['correo_nuevo_2']='';
$_POST['tlf1']=$usuario->tlf1;
$_POST['tlf2']=$usuario->tlf2;
$_POST['fecha_inicio']=$usuario->fecha_inicio;
$_POST['foto']=$usuario->foto;
$_POST['codigo_carrera']=$usuario->codigo_carrera;
$_POST['zona']=$usuario->zona;
if($usuario->servicio_extra){$_POST['servicio_extra']=$usuario->servicio_extra;}else{$_POST['servicio_extra']=array("",0);}
$_POST['limitacionesM']=$usuario->limitacionesM;
$_POST['limitacionesF']=$usuario->limitacionesF;
$_POST['tipo']=$usuario->tipo;

$_POST['agrupaciones']=$usuario->agrupaciones;
$carreras= usuario::carreras();

?>



<script>
var fotoEstaCargada = false;
function fotoCargada() {
    fotoEstaCargada = true;
}

$(document).ready(function(){
	$("#submit_plantilla").click(function(){					   				   
		$(".error").hide();
		var hasError = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var carnetReg = /^([0-9]{2})\-([0-9]{4,5})?$/;
		var cedulaReg1 = /^([0-9]{1,2})\.([0-9]{3})\.([0-9]{3})?$/;
		var cedulaReg2 = /^([0-9]{7,8})?$/;
		var tlfReg= /^(([0-9]{0,4}))\-*(([0-9])+)?$/;
		var alphanumReg=/^([0-9]\.[a-z][A-Z]\,\s)$/;
		
		
		//Verificacion del Correo Actual y su cambio
		var emailVal = $("#email").val();
		var correo1Val = $("#correo_nuevo_1").val();
		var correo2Val = $("#correo_nuevo_2").val();
		if(correo1Val == '' && correo2Val == '' ) {
		}
		else if(correo1Val!=correo2Val){
			$("#correo_nuevo_1").after('<span class="error">Los correos deben ser iguales</span>');
			hasError = true;
			
		}
		else if (!emailReg.test(correo1Val) ) {	
			$("#correo_nuevo_1").after('<span class="error">Los correos deben ser v&aacute;lidos.</span>');
			hasError = true;
			
		}
		
        /* @3 Permitir a los usuarios (administradores)
            * cambiar su clave aquí */
		//Verificacion del nuevo clave
		var claveVal = $("#clave").val();
		var clave1Val = $("#clave1").val();
		var clave2Val = $("#clave2").val();
		if(clave1Val == '' && clave2Val == '' ) {
		}
		else {
			if(claveVal == '') {
				$("#clave").after('<span class="error">Por favor, introduzca la clave original.</span>');
				hasError = true;
			} else if (!(hex_md5(claveVal)=='<?php echo $_POST['password'];?>')){
				$("#clave").after('<span class="error">Clave incorrecta.</span>');
				hasError = true;
			}
			if (clave1Val!=clave2Val) {	
			$("#clave1").after('<span class="error">Las clave deben ser iguales.</span>');
			$("#clave2").after('<span class="error">Las clave deben ser iguales.</span>');
			hasError = true;
			}
		}
		
		
		//Verificacion de la cedula
		var cedulaVal = $("#cedula").val();
		if(cedulaVal == '') {
			$("#cedula").after('<span class="error">Debe tener c&eacute;dula.</span>');
			hasError = true;
		} else if(!((!cedulaReg1.test(cedulaVal))&&(cedulaReg2.test(cedulaVal))||(!cedulaReg2.test(cedulaVal))&&(cedulaReg1.test(cedulaVal)))) {	
			$("#cedula").after('<span class="error">Debe ser una c&eacute;dula valida.</span>');
			hasError = true;
		}
		
		//Verificacion de los telefonos
		var tlf1Val = $("#tlf1").val();
		if(tlf1Val == '') {
			$("#tlf1").after('<span class="error">Debe tener al menos un tel&eacute;fono.</span>');
			hasError = true;
		} else if(!tlfReg.test(tlf1Val)) {	
			$("#tlf1").after('<span class="error">Debe ser un tel&eacute;fono v&aacute;lido</span>');
			hasError = true;
		}
		
		var tlf2Val = $("#tlf2").val();
		if(tlf2Val == '') {
		} else if(!tlfReg.test(tlf2Val)) {	
			$("#tlf2").after('<span class="error">Debe ser un tel&eacute;fono v&aacute;lido</span>');
			hasError = true;
		}
		
		//Verificación de la foto
		var fileVal = $("#file").val();
		if(fileVal== ''){
			if(!fotoEstaCargada){
				$("#file").before('<span class="error">Por favor, cargue una foto.</span>');
				hasError = true;
			}
			
		}
		
		//verificacion de zona

		var zonaVal = $("#zona").val();
		if(zonaVal == '') {
			$("#zona").after('<span class="error">Por favor, introduzca una zona.</span>');
			hasError = true;
		} 
		
		//verificacion de nombres
		var nombresVal = $("#nombres").val();
		if(nombresVal == '') {
			$("#nombres").after('<span class="error">You forgot to enter the nombres.</span>');
			hasError = true;
		}
		
		//verificacion de apellidos
		var apellidosVal = $("#apellidos").val();
		if(apellidosVal == '') {
			$("#apellidos").after('<span class="error">You forgot to enter the apellidos.</span>');
			hasError = true;
		}
		
		if(hasError == false) {
			$(this).hide();
			//$("#actualizar_plantilla li.buttons").append('Actualizando....');
	        document.actualizar_plantilla.submit();
		}
		return false;
	});						   
});


</script>



<h2> Editar perfil </h2>

<div id="ficha">
<form action="acciones/actualizar_plantilla.php" method="post" id="actualizar_plantilla" name="actualizar_plantilla" enctype="multipart/form-data">
<ol class="forms">


<table>
		<tr>
               <td><li><em>Nombres: </em><input type="text" name="nombres" id="nombres" value="<?php echo $_POST['nombres']; ?>" /></li></td>
               <td><li><em>Apellidos: </em><input type="text" name="apellidos" id="apellidos" value="<?php echo $_POST['apellidos']; ?>" /></li></td>
			   <td rowspan="4" style="width:230px; text-align:center;">
				    <?php $ss = "./fotos/".$usuario->foto.".jpg"?> <img onload="fotoCargada()" src="<?php echo $ss?>"  height="150" width="150"/>
				   <input type="file" name="file" id="file" class="file" size="18"> 
			   </td>
        </tr>

        <tr>
               <td><li><em>C&eacute;dula: </em><input readOnly="true" type="text" name="cedula" id="cedula" value="<?php echo $_POST['cedula']; ?>" /></li></td>
               <td><li><em>Carnet: </em><input type="text" name="carnet" id="carnet" value="<?php echo $_POST['carnet']; ?>" /></li></td>
               
       </tr>
       
       <tr>
			<td><li><em>Tel&eacute;fono 1: </em><input type="text" name="tlf1" id="tlf1" value="<?php echo $_POST['tlf1']; ?>" /></li></td>
			<td><li><em>Tel&eacute;fono 2: </em><input type="text" name="tlf2" id="tlf2" value="<?php echo $_POST['tlf2']; ?>" /></li></td>
	   </tr>
	
	<tr>
		<td colspan="2"><li><em>Nuevo E-mail: </em><input type="text" name="correo_nuevo_1" id="correo_nuevo_1" value="<?php echo $_POST['correo_nuevo_1']; ?>" /></li></td>
		
	</tr>
	<tr>
		<td colspan="2"><li><em>Confirmar E-mail: </em><input type="text" name="correo_nuevo_2" id="correo_nuevo_2" value="<?php echo $_POST['correo_nuevo_2']; ?>" /></li></td>
		<td><li> <em>Clave Actual: </em><input type="password" name="clave" id="clave" value="" /></li></td>
		</tr>
	<tr>
		<td colspan="2"><li><em>Zona de residencia: </em><input type="text" name="zona" id="zona" value="<?php echo $_POST['zona']; ?>" /></li></td>
		<td><li><em>Clave Nueva: </em><input type="password" name="clave1" id="clave1" value="<?php echo $_POST['clave1']; ?>" /></li></td>
	</tr>
	<tr>
		<td colspan="2"; rowspan="2"; class="editarb"> <a id="editarPerfil" href ="#">
		     <li class="buttons" style="padding:0; text-align: center;"><a id="submit_plantilla" href="#" ><img src="./images/guardarB.png" style="border:0;" width="100"/></a></li>
	    </td>	
		<td><li><em>Confirmar Clave:</em><input type="password" name="clave2" id="clave2" value="<?php echo $_POST['clave2']; ?>" /></li></td>
	</tr>
	
	<tr><td></td></tr>
	
	
</table>


</ol>
</form>
<div class="clearing"></div>
</div>
<br>
<br>
<script type="text/javascript" src="js/jquery.simpletip-1.3.1.js"></script>
<script type="text/javascript" src="js/estudiante_jornada.js"></script>
