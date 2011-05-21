<?php
chdir("../");
require("./BD/query.php");

$cuerpo = '<html> <head>
    <meta http-equiv="Content-Type" content="text/cuerpo; charset=utf8" />
    <title>Sistema de Bitácoras de los Guardabosques USB</title>
    <link type="text/css" href="css/olvido_contrasena.css" rel="stylesheet"/>
</head>
<body>';

$ending = "</body></html>";


$usuario = $_POST['usuario'];
$correo = $_POST['correo'];

$con = conectar();
$consulta = ejecutarConsulta("select * from usuario where login = '" .
                              $usuario . "' and email = '" . $correo . "'");
if ($consulta) {
    echo($cuerpo);
    echo("YES");
    echo($ending);
}
else {
    echo($cuerpo);
    echo("NO");
    echo($ending);
}



?>
