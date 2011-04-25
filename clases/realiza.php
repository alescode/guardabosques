<?php
class realiza {
	var $realiza_id; 			
    var $act_id;
    var $hora_inicio;       
    var $hora_fin;          
    var $desc;
    
    
    private function realiza_save( $realizan, $jornada_id ) {
        $con = conectar();
        $descripciones = Array();
        $cnt = 0;
        $sql = "INSERT INTO realiza( key_jornada, key_actividad, hora_inicio, hora_fin ) VALUES";
        $i=0;
		foreach( $realizan as $realiza ) {
            if ( $i !=0 ) $sql .= ",";
            $sql .= " ( '$jornada_id', '$realiza[0]', '$realiza[1]', '$realiza[2]' )";
            if ($realiza[3]) { $descripciones[$cnt] = array($realiza[1],$realiza[3]); $cnt++; }
			$i++;
        }
		
		ejecutarAccion( $sql, $con );
        $sql = "SELECT hora_inicio, key_realiza FROM realiza WHERE key_jornada = '$jornada_id' ORDER BY hora_inicio";
		$result = ejecutarConsulta( $sql, $con );
        if ($cnt>0) {
			$i = 0;
			$sql = "INSERT INTO descripcion( key_realiza, descrip ) VALUES";
			while( $row = mysql_fetch_array($result) )
			{
				if ( $i > $cnt) { break; } else { $d = $descripciones[$i]; }
				if ( $i !=0 ) { $sql .= ","; }
				if ( $row['hora_inicio']==$d[0] ) { $sql .= " ( '".$row['key_realiza']."', '$d[1]' )"; }
			}
			ejecutarAccion( $sql, $con );
		}
        mysql_close($con);
    }
    
    private function realiza_update( $realiza ) {
        $con = conectar();
        $sql = "UPDATE realiza SET hora_inicio = '$realiza->hora_inicio', hora_fin = '$realiza->hora_fin', key_realiza = '$realiza->act_id' WHERE key_realiza = '$realiza->realiza_id'";
        ejecutarAccion( $sql, $con );
        $sql = "SELECT count(*) AS cnt FROM descripcion WHERE key_realiza = '$realiza->realiza_id'";
        $result = ejecutarConsulta( $sql, $con );
        $row = mysql_fetch_array($result);
        if ( $row['cnt'] > 0 ) {
            if ($realiza->desc) { $sql = "UPDATE descripcion SET descrip = '$realiza->desc' WHERE key_realiza = '$realiza->realiza_id'";
            } else { $sql = "DELETE FROM descripcion WHERE key_realiza = '$realiza->realiza_id'"; }
            ejecutarAccion( $sql, $con );
        } else {
            if ($realiza->desc) { $sql = "INSERT INTO descripcion( key_realiza, descrip ) VALUES ( '$realiza->realiza_id', '$realiza->desc' )"; }
        }
        mysql_close($con);
    }
    
    private function realiza_delete( $realiza_id ) {
        $con = conectar();
        $sql = "DELETE FROM descripcion WHERE key_realiza = '$realiza_id'";
		ejecutarAccion( $sql, $con );
        $sql = "DELETE FROM realiza WHERE key_realiza = '$realiza_id'";
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }
   
    private function realiza_get( $jornada_id ) {
        $con = conectar();
        $bool = false;
        $sql = "SELECT r.*, d.descrip FROM realiza r LEFT JOIN descripcion d ON (r.key_realiza = d.key_realiza) WHERE r.key_jornada = '$jornada_id' ORDER BY r.hora_inicio";
        $result = ejecutarConsulta( $sql, $con );
    	$Realizan = Array();
        for( $i= 0; $row = mysql_fetch_array($result); $i++ ) {
            $rea = new realiza();
            $rea->realiza_id = $row['key_realiza'];
            $rea->act_id = $row['key_actividad'];
            $rea->hora_inicio = $row['hora_inicio'];
            $rea->hora_fin = $row['hora_fin'];
            $rea->desc = $row['descrip'];
            $Realizan[$i] = $rea;
        }
        mysql_close($con);
        return $Realizan;
    }
    
    
    public function save( $realizan, $jornada_id ) {
		realiza::realiza_save($realizan,$jornada_id);
	}
    
    public function update() {
        realiza::realiza_update($this);
    }
    
    public function delete($id) {
        realiza::realiza_delete($id);
    }

    public function get($jornada_id) {
        return realiza::realiza_get($jornada_id);
    }
}
?>