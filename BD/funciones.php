<?php
function conectar()
{
    $con = mysql_connect("localhost","usuariosGen","12345");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("guardabosques", $con);
    return $con;
}
?>



<?php
// INSERTAR  JORNADA
function save()
{
    $con = conectar();
    $sql = "INSERT INTO jornada ( Usuario, Fecha, HoraInicio, HoraFin, Descripcion, Objetivos ) VALUES ( '$this->', '$this->', '$this->', '$this->', '$this->', '$this->' )";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// OBTENER JORNADAS
function get( $order )
{
    $con = conectar();
    $bool = false;
    
    $sql = "SELECT * FROM jornada WHERE";
    if ( !$this->user_id ) { $sql = sql . " Usuario = '$this->user_id'"; $bool = true; }
    if ( !$this->fecha ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Fecha = '$this->fecha'"; $bool = true; }
    if ( !$this->hora_inicio ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " HoraInicio = '$this->hora_inicio'"; $bool = true; }
    if ( !$this->hora_fin ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " HoraFin = '$this->hora_fin'"; $bool = true; }
    if ( !$this->descripcion ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Descripcion = '$this->descripcion'"; $bool = true; }
    if ( !$this->objetivos ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Objetivos = '$this->objetivos'"; $bool = true; }
    if ( !$this->estatus ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Estatus = '$this->estatus'"; $bool = true; }
    
    if ( !$order )
    {
        $sql = $sql . " ORDER BY "
        if ( $order = "fecha" ) { $sql = $sql . "Usuario, Fecha, HoraInicio"; }
        elseif ( $order = "estatus" ) { $sql = $sql . "Estatus, Usuario, Fecha, HoraInicio"; }
    }
    
    $result = mysql_query($sql,$con);
    if (!$result)
    {
        die('Error: ' . mysql_error());
    }
    for(  $i; $row = mysql_fetch_array($result); $i++ )
    {
        $jor = new jornada();
        $jor->user_id = $row['Usuario'];
        $jor->fecha = $row['Fecha'];
        $jor->hora_inicio = $row['HoraInicio'];
        $jor->hora_fin = $row['HoraFin'];
        $jor->descripcion = $row['Descripcion'];
        $jor->objetivos = $row['Objetivos'];
        $jor->estatus = $row['Estatus'];
        $Jornadas[$i] = $usr;
    }
    mysql_close($con);
    return $Jornadas;
}
?>

<?php
// ACTUALIZAR DATOS BASICOS DE JORNADA
function update( $fecha, $h_inicio )
{
    $con = conectar();
    $sql = "UPDATE jornada SET Fecha = '$this->fecha', HoraInicio = '$this->hora_inicio', HoraFin = '$this->hora_fin', Descripcion = '$this->descripcion', Objetivos = '$this->objetivos' WHERE clave = '$this->user_id' AND Fecha = '$fecha' AND HoraInicio = '$h_inicio'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// ACTUALIZAR DATOS DE ADMIN DE JORNADA
function updateAdmin()
{
    $con = conectar();
    $sql = "UPDATE jornada SET Estatus = '$this->estatus' WHERE clave = '$this->user_id' AND Fecha = '$this->fecha' AND HoraInicio = '$this->hora_inicio'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// ELIMINAR JORNADA
function delete()
{
    $con = conectar();
    $sql = "DELETE FROM jornada WHERE clave = '$this->user_id' AND Fecha = '$this->fecha' AND HoraInicio = '$this->hora_inicio'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>



<?php
// INSERTAR USUARIO
function save()
{
    $con = conectar();
    $sql = "INSERT INTO Persons ( Login, Contrasena, Nombres, Apellidos, Correo, Telefono1, Telefono2, Estado, Tipo ) VALUES ( '$this->login', '$this->password', '$this->nombres', '$this->apellidos', '$this->email', '$this->tlf1','$this->tlf2', '$this->estado', '$this->tipo' )";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// OBTENER USUARIOS
function get( $order )
{
    $con = conectar();
    $bool = false;
    
    $sql = "SELECT * FROM usuario WHERE";
    if ( !$this->user_id ) { $sql = sql . " clave = '$this->user_id'"; $bool = true; }
    if ( !$this->login ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Login = '$this->login'"; $bool = true; }
    if ( !$this->password ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Contrasena = '$this->password'"; $bool = true; }
    if ( !$this->nombres ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Nombres = '$this->nombres'"; $bool = true; }
    if ( !$this->apellidos ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Apellidos = '$this->apellidos'"; $bool = true; }
    if ( !$this->email ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Correo = '$this->email'"; $bool = true; }
    if ( !$this->tlf1 ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Telefono1 = '$this->tlf1'"; $bool = true; }
    if ( !$this->tlf2 ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Telefono2 = '$this->tlf2'"; $bool = true; }
    if ( !$this->horas_laboradas ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " HorasLaboradas = '$this->horas_laboradas'"; $bool = true; }
    if ( !$this->horas_aprobadas ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " HorasAprobadas = '$this->horas_aprobadas'"; $bool = true; }
    if ( !$this->estado ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Estado = '$this->estado'"; $bool = true; }
    if ( !$this->tipo ) { $sql = ($bool) ? (sql . " AND"); $sql = sql . " Tipo = '$this->tipo'"; $bool = true; }
    if ( !$order )
    {
        $sql = $sql . " ORDER BY "
        if ( $order = "nombre" ) { $sql = $sql . "Apellidos, Nombres, Login"; }
        elseif ( $order = "login" ) { $sql = $sql . "Login, Apellidos, Nombres"; }
        elseif ( $order = "estado" ) { $sql = $sql . "Estado, Apellidos, Nombres, Login"; }
        elseif ( $order = "horas" ) { $sql = $sql . "HorasAprobadas, HorasAprobadas, Apellidos, Nombres, Login"; }
    }
    
    $result = mysql_query($sql,$con);
    if (!$result)
    {
        die('Error: ' . mysql_error());
    }
    for(  $i; $row = mysql_fetch_array($result); $i++ )
    {
        $usr = new usuario();
        $usr->user_id = $row['clave'];
        $usr->login = $row['Login'];
        $usr->password = $row['Contrasena'];
        $usr->nombres = $row['Nombres'];
        $usr->apellidos = $row['Apellidos'];
        $usr->email = $row['Correo'];
        $usr->tlf1 = $row['Telefono1'];
        $usr->tlf2 = $row['Telefono2'];
        $usr->horas_laboradas = $row['HorasLaboradas'];
        $usr->horas_aprobadas = $row['HorasAprobadas'];
        $usr->estado = $row['Estado'];
        $usr->tipo = $row['Tipo'];
        $Usuarios[$i] = $usr;
    }
    mysql_close($con);
    return $Usuarios;
}
?>

<?php
// ACTUALIZAR DATOS PERSONALES DE USUARIO
function update()
{
    $con = conectar();
    $sql = "UPDATE usuario SET Contrasena = '$this->password', Nombres = '$this->nombres', Apellidos = '$this->apellidos', Correo = '$this->email', Telefono1 = '$this->tlf1', Telefono2 = '$this->tlf2' WHERE clave = '$this->user_id'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// ACTUALIZAR DATOS DE ADMIN DE USUARIO
function updateAdmin()
{
    $con = conectar();
    $sql = "UPDATE usuario SET Estado = '$this->estado', Tipo = '$this->tipo' WHERE clave = '$this->user_id'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>



<?php
// INSERTAR ACTIVIDAD
function save()
{
    $con = conectar();
    $sql = "INSERT INTO Persons ( Nombre, Objetivos ) VALUES ( '$this->', '$this->' )";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    mysql_close($con);
}
?>

<?php
// OBTENER ARREGLO ACTIVIDADES
function get()
{
    $con = conectar();
    $sql = "SELECT * FROM actividad ORDER BY Nombre";
    $result = mysql_query($sql,$con);
    if (!$result)
    {
        die('Error: ' . mysql_error());
    }
    for( $i=0; $row = mysql_fetch_array($result); $i++ )
    {
        $act = new actividad();
        $act->nombre = $row['Nombre'];
        $act->objetivos = $row['Objetivos'];
        $Actividades[$i] = $act;
    }
    mysql_close($con);
    return $Actividades;
}
?>