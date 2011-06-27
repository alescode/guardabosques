<?php session_start();
chdir("../");
require("./BD/query.php");
require('./clases/usuario.php');
require("./lib/utilities.php");
require("./acciones/mail/correos.php");

// Se obtiene la información del usuario que está en el sistema actualmente
	$user = new usuario();
	$user->user_id = $_SESSION["k_user_id"];
	$usuario = $user->get(NULL);
	$usuario = $usuario[0];   

// Debe integrarse este mensaje en la interfaz del sistema en lugar de generar una página nueva,
// no sé cómo hacerlo
$cuerpo = '<html> <head>
    <meta http-equiv="Content-Type" content="text/cuerpo; charset=utf8" />
    <title>Sistema de Bitácoras de los Guardabosques USB</title>
    <link type="text/css" href="../css/olvido_contrasena.css" rel="stylesheet"/>
</head>
<body>';

$ending = "</body></html>";

$con = conectar();
$carnet_destinatario = mysql_real_escape_string($_POST['usbid']);
$mensaje = mysql_real_escape_string($_POST['mensaje']);

$consulta = "select email from usuario where carnet = '" .
              $carnet_destinatario . "' ";
$resultado = ejecutarConsulta($consulta, $con);
cerrarConexion();

if (mysql_numrows($resultado)) { // Se encontró un usuario con estos datos
    $correo_destinatario = mysql_result($resultado, 0);
    $correo_remitente = $usuario->email;
    echo($cuerpo);
    enviarNotificacion($correo_remitente, $correo_destinatario, $mensaje);
    echo('<div>La notificacion ha sido enviada correctamente al usuario.</div>
        <a style="color:black;" href="javascript:window.close()">Cerrar</a>');
    echo($ending);
}
else { // No existe la combinación usuario/correo en la base de datos
    echo($cuerpo);
    echo('<div>El usuario ' . $carnet_destinatario . ' no existe.</div>
        <a style="color:black;" href="javascript:window.close()">Cerrar</a>');
    echo($ending);
}
?>

