<?php
 
// Configuración del servidor de correos
require($_SERVER['DOCUMENT_ROOT'].'/guardabosques/config.php');
 
// Nuestra clase FreakMailer que hereda de Mailer
require($_SERVER['DOCUMENT_ROOT'].'/guardabosques/lib/PHPMailer/MailClass.inc');

function enviarCorreoDeRegistro($email, $login, $password) {
    $textBody = 'Bienvenido al Sistema de Bitácoras de los Guardabosques USB.
    Acceda al sistema en http://guardabosques.grupos.usb.ve/bitacoras para ingresar sus datos personales y gestionar su bitácora.

    Sus datos de acceso son:
    Usuario: ' . $login . '
    Clave: ' . $password;

    // Cuerpo del mensaje HTML (para enviar el mensaje como HTML)
    $htmlBody = '<img src="http://www.guardabosques.grupos.usb.ve/img/logo.png" width="600px"/>
        <h2>Bienvenido al Sistema de Bitácoras de los Guardabosques USB</h2>
        <h4>Acceda al sistema en 
        <a href="http://guardabosques.grupos.usb.ve/bitacoras">http://guardabosques.grupos.usb.ve/bitacoras</a>
        para ingresar sus datos personales y gestionar su bitácora.</h4>
        <p>Sus datos de acceso son:<br/><br/>
        <strong>Usuario: ' . $login . '<br/>
        Clave: ' . $password . '</strong></p>';

    enviarCorreo($textBody, $htmlBody, $email, $login, $password);
}

function enviarCorreoNuevaClave($email, $login, $password) {
    $textBody = 'Usted ha solicitado una nueva clave para ingresar al Sistema de Bitácoras de los Guardabosques USB.
    Acceda al sistema en http://guardabosques.grupos.usb.ve/bitacoras.

    Sus datos de acceso son:
    Usuario: ' . $login . '
    Clave: ' . $password;

    // Cuerpo del mensaje HTML (para enviar el mensaje como HTML)
    $htmlBody = '<img src="http://www.guardabosques.grupos.usb.ve/img/logo.png" width="600px"/>
        <h2>Cambio de clave en el Sistema de Bitácoras de los Guardabosques USB</h2>
        <h4>Usted ha solicitado una nueva clave para ingresar al Sistema de Bitácoras 
        de los Guardabosques USB. Acceda al sistema en 
        <a href="http://guardabosques.grupos.usb.ve/bitacoras">
        http://guardabosques.grupos.usb.ve/bitacoras</a>.</h4>
        <p>Sus datos de acceso son:<br/><br/>
        <strong>Usuario: ' . $login . '<br/>
        Clave: ' . $password . '</strong></p>';

    enviarCorreo($textBody, $htmlBody, $email, $login, $password);
}


function enviarCorreo($textBody, $htmlBody, $email, $login, $password) {
    $mailer = new FreakMailer();

    // Asunto
    $mailer->Subject = 'Sus datos de acceso del Sistema de Bitácoras';
     
    // Cuerpo: se envía el HTML, si no es soportado por el cliente se muestra
    // el mensaje en texto simple.
    $mailer->Body = $htmlBody;
    $mailer->isHTML(true);
    $mailer->AltBody = $textBody;
     
    // Add an address to send to.
    $mailer->AddAddress($email);
     
    if(!$mailer->Send())
    {
    }
    else
    {
        echo "<script type=\"text/javascript\">alert(\"Hubo un error enviando el correo a
            la dirección "
            . $email . ". Por favor, intente nuevamente o contacte al administrador.\");</script>";
    }
    $mailer->ClearAddresses();
    $mailer->ClearAttachments();
}

?>
