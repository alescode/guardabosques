CREATE TRIGGER trigger_horas_laboradas BEFORE INSERT ON `jornada`
  FOR EACH ROW BEGIN
    DECLARE horas DOUBLE;
    DECLARE h_int INT;
    DECLARE h_doub DOUBLE;
    SET horas = (NEW.hora_fin - NEW.hora_inicio)/10000;
    SET h_int = horas;
    SET h_doub = ((horas - h_int)*100)/60;
    UPDATE `usuario` u SET horas_laboradas = horas_laboradas + h_int + h_doub WHERE u.key = NEW.key_usuario;
  END;
  
  
  
CREATE TRIGGER trigger_horas_aprobadas BEFORE UPDATE ON `jornada`
  FOR EACH ROW BEGIN
    DECLARE horas DOUBLE;
    DECLARE h_int INT;
    DECLARE h_doub DOUBLE;
    IF OLD.estado IS NULL && STRCMP(NEW.estado,'Aprobada') = 0
    THEN 
      SET horas = (NEW.hora_fin - NEW.hora_inicio)/10000;
      SET h_int = horas;
      SET h_doub = ((horas - h_int)*100)/60;
      UPDATE `usuario` u SET u.horas_aprobadas = u.horas_aprobadas + h_int + h_doub WHERE u.key = NEW.key_usuario;
    END IF;
  END;

  
  
CREATE TRIGGER trigger_actualizar_objetivos AFTER DELETE ON `realiza`
  FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE obj, objs BINARY(5) DEFAULT 00000;
    DECLARE cur1 CURSOR FOR SELECT a.objetivos FROM `actividad` a, `realiza` r WHERE r.key_jornada = OLD.key_jornada AND r.key_actividad = a.key;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur1;
    REPEAT
        FETCH cur1 INTO obj;
        IF NOT done THEN
           SET objs = objs | obj;
        END IF;
    UNTIL done END REPEAT;
    UPDATE `jornada` j SET j.objetivos = objs WHERE j.key = OLD.key_jornada;
    CLOSE cur1;
  END;
  
/*  
CREATE TRIGGER trigger_jornada_solapada BEFORE INSERT ON `jornada`
  FOR EACH ROW BEGIN
    DECLARE cant INT;
    SET cant = (SELECT COUNT(*) FROM `jornada` WHERE Usuario = NEW.Usuario AND Fecha = NEW.Fecha AND ( (HoraInicio <= NEW.HoraInicio AND NEW.HoraInicio <= HoraFin) OR (HoraInicio <= NEW.HoraFin AND NEW.HoraFin <= HoraFin) ) );
    IF cant > 0 THEN ABORT;
    END IF;
  END;*/
  
  
