<?php
    function conectar() {
        $con = mysql_connect("localhost","guardabosques","serviciocomunitario2011");

        if (!$con)
        {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("guardabosques", $con);
		mysql_query("SET NAMES 'utf8';");
        return $con;
    }
    
    function ejecutarConsulta( $sql, $con ) {
        return mysql_query($sql, $con);
        //if ( !( $result = mysql_query($sql,$con) ) ) {
        //    die('Error: ' . mysql_error());
        //}
        //return $result;
    }
    
    function ejecutarAccion( $sql, $con ) {
        if ( !mysql_query($sql,$con) ) {
            die('Error: ' . mysql_error());
        }
    }
?>
