<?php
    function conectar() {
        $con = mysql_connect("localhost","guardabosques","serviciocomunitario2011");

        if (!$con)
        {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("guardabosques", $con) or die("Unable to select database");
		mysql_query("SET NAMES 'utf8';");
        return $con;
    }
    
    function ejecutarConsulta( $sql, $con ) {
        $result = mysql_query($sql, $con);
        if (!$result) {
            die('Error: ' . mysql_error());
        }
        return $result;
    }
    
    function ejecutarAccion( $sql, $con ) {
        if ( !mysql_query($sql,$con) ) {
            die('Error: ' . mysql_error());
        }
    }

    function cerrarConexion() {
        mysql_close();
    }
?>
