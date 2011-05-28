<?php
if (isset($_SESSION["k_user_id"]) /*&& $_SESSION["k_role"] == "estudiante"*/) {
	echo('<table>
		<tr>
			<td id="boton">
			<a href="acciones/cerrar_sesion.php">
				&nbsp;&nbsp;Cerrar Sesi&oacute;n
			</a>
			</td>
            </tr>
        </table>');
}
?>

