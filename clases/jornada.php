<?php
include "./clases/realiza.php";

class jornada {
	var $jornada_id;
    var $user_id;
    var $fecha;
    var $horas;
    var $objetivos;
    var $estado;
    var $list_realiza;
    
    
    private function jornada_new( $j, $realizan ) {
        $j2 = new jornada();
        $j2->user_id = $j[0];
        $j2->fecha = $j[1];
        $j2->horas = $j[2];
        $j2->objetivos = $j[3];
        jornada::jornada_save($j2);
		$j2->horas =NULL;
		$j2->objetivos = NULL;
        $j2 = jornada::jornada_get($j2,NULL);
        $j2 = $j2[0];
        $j2 = $j2->jornada_id;
        realiza::save($realizan,$j2);
    }
    
    public function save( $j, $realizan ) {
        jornada::jornada_new($j, $realizan);
    }
    
    private function jornada_save( $jornada ) {
        $con = conectar();
        $sql = "INSERT INTO jornada( key_usuario, fecha, objetivos, horas ) VALUES ( '$jornada->user_id', '$jornada->fecha', '$jornada->objetivos', '$jornada->horas' )";
		ejecutarAccion( $sql, $con );
        mysql_close($con);
    }
    
    private function jornada_updateAdmin( $jornada ) {
        $con = conectar();
        $sql = "UPDATE jornada SET estado = '$jornada->estado' WHERE key_jornada = '$jornada->jornada_id'";
        ejecutarAccion( $sql, $con );
		if ($jornada->estado=="Aprobada") {
            $sql = "UPDATE usuario SET horas_aprobadas = horas_aprobadas + $jornada->horas WHERE key_usuario = '$jornada->user_id'";
			ejecutarAccion( $sql, $con );
        }
        mysql_close($con);
    }
    
    public function updateAdmin() {
        jornada::jornada_updateAdmin($this);
    }
    
    public function delete() {
        jornada::jornada_delete($this);
    }
    
    private function jornada_delete( $jornada ) {
        $con = conectar();
        for( $i=0; $list_realiza[$i]; $i++ ) { $list_realiza[$i]->delete(); }
        $sql = "DELETE FROM jornada WHERE key_jornada = '$jornada->jornada_id'";
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }
    
    private function jornada_get( $jornada, $order ) {
        $con = conectar();
        $bool = false;
        $sql = "SELECT * FROM jornada";
        if ( $jornada )
        {
            $sql .= " WHERE";
            if ( $jornada->jornada_id ) { $sql .= " key_jornada = '$jornada->jornada_id'"; $bool = true; }
            if ( $jornada->user_id ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " key_usuario = '$jornada->user_id'"; $bool = true; }
            if ( $jornada->fecha ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " fecha = '$jornada->fecha'"; $bool = true; }
            if ( $jornada->horas ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " horas = '$jornada->horas'"; $bool = true; }
            if ( $jornada->objetivos ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " objetivos = '$jornada->objetivos'"; $bool = true; }
            if ( $jornada->estado ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " estado = '$jornada->estado'"; $bool = true; }
        }
        if ( $order )
        {
            $sql = $sql . " ORDER BY ";
            if ( $order = "fecha" ) { $sql = $sql . "key_usuario, fecha"; }
            elseif ( $order = "estado" ) { $sql = $sql . "estado, key_usuario, fecha"; }
        }
		$result = ejecutarConsulta( $sql, $con );
        mysql_close($con);
        $Jornadas = Array();
        for(  $i=0; $row = mysql_fetch_array($result); $i++ )
        {
            $jor = new jornada();
            $jor->jornada_id = $row['key_jornada'];
            $jor->user_id = $row['key_usuario'];
            $jor->fecha = $row['fecha'];
            $jor->horas = $row['horas'];
            $jor->objetivos = $row['objetivos'];
            $jor->estado = $row['estado'];
            $realiza = new realiza();
            $realiza = $realiza->get($row['key_jornada']);
            $jor->list_realiza = $realiza;
            $Jornadas[$i] = $jor;
        }
		return $Jornadas;
    }
    
    public function get( $order ){
		return jornada::jornada_get($this,$order);
	}
    
    private function jornada_update( $jornada ) {
        $con = conectar();
        $sql = "UPDATE jornada SET horas = '$jornada->horas', objetivos = '$jornada->objetivos' WHERE key_jornada = '$jornada->jornada_id'";
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }

    public function update( $id,$jornada,$inserts,$deletes,$updates ) {
        jornada::jornada_modify($id,$jornada,$inserts,$deletes,$updates);
    }
    
    private function jornada_modify($id,$jornada,$inserts,$deletes,$updates){
        $j = new jornada();
        $j->user_id = $id;
        $j->horas = $jornada[0];
        $j->objetivos = $jornada[1];
        jornada::jornada_update($j);
        foreach($deletes as $del) { realiza::delete($del); }
        foreach($updates as $updt)
        {
            $realiza = new realiza();
            $realiza->realiza_id = $updt[0];
            $realiza->hora_inicio = $updt[1];
            $realiza->hora_fin = $updt[2];
            $realiza->act_id = $updt[3];
            if ($updt[4]) { $realiza->desc = $updt[4]; }
            $realiza->update();
        }
        if ($inserts) { realiza::save($inserts,$id); }
    }
}
?>