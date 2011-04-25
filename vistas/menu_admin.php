<?php 
	if (isset($_SESSION["k_user_id"]) /*&& $_SESSION["k_role"] == "estudiante"*/) {
	echo '
	<table>
		<tr>
			<td id="boton">
				<a id="admin_inicio" href ="#">
				&nbsp;&nbsp;Inicio
				</a>
			</td>
		</tr>
		<tr>
			<td id="boton">
				<a id="admin_busquedas" href ="#">
				&nbsp;&nbsp;Bùsquedas
				</a>
			</td>
		</tr>
		<tr>
			<td id="boton">
				<a id="admin_usuarios" href ="#">
				&nbsp;&nbsp;A&ntilde;adir Usuarios
				</a>
			</td>
		</tr>
		
		<tr>
			<td id="boton">
				<a id="admin_actividades" href ="#">
				&nbsp;&nbsp;Actividades
				</a>
			</td>
		</tr>
		<tr>
			<td id="boton">
				<a id="admin_asistencias" href ="#">
				&nbsp;&nbsp;Asistencias
				</a>
			</td>
		</tr>
		<tr>
		<tr>
			<td id="boton">
				<a id="admin_notificaciones" href ="#">
				&nbsp;&nbsp;Notificaciones
				</a>
			</td>
		</tr>
		<tr>
			<td id="boton">
			<a href="acciones/cerrar_sesion.php">
				&nbsp;&nbsp;Cerrar Sesi&oacute;n
			</a>
			</td>
		</tr>
		
		
	</table>
';
}
?>
