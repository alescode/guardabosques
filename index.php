<?php if (!(isset($_SESSION["k_user_id"]))) {
		session_start();
	}?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
	
	<title>Sistema de Bitácoras de los Guardabosques USB</title>
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link type="text/css" href="css/custom-theme/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<link type="text/css" href="css/tablas.css" rel="stylesheet" />	
<link type="text/css" href="css/plantilla.css" rel="stylesheet" />		
	
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.simpletip-1.3.1.js"></script>

	<script>
	
	$(document).ready(function(){	
		$('#cuerpo').fadeIn(1000);
	});
	

/*
	$("#clave").keyup(function(event){
			  if(event.keyCode == 13){
				  $("#submit").click();
					}
	});
 */

    $(document).ready(function (){
		$("#submit").click(function() {
			var username = $("#usuario").val();
			var password = $("#clave").val();
			//var dataString = ;

			if ( !username || !password ) {
				$('.error').fadeIn(250);
			} else {
				$('#cuerpo').fadeOut(250);
				document.xxx.submit();
		
						//$('#principal').empty();	
						//$('#principal').load("vistas/principal.php");
						//$('#principal').fadeIn(500).show();
					
			}
		});
	});
	
	// Funciones del rol estudiante
	
	$(document).ready(function() {
        $('#estudiante_inicio').click(function(){
			$('#contenido_center').load('vistas/estudiante_inicio.php');
        });   
	});
	
	$(document).ready(function() {
        $('#editarPerfil').click(function(){
			$('#contenido_center').load('vistas/plantilla.php');
        });   
	});
    $(document).ready(function() {
        $('#editarPerfil_admin').click(function(){
			$('#contenido_center').load('vistas/plantilla_admin.php');
        });   
	});
	$(document).ready(function() {
        $('#estudiante_jornada').click(function(){
			$('#contenido_center').load('vistas/estudiante_jornada.php');
        });   
	});
	
	
	$(document).ready(function() {
        $('#estudiante_bitacora').click(function(){
			$('#contenido_center').load('vistas/estudiante_bitacora.php');
        });   
	});
	
	
	$(document).ready(function() {
        $('#estudiante_informe').click(function(){
			$('#contenido_center').load('vistas/estudiante_informe.php');
        });   
	});
	
	$(document).ready(function() {
        $('#estudiante_asistencia').click(function(){
			$('#contenido_center').load('vistas/estudiante_asistencia.php');
        });   
	});
	
	// Funciones del rol coordinador
	
	$(document).ready(function() {
        $('#admin_inicio').click(function(){
			$('#contenido_center').load('vistas/admin_inicio.php');
        });   
	});
	
	$(document).ready(function() {
        $('#admin_busquedas').click(function(){
			$('#contenido_center').load('vistas/admin_busquedas.php');
        });   
	});
	
	$(document).ready(function() {
        $('#admin_usuarios').click(function(){
			$('#contenido_center').load('vistas/admin_usuarios.php');
        });   
	});
	
	$(document).ready(function() {
        $('#admin_actividades').click(function(){
			$('#contenido_center').load('vistas/admin_actividades.php');
        });   
	});
	
	$(document).ready(function() {
        $('#admin_asistencias').click(function(){
			$('#contenido_center').load('vistas/admin_asistencias.php');
        });   
	});
	
	$(document).ready(function() {
        $('#admin_notificaciones').click(function(){
			$('#contenido_center').load('vistas/admin_notificaciones.php');
        });   
	});
	

	
	
	</script>
	    
</head>

<body>

	<div id = "cuerpo" style="display:none;">
		<div id = "header">
		</div>
		<div id="contenedor_principal">
		<?php 
			//include("config.php");
			include ('./acciones/security.php');
			
			
			if (!isset($_SESSION['k_user_id'])) {
				include("./vistas/login.html");
			} else {
				include("./vistas/principal.php");
			}
		?>		
		</div>
	</div>
	
	
</body>

</html>
