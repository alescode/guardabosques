<?php  session_start();
	
?>
<!-- Esta notificación debería salir como un pop-up -->
<script type="text/javascript">
    function popup(){
        pop = window.open("acciones/enviar_notificacion.php", "Recuperación de contraseña",
                "location=no,width=500,height=500,left=0,top=0,directories=no"); 
    }
</script>

<h2> Notificaciones </h2>

<div id>
    <form target="#" action="acciones/enviar_notificacion.php" method="post">
    Carnet del destinatario: <input type="text" name="usbid" /><br/>
    Mensaje: <br/><textarea rows="15" cols="60" name="mensaje"></textarea>
    <br/>
    <input type="submit" value="Enviar"/>
    </form>

</div>
