SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- DROP DATABASE `guardabosques`;
CREATE DATABASE `guardabosques` DEFAULT CHARACTER SET utf8;
USE `guardabosques`;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `actividad`
--

DROP TABLE IF EXISTS `actividad`;
CREATE TABLE IF NOT EXISTS `actividad` (
  `key_actividad` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `objetivos` binary(5) NOT NULL DEFAULT '00000',
  PRIMARY KEY (`key_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agrupacion`
--

DROP TABLE IF EXISTS `agrupacion`;
CREATE TABLE IF NOT EXISTS `agrupacion` (
  `key_usuario` smallint(6) unsigned NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  PRIMARY KEY (`key_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

DROP TABLE IF EXISTS `carrera`;
CREATE TABLE IF NOT EXISTS `carrera` (
  `codigo` varchar(4) NOT NULL,
  `nombre` varchar(55) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `carrera` (`codigo`, `nombre`) VALUES
('0400', 'Licenciatura en Química'),
('0501', 'Licenciatura en Matemáticas (Est. y Mat. Comp.)'),
('0500', 'Licenciatura en Matemáticas'),
('0502', 'Licenciatura en Matemáticas (Didáctica)'),
('1000', 'Licenciatura en Física'),
('1900', 'Licenciatura en Biología'),
('0100', 'Ingeniería Eléctrica'),
('0200', 'Ingeniería Mecánica'),
('0300', 'Ingeniería Química'),
('0600', 'Ingeniería Electrónica'),
('0800', 'Ingeniería de Computación'),
('1200', 'Ingeniería Geofísica'),
('1500', 'Ingeniería de Materiales'),
('1700', 'Ingeniería de Producción'),
('0700', 'Arquitectura'),
('1100', 'Urbanismo'),
('1', 'Tecnología Eléctrica'),
('2', 'Tecnología Electrónica'),
('3', 'Tecnología Mecánica'),
('4', 'Mantenimiento Aeronáutico'),
('5', 'Administración del Turismo'),
('6', 'Administración Hotelera'),
('7', 'Administración del Transporte'),
('8', 'Organización Empresarial'),
('9', 'Comercio Exterior'),
('10', 'Administración Aduanera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcion`
--

DROP TABLE IF EXISTS `descripcion`;
CREATE TABLE IF NOT EXISTS `descripcion` (
  `key_realiza` mediumint(8) unsigned NOT NULL,
  `descrip` varchar(100) NOT NULL,
  PRIMARY KEY (`key_realiza`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

DROP TABLE IF EXISTS `jornada`;
CREATE TABLE IF NOT EXISTS `jornada` (
  `key_jornada` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `key_usuario` smallint(6) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `objetivos` binary(5) NOT NULL DEFAULT '00000',
  `estado` varchar(10) DEFAULT NULL,
  `horas` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key_jornada`),
  KEY `index_jornada_usuario` (`key_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otro_servicio`
--

DROP TABLE IF EXISTS `otro_servicio`;
CREATE TABLE IF NOT EXISTS `otro_servicio` (
  `key_usuario` smallint(6) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `horas_realizadas` double NOT NULL,
  KEY `key_usuario` (`key_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `realiza`
--

DROP TABLE IF EXISTS `realiza`;
CREATE TABLE IF NOT EXISTS `realiza` (
  `key_realiza` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `key_jornada` mediumint(8) unsigned NOT NULL,
  `key_actividad` smallint(6) unsigned NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`key_realiza`),
  KEY `index_realiza_jornada` (`key_jornada`),
  KEY `index_realiza_actividad` (`key_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `key_usuario` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(10) NOT NULL,
  `clave` text NOT NULL,
  `nombres` varchar(30) DEFAULT NULL,
  `apellidos` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono1` varchar(15) DEFAULT NULL,
  `telefono2` varchar(15) DEFAULT NULL,
  `horas_laboradas` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `horas_aprobadas` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `estado` varchar(15) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `foto` varchar(10) DEFAULT NULL,
  `carrera_codigo` varchar(4) DEFAULT NULL,
  `carnet` varchar(8) DEFAULT NULL,
  `cedula` varchar(8) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`key_usuario`),
  UNIQUE KEY `login` (`login`),
  KEY `index_usuario_carrera` (`carrera_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Triggers para la tabla `usuario`
--
DROP TRIGGER IF EXISTS `guardabosques`.`trigger_horas_laboradas`;
DELIMITER //
CREATE TRIGGER `guardabosques`.`trigger_horas_laboradas` AFTER INSERT ON `guardabosques`.`jornada`
  FOR EACH ROW BEGIN
    UPDATE `usuario` u SET u.horas_laboradas = u.horas_laboradas + NEW.horas WHERE u.key_usuario = NEW.key_usuario;
  END
//
DELIMITER ;

DROP TRIGGER IF EXISTS `guardabosques`.`trigger_horas_laboradas_upd`;
DELIMITER //
CREATE TRIGGER `guardabosques`.`trigger_horas_laboradas_upd` AFTER UPDATE ON `guardabosques`.`jornada`
  FOR EACH ROW BEGIN
    IF NOT(OLD.horas = NEW.horas)
    THEN
        UPDATE `usuario` u SET u.horas_laboradas = u.horas_laboradas - OLD.horas + NEW.horas WHERE u.key_usuario = NEW.key_usuario;
    END IF;
    IF STRCMP(NEW.estado,'Aprobada') = 0
    THEN 
        IF NOT(STRCMP(OLD.estado,'Aprobada') = 0)
        THEN
            UPDATE `usuario` u SET u.horas_aprobadas = u.horas_aprobadas + NEW.horas WHERE u.key_usuario = NEW.key_usuario;
        END IF;
    END IF;
  END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_limitacion`
--

DROP TABLE IF EXISTS `usuario_limitacion`;
CREATE TABLE IF NOT EXISTS `usuario_limitacion` (
  `key_limitacion` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `key_usuario` smallint(6) unsigned NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  PRIMARY KEY (`key_limitacion`),
  KEY `index_limitacion_usuario` (`key_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Filtros para la tabla `agrupacion`
--
ALTER TABLE `agrupacion`
  ADD CONSTRAINT `agrupacion_ibfk_1` FOREIGN KEY (`key_usuario`) REFERENCES `usuario` (`key_usuario`);

--
-- Filtros para la tabla `descripcion`
--
ALTER TABLE `descripcion`
  ADD CONSTRAINT `descripcion_ibfk_1` FOREIGN KEY (`key_realiza`) REFERENCES `realiza` (`key_realiza`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`key_usuario`) REFERENCES `usuario` (`key_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `otro_servicio`
--
ALTER TABLE `otro_servicio`
  ADD CONSTRAINT `otro_servicio_ibfk_1` FOREIGN KEY (`key_usuario`) REFERENCES `usuario` (`key_usuario`);

--
-- Filtros para la tabla `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `realiza_ibfk_1` FOREIGN KEY (`key_jornada`) REFERENCES `jornada` (`key_jornada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `realiza_ibfk_2` FOREIGN KEY (`key_actividad`) REFERENCES `actividad` (`key_actividad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`carrera_codigo`) REFERENCES `carrera` (`codigo`);

--
-- Filtros para la tabla `usuario_limitacion`
--
ALTER TABLE `usuario_limitacion`
  ADD CONSTRAINT `usuario_limitacion_ibfk_1` FOREIGN KEY (`key_usuario`) REFERENCES `usuario` (`key_usuario`);

INSERT INTO `usuario` (`key_usuario`, `login`, `clave`, `nombres`, `apellidos`, `email`, `telefono1`, `telefono2`, `horas_laboradas`, `horas_aprobadas`, `estado`, `tipo`, `fecha_inicio`, `fecha_fin`, `foto`, `carrera_codigo`, `carnet`, `cedula`, `direccion`) VALUES
(1, '05-38062', '827ccb0eea8a706c4c34a16891f84e7b', 'Leonardo', 'Da Costa Da Silva', 'dacostaleo@gmail.com', '0212-7828862', '0412-7389131', 0, 0, 'Activo', 'Estudiante', '2010-09-20', NULL, '123', '0800', '05-38062', '18587848', 'caracas'),
(2, '05-38039', '827ccb0eea8a706c4c34a16891f84e7b', 'Juan Enrique', 'Cifuentes Sans', 'juan@gmail.com', '12548', '126999', 0, 0, 'Activo', 'Coordinador', '2010-09-03', NULL, '123', '0800', '05-38039', '12345678', 'caracas');

INSERT INTO `jornada` (`key_jornada`, `key_usuario`, `fecha`, `objetivos`, `estado`, `horas`) VALUES
(1, 1, '2010-09-22', '01011', NULL, 10),
(2, 2, '2010-09-21', '01001', NULL, 20),
(3, 1, '2010-08-2', '01010', NULL, 2),
(4, 2, '2010-09-30', '11011', NULL, 9);

INSERT INTO `actividad` (`key_actividad`, `nombre`, `objetivos`) VALUES
(1, 'Regar', '01001'),
(2, 'Cernir', '00010'),
(3, 'Jornada Especial', '01101'),
(4, 'Transplantar', '01101'),
(5, 'Recolectar Semillas', '01101');


INSERT INTO `realiza` (`key_realiza`, `key_jornada`, `key_actividad`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 1, '08:00', '09:00'),
(8, 4, 1, '15:00', '17:00'),
(3, 1, 2, '09:00', '11:00'),
(14, 2, 1, '09:00', '11:00'),
(4, 3, 3, '07:00', '10:00'),
(7, 4, 4, '13:00', '14:00'),
(2, 1, 5, '11:00', '14:00'),
(5, 3, 2, '11:00', '15:00'),
(6, 3, 4, '10:00', '11:00'),
(10, 4, 2, '14:00', '15:00');

INSERT INTO `descripcion` (`key_realiza`, `descrip`) VALUES
(2, 'Bucare, Pino'),
(1, 'Tarde'),
(4, 'Con Voluntarios Mercantil');
