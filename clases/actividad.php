<?php

class actividad {
    var $act_id;
	var $nombre;
	var $objetivos;
    
    
    private function act_save( $actividades ) {
        $con = conectar();
        $sql = "INSERT INTO actividad ( nombre, objetivos ) VALUES";
		$i = 0;
		foreach( $actividades as $actividad ) {
            if ( $i !=0 ) $sql .= ",";
            $sql .= " ( '$actividad->nombre', '$actividad->objetivos' )";
            $i++;
        }
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }

    function act_get( $actividad ) {
        $con = conectar();
        $sql = "SELECT * FROM actividad";
        if ( $actividad->act_id ) { $sql .= " WHERE key_actividad = '$actividad->act_id'"; }
        $sql .= " ORDER BY nombre";
        $result = ejecutarConsulta( $sql, $con );
        $Actividades = Array();
			
        for( $i=0; $row = mysql_fetch_array($result); $i++ )
        {
            $act = new actividad();
            $act->nombre = $row['nombre'];
            $act->objetivos = $row['objetivos'];
			$act->act_id = $row['key_actividad'];
            $Actividades[$row['key_actividad']] = $act;
			//echo $row['key_actividad'];
			
			//echo $act->nombre;
            //$Actividades[$i] = $act;
			//echo $Actividades[c]->nombre;
        }
        mysql_close($con);
        return $Actividades;
    }

    private function actividad_update( $actividad ) {
        $con = conectar();
        $sql = "UPDATE actividad SET nombre = '$actividad->nombre', objetivos = '$actividad->objetivos' WHERE key_actividad = '$actividad->act_id'";
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }
    
    public function get(){
		return actividad::act_get( $this );
	}
	
    public function save($actividades){
		actividad::act_save($actividades);
	}
    
    public function update() {
        actividad::actividad_update($this);
    }
}
?>