<?php  session_start();
	
?>

<h2> Informe </h2>

<div style="word-wrap: break-word;" class="wordwrap">
    Cuando hayas completado las horas de servicio, en esta sección puedes subir
    tu informe de culminación. <br/>Primero debes subir la versión en borrador del informe,
    cuando te sea revisado recibirás las correcciones y podrás subir la versión definitiva.
    <br/>
    Para más información sobre el informe final
    <a target="#" href="http://www.guardabosques.grupos.usb.ve/blog/?p=240">haz clic aquí</a>.
    <br/><br/>

<center>
<!--<div class="gray" style="background-color:#aba; width=200px; margin-top: 10px;" >-->
<div>
<table>
<tr>
    <td> Borrador del informe </td>
    <td> <form action="acciones/subir_borrador_informe.php">
	<input type="file" name="informe" id="informe" class="file" size="18"/>
    <input type="submit" value="Enviar"/>
    </form>
    </td>
</tr>
<tr>
    <td> Informe definitivo </td>
    <td> <form action="acciones/subir_informe.php">
	<input type="file" name="informe" id="informe" class="file" size="18"/>
    <input type="submit" value="Enviar"/>
    </form>
    </td>
</tr>
</table>
</center>
 <!--   <img src="./images/construccion.png" />-->

</div>
