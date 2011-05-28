<?php
chdir("../");
require("./BD/query.php");
require("./lib/utilities.php");
require("./acciones/mail/correos.php");

$cuerpo = '<html> <head>
    <meta http-equiv="Content-Type" content="text/cuerpo; charset=utf8" />
    <title>Sistema de Bitácoras de los Guardabosques USB</title>
    <link type="text/css" href="../css/olvido_contrasena.css" rel="stylesheet"/>
</head>
<body>';

$ending = "</body></html>";

$con = conectar();
$usuario = mysql_real_escape_string($_POST['usuario']);
$correo = mysql_real_escape_string($_POST['correo']);

$consulta = "select * from usuario where login = '" .
              $usuario . "' and email = '" . $correo . "'";
$resultado = ejecutarConsulta($consulta, $con);
cerrarConexion();

if (mysql_numrows($resultado)) { // Se encontró un usuario con estos datos
    $nuevaClave = createRandomPassword();
    enviarCorreoNuevaClave($correo, $usuario, $nuevaClave); //Se debe verificar que el correo fue enviado
    $actualizar = "update usuario set clave = MD5('" . $nuevaClave .
                  "') WHERE login='" . $usuario . "'";
    ejecutarAccion($actualizar, $con);
    echo($cuerpo);
    echo('<p style="font-family:arial;">El sistema ha generado una clave nueva y la ha enviado a su correo electrónico.</p>');
    echo($ending);
}
else { // No existe la combinación usuario/correo en la base de datos
    echo($cuerpo);
    // El estilo no debería definirse aquí sino en el CSS, pero no sé
    // por qué no funciona definiéndolo en css/olvido_contrasena.css.
    echo('<p style="font-family:arial">Esta combinación de usuario y correo electrónico no existe en nuestra base de datos. Por favor, verifique la información e intente de nuevo.</p>
        <a style="color:black;margin-right:20px;" href="javascript:history.go(-1)">Volver</a>
        <a style="color:black;" href="javascript:window.close()">Cerrar</a>');
    echo($ending);
}
?>
