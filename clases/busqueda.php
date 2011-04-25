<?php
class busqueda {
    var $jornada_estado;
    var $jornada_fecha;
    var $jornada_id;
    var $jornada_objetivos;
    var $jornada_horas;
    var $jornada_hi;
    var $jornada_hf;
    var $actividad_nombre;   // String de las actividades concatenadas de una jornada tipo la bitacora
    var $usuario_id;
    var $usuario_estado;
    var $usuario_tipo;
    var $usuario_carnet;
    var $usuario_cedula;
    var $usuario_nombres;
    var $usuario_apellidos;
    var $usuario_foto;
    var $limite_inicial;
    var $limite_final;
    
    
    
    private function search_jornada( $order, $total, $busqueda ) {
        $con = conectar();
		$bool = false;
        $sql_inter = "SELECT j.key_jornada, j.estado AS estado_jornada, j.fecha, j.objetivos, j.horas, u.key_usuario, u.carnet, u.cedula, u.nombres, u.apellidos, u.foto FROM jornada j JOIN usuario u ON (j.key_usuario = u.key_usuario)";

        if ( $busqueda ) {
            $sql_inter .= " WHERE";
            if ( $busqueda->jornada_estado ) { $sql_inter .= " j.estado = '$busqueda->jornada_estado'"; $bool = true; }
            if ( $busqueda->jornada_fecha ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " j.fecha = '$busqueda->jornada_fecha'"; $bool = true; }
            if ( $busqueda->usuario_estado ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.estado = '$busqueda->usuario_estado'"; $bool = true; }
            if ( $busqueda->usuario_tipo ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.tipo = '$busqueda->usuario_tipo'"; $bool = true; } else { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " NOT( u.tipo = 'Coordinador')"; $bool = true; }
            
            if ( $busqueda->usuario_carnet ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.carnet = '$busqueda->usuario_carnet'"; $bool = true; }
            if ( $busqueda->usuario_cedula ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.cedula = '$busqueda->usuario_cedula'"; $bool = true; }
            if ( $busqueda->usuario_nombres ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.nombres LIKE '%$busqueda->usuario_nombres%'"; $bool = true; }
            if ( $busqueda->usuario_apellidos ) { $sql_inter = ($bool) ? $sql_inter . " AND" : $sql_inter; $sql_inter .= " u.apellidos LIKE '%$busqueda->usuario_apellidos%'"; $bool = true; }
        }
        
        $sql = "SELECT ".((!$total) ? "c.key_jornada, c.estado_jornada, c.fecha, c.objetivos, c.horas, c.key_usuario, c.carnet, c.cedula, c.nombres, c.apellidos, c.foto, MIN(r.hora_inicio) AS hora_i, MAX(hora_fin) AS hora_f, GROUP_CONCAT(CONCAT_WS(' ',a.nombre,CONCAT(CONCAT('(',d.descrip,')'))) SEPARATOR ', ') AS act" : "COUNT(*) AS total")." FROM (( ( $sql_inter ) AS c JOIN realiza r ON (c.key_jornada = r.key_jornada)) JOIN actividad a ON (r.key_actividad = a.key_actividad) ) LEFT JOIN descripcion d ON (r.key_realiza = d.key_realiza) GROUP BY c.key_jornada";
        if ( $busqueda->actividad_nombre ) {
            $sql .= " HAVING ".( ($total) ? "GROUP_CONCAT(CONCAT_WS(' ',a.nombre,CONCAT(CONCAT('(',d.descrip,')'))) SEPARATOR ', ')" : "act")." LIKE '%$busqueda->actividad_nombre%'";
        }
		
		$sql .= " ORDER BY c.fecha DESC";

        if ( $order )
        {
            $sql_inter .= " ORDER BY ";
        }
        if (!$total) $sql .= " LIMIT $busqueda->limite_inicial, $busqueda->limite_final";
                
        $result = ejecutarConsulta( $sql, $con );
        if ($total) {
            $row = mysql_fetch_array($result);
            mysql_close($con);
            return $row['total'];
        }
        $busquedas = Array();
        for( $i = 0; $row = mysql_fetch_array($result); $i++ )
        {	
            $busq = new busqueda();
            $busq->jornada_estado = $row['estado_jornada'];
            $busq->jornada_fecha = $row['fecha'];
            $busq->jornada_id = $row['key_jornada'];
            $busq->jornada_objetivos = $row['objetivos'];
            $busq->jornada_horas = $row['horas'];
            $busq->jornada_hi = $row['hora_i'];
            $busq->jornada_hf = $row['hora_f'];
            $busq->actividad_nombre = $row['act'];
            $busq->usuario_id = $row['key_usuario'];
            $busq->usuario_carnet = $row['carnet'];
            $busq->usuario_cedula = $row['cedula'];
            $busq->usuario_nombres = $row['nombres'];
            $busq->usuario_apellidos = $row['apellidos'];
            $busq->usuario_foto = $row['foto'];
            $busquedas[$i] = $busq;
        }
        mysql_close($con);
        return $busquedas;
    }
    
    public function search_jornadas($order, $total) {
        return busqueda::search_jornada($order,$total,$this);
    }
    
}
?>