<?php


class usuario {
	var $user_id;
    var $login;
	var $password;
	var $nombres;
	var $apellidos;
    var $carnet;
    var $cedula;
	var $email;
	var $tlf1;
	var $tlf2;
	var $horas_laboradas;
	var $horas_aprobadas;
    var $estado;
    var $tipo;
    var $fecha_inicio;
    var $fecha_fin;
    var $foto;
    var $codigo_carrera;
    var $direccion;
    var $servicio_extra;
    var $limitacionesM;
    var $limitacionesF;
    var $agrupaciones;
    
    
	// Funcion para agregar solo a nuevos Usuarios, no a coordinadores
	private function user_save( $usuarios ) {
        $con = conectar();
        $sql = "INSERT INTO usuario ( login, clave, email, tipo, estado, carnet ) VALUES ";
        $i = 0;
		foreach( $usuarios as $usuario ) {
            if ( $i !=0 ) $sql .= ", ";
            $sql .= "( '$usuario->login', '".md5($usuario->password)."', '$usuario->email', '$usuario->tipo', '$usuario->estado', '$usuario->login' )";
			$i++;
        }
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }

    private function user_get( $usuario, $order ) {
        $con = conectar();
		
        $bool = false;
        $sql = "SELECT u.*, a.descripcion as agrup_desc, l.descripcion as lim_desc, l.tipo as lim_tipo, s.nombre, s.horas_realizadas FROM (( usuario u LEFT JOIN otro_servicio s ON ( s.key_usuario = u.key_usuario ) ) LEFT JOIN usuario_limitacion l ON ( l.key_usuario = u.key_usuario ) ) LEFT JOIN agrupacion a ON ( a.key_usuario = u.key_usuario )";
        if ( $usuario )
        {
            $sql .= " WHERE";
            if ( $usuario->user_id ) { $sql .= " u.key_usuario = '$usuario->user_id'"; $bool = true; }
            if ( $usuario->login ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " u.login = '$usuario->login'"; $bool = true; }
            if ( $usuario->password ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.clave = '".md5($usuario->password)."'"; $bool = true; }
            if ( $usuario->nombres ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .= " u.nombres LIKE '%$usuario->nombres%'"; $bool = true; }
        	if ( $usuario->apellidos ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.apellidos LIKE '%$usuario->apellidos%'"; $bool = true; }
            if ( $usuario->email ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.email = '$usuario->email'"; $bool = true; }
            if ( $usuario->tlf1 ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.telefono1 = '$usuario->tlf1'"; $bool = true; }
            if ( $usuario->tlf2 ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.telefono2 = '$usuario->tlf2'"; $bool = true; }
            if ( $usuario->horas_laboradas ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.horas_laboradas = '$usuario->horas_laboradas'"; $bool = true; }
            if ( $usuario->horas_aprobadas ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.horas_aprobadas = '$usuario->horas_aprobadas'"; $bool = true; }
            if ( $usuario->estado ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.estado = '$usuario->estado'"; $bool = true; }
            if ( $usuario->tipo ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.tipo = '$usuario->tipo'"; $bool = true; }
            if ( $usuario->fecha_inicio ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.fecha_inicio = '$usuario->fecha_inicio'"; $bool = true; }
            if ( $usuario->fecha_fin ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.fecha_fin = '$usuario->fecha_fin'"; $bool = true; }
            if ( $usuario->foto ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.foto = '$usuario->foto'"; $bool = true; }
            if ( $usuario->carnet ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.carnet = '$usuario->carnet'"; $bool = true; }
            if ( $usuario->cedula ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.cedula = '$usuario->cedula'"; $bool = true; }
            if ( $usuario->codigo_carrera ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.carrera_codigo = '$usuario->codigo_carrera'"; $bool = true; }
            if ( $usuario->direccion ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " u.direccion = '$usuario->direccion'"; $bool = true; }
            if ( $usuario->servicio_extra ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " NOT(s.nombre = NULL)"; $bool = true; }
            if ( $usuario->limitacionesF ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " l.tipo = 'F'"; $bool = true; }
            if ( $usuario->limitacionesM ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " l.tipo = 'M'"; $bool = true; }
            if ( $usuario->agrupaciones ) { $sql = ($bool) ? $sql . " AND" : $sql; $sql .=  " NOT(a.descripcion = NULL)"; $bool = true; }
        }
        $sql .= " ORDER BY ";
        if ( $order )
        {
            if ( $order = "nombre" ) { $sql = $sql . "u.apellidos, u.nombres, u.login, "; }
            elseif ( $order = "login" ) { $sql = $sql . "u.login, u.apellidos, u.nombres, "; }
            elseif ( $order = "estado" ) { $sql = $sql . "u.estado, u.apellidos, u.nombres, u.login, "; }
            elseif ( $order = "horas" ) { $sql = $sql . "u.horas_aprobadas, u.horas_aprobadas, u.apellidos, u.nombres, u.login, "; }
            elseif ( $order = "fechaI" ) { $sql = $sql . "u.fecha_inicio, u.apellidos, u.nombres, u.login, "; }
            elseif ( $order = "fechaF" ) { $sql = $sql . "u.fecha_fin, u.apellidos, u.nombres, u.login, "; }
        }
        $sql .= "u.tipo";
		$Usuarios = Array();
        $result = ejecutarConsulta( $sql, $con );
        for( $i = 0; $row = mysql_fetch_array($result); $i++ )
        {	
            if ( $i>0 && ($usr->user_id == $row['key_usuario']) ) {
                if ($row['lim_tipo']) {if ($row['lim_tipo'] == "F") { $usr->limitacionesF = $row['lim_desc'];} else {$usr->limitacionesM = $row['lim_desc'];} }
            } else { $usr = new usuario(); }
            $usr->user_id = $row['key_usuario'];
            $usr->login = $row['login'];
            $usr->password = $row['clave'];
            $usr->nombres = $row['nombres'];
            $usr->apellidos = $row['apellidos'];
            $usr->email = $row['email'];
            $usr->tlf1 = $row['telefono1'];
            $usr->tlf2 = $row['telefono2'];
            $usr->horas_laboradas = $row['horas_laboradas'];
            $usr->horas_aprobadas = $row['horas_aprobadas'];
            $usr->estado = $row['estado'];
            $usr->tipo = $row['tipo'];
            $usr->fecha_inicio = $row['fecha_inicio'];
            $usr->fecha_fin = $row['fecha_fin'];
            $usr->foto = $row['foto'];
            $usr->carnet = $row['carnet'];
            $usr->cedula = $row['cedula'];
            $usr->codigo_carrera = $row['carrera_codigo'];
            $usr->direccion = $row['direccion'];
            $usr->agrupaciones = $row['agrup_desc'];
            if ($row['nombre']) $usr->servicio_extra = array($row['nombre'],$row['horas_realizadas']);
            if ($row['lim_tipo']) {if ($row['lim_tipo'] == "F") { $usr->limitacionesF = $row['lim_desc'];} else {$usr->limitacionesM = $row['lim_desc'];} }
            $Usuarios[$i] = $usr;
        }
	    mysql_close($con);
        return $Usuarios;
    }

    private function user_update( $usuario ) {
        $con = conectar();
        $sql = "UPDATE usuario SET ". ( ($usuario->password) ? "clave = '".md5($usuario->password)."'," : "") ." nombres = '$usuario->nombres', apellidos = '$usuario->apellidos', email = '$usuario->email', telefono1 = '$usuario->tlf1', telefono2 = '$usuario->tlf2', fecha_inicio = '$usuario->fecha_inicio', foto = '$usuario->foto', carnet = '$usuario->carnet', cedula = '$usuario->cedula',". ( ($usuario->fecha_fin) ? "fecha_fin = '$usuario->fecha_fin'," : "") ."carrera_codigo = '$usuario->codigo_carrera', direccion = '$usuario->direccion' WHERE key_usuario = '$usuario->user_id'";
        ejecutarAccion( $sql, $con );
        
        if ( $usuario->servicio_extra ) {
            $sql = "SELECT COUNT(*) AS cnt FROM otro_servicio WHERE key_usuario = '$usuario->user_id'";
            $result = ejecutarConsulta( $sql, $con );
            $row = mysql_fetch_array($result);
            
			$sql = ($row['cnt']) ?  
                   "UPDATE otro_servicio SET nombre = '".$usuario->servicio_extra[0]."', horas_realizadas = '".$usuario->servicio_extra[1]."' WHERE key_usuario = '$usuario->user_id'"
                   : "INSERT INTO otro_servicio ( key_usuario, nombre, horas_realizadas ) VALUES ( '$usuario->user_id', '".$usuario->servicio_extra[0]."', '".$usuario->servicio_extra[1]."' )";
            ejecutarAccion( $sql, $con );
        }
        if ( $usuario->agrupaciones ) {
            $sql = "SELECT COUNT(*) AS cnt FROM agrupacion WHERE key_usuario = '$usuario->user_id'";
            $result = ejecutarConsulta( $sql, $con );
            $row = mysql_fetch_array($result);
            $sql = ($row['cnt']) ? 
                   "UPDATE agrupacion SET descripcion = '$usuario->agrupaciones' WHERE key_usuario = '$usuario->user_id'"
                   : "INSERT INTO agrupacion ( key_usuario, descripcion ) VALUES ( '$usuario->user_id', '$usuario->agrupaciones' )";
            ejecutarAccion( $sql, $con );
        }
        
        $sql = "SELECT * FROM usuario_limitacion WHERE key_usuario = '$usuario->user_id' AND tipo = 'F'";
        $result = ejecutarConsulta( $sql, $con );
        $row = mysql_fetch_array($result);
		if ( $usuario->limitacionesF != '' ) {
            if ($row['key_limitacion']) { $idL = $row['key_limitacion'];
            } else { $idL = -1; }
            $sql = ( $idL > -1 ) ? "UPDATE usuario_limitacion SET descripcion = '$usuario->limitacionesF' WHERE key_limitacion = '$idL'" : "INSERT INTO usuario_limitacion ( key_usuario, descripcion, tipo ) VALUES ( '$usuario->user_id', '$usuario->limitacionesF', 'F' )";
            ejecutarAccion( $sql, $con );
        } else {
            if ($row['key_limitacion']) {
                $sql = "DELETE FROM usuario_limitacion WHERE key_limitacion = '".$row['key_limitacion']."'";
                ejecutarAccion( $sql, $con );
            }
        }
        
        $sql = "SELECT * FROM usuario_limitacion WHERE key_usuario = '$usuario->user_id' AND tipo = 'M'";
        $result = ejecutarConsulta( $sql, $con );
        $row = mysql_fetch_array($result);
		if ( $usuario->limitacionesM ) {
            if ($row['key_limitacion']) { $idL = $row['key_limitacion'];
            } else { $idL = -1; }
            $sql = ( $idL > -1 ) ? "UPDATE usuario_limitacion SET descripcion = '$usuario->limitacionesM' WHERE key_limitacion = '$idL'" : "INSERT INTO usuario_limitacion ( key_usuario, descripcion, tipo ) VALUES ( '$usuario->user_id', '$usuario->limitacionesM', 'M' )";
            ejecutarAccion( $sql, $con );
        } else {
            if ($row['key_limitacion']) {
                $sql = "DELETE FROM usuario_limitacion WHERE key_limitacion = '".$row['key_limitacion']."'";
                ejecutarAccion( $sql, $con );
            }
        }
        mysql_close($con);
    }
    
    private function limit_update( $idL, $idU, $desc, $tipo ) {
        $sql = ( $idL > -1 ) ? "UPDATE usuario_limitacion SET descripcion = '$desc' WHERE key_limitacion = '$idL'" : "INSERT INTO usuario_limitacion ( key_usuario, descripcion, tipo ) VALUES ( $idU, $desc, $tipo )";
        ejecutarAccion( $sql, $con );
    }

    private function user_updateAdmin( $usuario ) {
        $con = conectar();
        $sql = "UPDATE usuario SET estado = '$usuario->estado', tipo = '$usuario->tipo' WHERE key_usuario = '$usuario->user_id'";
        ejecutarAccion( $sql, $con );
        mysql_close($con);
    }

	public function save( $usuarios ){
		usuario::user_save($usuarios);
	}
	
    public function get( $order ){
		return usuario::user_get($this,$order);
	}
	
    public function update( $order ){
		usuario::user_update($this);
	}
	
    public function updateAdmin( $order ){
		usuario::user_updateAdmin($this);
	}
	
    
    public function complete(){
        $bool = true;
        foreach( $this as $key => $value ) {
			if (!$value && $key!="servicio_extra" && $key!="limitacionesM" 
				&& $key!="estado" && $key!="limitacionesF" 
				&& $key!="agrupaciones" && $key!="tlf2" && $key!="fecha_fin" 
				&& $key!="horas_laboradas" && $key!="horas_aprobadas") {
				$bool = false;
                break;
            }
        }
        return $bool;
    }
    
    private function carreras_get() {
        $con = conectar();
        $sql = "SELECT * FROM carrera ORDER BY codigo";
        $result = ejecutarConsulta( $sql, $con );
        $Carreras = Array();
        for( $i=0; $row = mysql_fetch_array($result); $i++ ) { $Carreras[$row['codigo']] = $row['nombre']; }
        mysql_close($con);
        return $Carreras;
    }
    
    public function carreras() {
        return usuario::carreras_get();
    }
    
    
}
?>
