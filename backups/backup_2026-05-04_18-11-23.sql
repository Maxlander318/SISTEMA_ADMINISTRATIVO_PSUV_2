SET FOREIGN_KEY_CHECKS=0;



CREATE TABLE `logs_sistema` (
  `ID_LOG` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `ACCION` varchar(255) NOT NULL,
  `TABLA_AFECTADA` varchar(50) DEFAULT NULL,
  `REGISTRO_ID` int(11) DEFAULT NULL,
  `FECHA` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_LOG`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `logs_sistema_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO logs_sistema VALUES("1","1","Inicio de Sesión","USUARIOS","1","2026-04-28 13:16:38");
INSERT INTO logs_sistema VALUES("2","1","Inicio de Sesión","USUARIOS","1","2026-04-28 13:40:24");
INSERT INTO logs_sistema VALUES("3","1","Inicio de Sesión","USUARIOS","1","2026-04-28 13:43:02");
INSERT INTO logs_sistema VALUES("4","2","Inicio de Sesión","USUARIOS","2","2026-04-28 13:43:39");
INSERT INTO logs_sistema VALUES("5","2","Creada sesión: formacion","SESIONES","3","2026-04-28 13:54:52");
INSERT INTO logs_sistema VALUES("6","2","Registrada asistencia de 12345678 en sesión ID: 3","REGISTRO_ASISTENCIA","3","2026-04-28 13:55:38");
INSERT INTO logs_sistema VALUES("7","2","Eliminado registro de asistencia ID: 1","REGISTRO_ASISTENCIA","1","2026-04-28 13:55:43");
INSERT INTO logs_sistema VALUES("8","2","Eliminado registro de asistencia ID: 2","REGISTRO_ASISTENCIA","2","2026-04-28 13:55:47");
INSERT INTO logs_sistema VALUES("9","2","Eliminado registro de asistencia ID: 3","REGISTRO_ASISTENCIA","3","2026-04-28 14:01:00");
INSERT INTO logs_sistema VALUES("10","1","Inicio de Sesión","USUARIOS","1","2026-04-28 14:38:26");
INSERT INTO logs_sistema VALUES("11","1","Inicio de Sesión","USUARIOS","1","2026-04-28 14:42:17");
INSERT INTO logs_sistema VALUES("12","1","Creado usuario: Jesus","USUARIOS","3","2026-04-28 14:42:51");
INSERT INTO logs_sistema VALUES("13","3","Inicio de Sesión","USUARIOS","3","2026-04-28 14:43:26");
INSERT INTO logs_sistema VALUES("14","1","Inicio de Sesión","USUARIOS","1","2026-04-28 14:58:56");
INSERT INTO logs_sistema VALUES("15","1","Creada reunión: blabla","REUNIONES","1","2026-04-28 15:02:05");
INSERT INTO logs_sistema VALUES("16","1","Eliminada reunión ID: 1","REUNIONES","1","2026-04-28 15:02:35");
INSERT INTO logs_sistema VALUES("17","1","Inicio de Sesión","USUARIOS","1","2026-05-04 11:41:32");
INSERT INTO logs_sistema VALUES("18","2","Inicio de Sesión","USUARIOS","2","2026-05-04 11:44:25");
INSERT INTO logs_sistema VALUES("19","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:45:19");
INSERT INTO logs_sistema VALUES("20","2","Operador creó reunión: blabla","REUNIONES","2","2026-05-04 11:46:03");
INSERT INTO logs_sistema VALUES("21","2","Registrada asistencia de 231231 en sesión ID: 3","REGISTRO_ASISTENCIA","4","2026-05-04 11:46:23");
INSERT INTO logs_sistema VALUES("22","2","Eliminado registro de asistencia ID: 4","REGISTRO_ASISTENCIA","4","2026-05-04 11:46:27");
INSERT INTO logs_sistema VALUES("23","2","Operador finalizó reunión ID: 2","REUNIONES","2","2026-05-04 11:46:35");
INSERT INTO logs_sistema VALUES("24","2","Operador eliminó reunión ID: 2","REUNIONES","2","2026-05-04 11:46:49");
INSERT INTO logs_sistema VALUES("25","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:46:58");
INSERT INTO logs_sistema VALUES("26","2","Operador creó reunión: blabla","REUNIONES","3","2026-05-04 11:48:09");
INSERT INTO logs_sistema VALUES("27","2","Operador eliminó reunión ID: 3","REUNIONES","3","2026-05-04 11:48:13");
INSERT INTO logs_sistema VALUES("28","2","Operador eliminó reunión ID: 3","REUNIONES","3","2026-05-04 11:48:17");
INSERT INTO logs_sistema VALUES("29","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:48:41");
INSERT INTO logs_sistema VALUES("30","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:49:07");
INSERT INTO logs_sistema VALUES("31","2","Inicio de Sesión","USUARIOS","2","2026-05-04 11:49:16");
INSERT INTO logs_sistema VALUES("32","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:50:55");
INSERT INTO logs_sistema VALUES("33","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 11:51:16");
INSERT INTO logs_sistema VALUES("34","2","Inicio de Sesión","USUARIOS","2","2026-05-04 11:51:27");
INSERT INTO logs_sistema VALUES("35","2","Inicio de Sesión","USUARIOS","2","2026-05-04 11:53:39");
INSERT INTO logs_sistema VALUES("36","1","Respaldo creado: backup_2026-05-04_17-59-47.sql","RESPALDOS","","2026-05-04 11:59:47");
INSERT INTO logs_sistema VALUES("37","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 12:02:04");
INSERT INTO logs_sistema VALUES("38","1","Cambiado estado usuario ID: 2","USUARIOS","2","2026-05-04 12:02:16");
INSERT INTO logs_sistema VALUES("39","2","Inicio de Sesión","USUARIOS","2","2026-05-04 12:02:32");
INSERT INTO logs_sistema VALUES("40","1","Creada reunión: blabla","REUNIONES","4","2026-05-04 12:04:29");
INSERT INTO logs_sistema VALUES("41","1","Finalizada reunión ID: 4","REUNIONES","4","2026-05-04 12:05:09");
INSERT INTO logs_sistema VALUES("42","2","Registrada asistencia de 4564564 en sesión ID: 2","REGISTRO_ASISTENCIA","5","2026-05-04 12:09:49");


CREATE TABLE `permisos` (
  `ID_PERMISO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `MODULO` varchar(50) DEFAULT NULL,
  `PUEDE_VER` tinyint(1) DEFAULT 1,
  `PUEDE_EDITAR` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`ID_PERMISO`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO permisos VALUES("2","2","Agenda","1","0");
INSERT INTO permisos VALUES("3","2","Reportes","1","0");
INSERT INTO permisos VALUES("4","2","Usuarios","1","0");
INSERT INTO permisos VALUES("5","2","Respaldos","1","0");
INSERT INTO permisos VALUES("6","2","Auditoria","1","0");


CREATE TABLE `personas` (
  `ID_PERSONAS` int(11) NOT NULL AUTO_INCREMENT,
  `CEDULAS` varchar(20) NOT NULL,
  `NOMBRES` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `ACTIVO` tinyint(1) DEFAULT 1,
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_PERSONAS`),
  UNIQUE KEY `CEDULAS` (`CEDULAS`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO personas VALUES("1","11111111","Juan","Perez","1","2026-04-28 12:44:31");
INSERT INTO personas VALUES("2","22222222","Maria","Gomez","1","2026-04-28 12:44:31");
INSERT INTO personas VALUES("3","12345678","juan","perez","1","2026-04-28 13:55:38");
INSERT INTO personas VALUES("4","231231","MAXLANDER","HERNANDEZ","1","2026-05-04 11:46:23");
INSERT INTO personas VALUES("5","4564564","MAXLANDER","HERNANDEZ","1","2026-05-04 12:09:49");


CREATE TABLE `registro_asistencia` (
  `ID_REGISTRO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERSONAS` int(11) NOT NULL,
  `ID_SESIONES` int(11) NOT NULL,
  `MARCACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `ESTADO` varchar(50) DEFAULT 'Presente',
  `METODO` varchar(50) DEFAULT 'Manual',
  PRIMARY KEY (`ID_REGISTRO`),
  KEY `ID_PERSONAS` (`ID_PERSONAS`),
  KEY `ID_SESIONES` (`ID_SESIONES`),
  CONSTRAINT `registro_asistencia_ibfk_1` FOREIGN KEY (`ID_PERSONAS`) REFERENCES `personas` (`ID_PERSONAS`) ON DELETE CASCADE,
  CONSTRAINT `registro_asistencia_ibfk_2` FOREIGN KEY (`ID_SESIONES`) REFERENCES `sesiones` (`ID_SESION`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO registro_asistencia VALUES("5","5","2","2026-05-04 12:09:49","Justificado","Manual");


CREATE TABLE `respaldos` (
  `ID_RESPALDO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ARCHIVO` varchar(255) NOT NULL,
  `VERSION` varchar(50) NOT NULL,
  `TAMANO` int(11) NOT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_RESPALDO`),
  KEY `CREADO_POR` (`CREADO_POR`),
  CONSTRAINT `respaldos_ibfk_1` FOREIGN KEY (`CREADO_POR`) REFERENCES `usuarios` (`ID_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO respaldos VALUES("1","backup_2026-05-04_17-59-47.sql","20260504175947","10133","2026-05-04 11:59:47","1");


CREATE TABLE `reuniones` (
  `ID_REUNION` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `HORA` time NOT NULL,
  `TIPO_REUNION` varchar(255) NOT NULL,
  `LUGAR` varchar(255) NOT NULL,
  `PARROQUIA` enum('Simon Bolivar','Once de Abril','Vista al Sol','Chirica','Dalla Costa','Cachamay','Universidad','Unare','Yocoima','Pozo Verde','5 de Julio') NOT NULL,
  `RESPONSABLE_NOMBRE` varchar(100) NOT NULL,
  `RESPONSABLE_CEDULA` varchar(20) NOT NULL,
  `RESPONSABLE_TELEFONO` varchar(15) NOT NULL,
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp(),
  `ESTADO` varchar(20) DEFAULT 'Programada',
  PRIMARY KEY (`ID_REUNION`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO reuniones VALUES("4","2026-05-16","08:00:00","blabla","pepe","Simon Bolivar","dada","312312","14231412312","2026-05-04 12:04:29","Finalizada");


CREATE TABLE `sesiones` (
  `ID_SESION` int(11) NOT NULL AUTO_INCREMENT,
  `TITULO` varchar(255) NOT NULL,
  `FECHA` date NOT NULL,
  `HORA_INICIO` time NOT NULL,
  `TIPO` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_SESION`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sesiones VALUES("1","Asamblea General","2023-10-27","09:00:00","Ordinaria");
INSERT INTO sesiones VALUES("2","Taller Formacion","2023-10-28","14:00:00","Capacitacion");
INSERT INTO sesiones VALUES("3","formacion","2026-04-17","17:54:00","capacitacion");


CREATE TABLE `usuarios` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_COMPLETO` varchar(100) NOT NULL,
  `CEDULA` varchar(20) NOT NULL,
  `TELEFONO` varchar(15) NOT NULL,
  `NOMBRE_USUARIO` varchar(50) NOT NULL,
  `CONTRASENA` varchar(255) NOT NULL,
  `NIVEL` enum('admin','operador','visualizador') DEFAULT 'operador',
  `ACTIVO` tinyint(1) DEFAULT 1,
  `TOKEN_RECUPERACION` varchar(255) DEFAULT NULL,
  `TOKEN_EXPIRA` datetime DEFAULT NULL,
  `ULTIMA_CONEXION` datetime DEFAULT NULL,
  `ULTIMA_ACTIVIDAD` datetime DEFAULT NULL,
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID_USUARIO`),
  UNIQUE KEY `CEDULA` (`CEDULA`),
  UNIQUE KEY `NOMBRE_USUARIO` (`NOMBRE_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO usuarios VALUES("1","Maxlander Hernandez","12345678","04120000000","admin","$2y$10$OZZLYhf630e7f6gRvGuWSeaQlLazmple3ovrIhkZiiGe6EInVKWkG","admin","1","","","2026-05-04 11:41:31","2026-05-04 12:11:23","2026-04-28 12:44:31");
INSERT INTO usuarios VALUES("2","Francisco Vallenilla","87654321","04140000000","operador","$2y$10$lZYBRlJG6XJ11oo/1avhheEnm0qma3EkpWD17QDmFiDVkYWMEMwf2","operador","1","","","2026-05-04 12:02:32","2026-05-04 12:09:49","2026-04-28 12:44:31");
INSERT INTO usuarios VALUES("3","Jesus lameda","789456123","2222222222","Jesus","$2y$10$HD/nMYOPmSTgDs2DA/SAG.ui2OTlTFnZ4p0.5GkEdGAMASyf7Jr0q","visualizador","1","","","2026-04-28 14:43:26","2026-04-28 14:53:29","2026-04-28 14:42:51");


SET FOREIGN_KEY_CHECKS=1;