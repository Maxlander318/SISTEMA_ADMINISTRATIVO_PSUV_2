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
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
INSERT INTO logs_sistema VALUES("43","1","Respaldo creado: backup_2026-05-04_18-11-23.sql","RESPALDOS","","2026-05-04 12:11:23");
INSERT INTO logs_sistema VALUES("44","3","Inicio de Sesión","USUARIOS","3","2026-05-04 12:16:47");
INSERT INTO logs_sistema VALUES("45","1","Inicio de Sesión","USUARIOS","1","2026-05-06 09:03:17");
INSERT INTO logs_sistema VALUES("46","1","Creada reunión: INFORMATIVA","REUNIONES","5","2026-05-06 09:30:42");
INSERT INTO logs_sistema VALUES("47","1","Finalizada reunión ID: 5","REUNIONES","5","2026-05-06 09:30:52");
INSERT INTO logs_sistema VALUES("48","1","Eliminada reunión ID: 5","REUNIONES","5","2026-05-06 09:31:02");
INSERT INTO logs_sistema VALUES("49","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:31:04");
INSERT INTO logs_sistema VALUES("50","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:32:57");
INSERT INTO logs_sistema VALUES("51","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:33:23");
INSERT INTO logs_sistema VALUES("52","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:34:14");
INSERT INTO logs_sistema VALUES("53","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:36:25");
INSERT INTO logs_sistema VALUES("54","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:36:45");
INSERT INTO logs_sistema VALUES("55","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:37:01");
INSERT INTO logs_sistema VALUES("56","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:37:16");
INSERT INTO logs_sistema VALUES("57","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:38:54");
INSERT INTO logs_sistema VALUES("58","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:39:16");
INSERT INTO logs_sistema VALUES("59","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:41:17");
INSERT INTO logs_sistema VALUES("60","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:42:43");
INSERT INTO logs_sistema VALUES("61","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:44:57");
INSERT INTO logs_sistema VALUES("62","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:45:09");
INSERT INTO logs_sistema VALUES("63","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:45:27");
INSERT INTO logs_sistema VALUES("64","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:51:23");
INSERT INTO logs_sistema VALUES("65","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:51:53");
INSERT INTO logs_sistema VALUES("66","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:52:59");
INSERT INTO logs_sistema VALUES("67","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:54:34");
INSERT INTO logs_sistema VALUES("68","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:57:17");
INSERT INTO logs_sistema VALUES("69","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:58:41");
INSERT INTO logs_sistema VALUES("70","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 09:59:00");
INSERT INTO logs_sistema VALUES("71","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 10:02:02");
INSERT INTO logs_sistema VALUES("72","1","Eliminada reunión ID: 4","REUNIONES","4","2026-05-06 10:09:40");
INSERT INTO logs_sistema VALUES("73","1","Creada reunión: FORMATIVA","REUNIONES","6","2026-05-06 10:10:02");
INSERT INTO logs_sistema VALUES("74","1","Eliminada reunión ID: 6","REUNIONES","6","2026-05-06 10:10:17");
INSERT INTO logs_sistema VALUES("75","1","Eliminada reunión ID: 6","REUNIONES","6","2026-05-06 10:12:44");
INSERT INTO logs_sistema VALUES("76","1","Eliminada reunión ID: 6","REUNIONES","6","2026-05-06 10:13:25");
INSERT INTO logs_sistema VALUES("77","1","Creada reunión: ORDINARIA","REUNIONES","7","2026-05-06 10:16:52");
INSERT INTO logs_sistema VALUES("78","1","Creada reunión: ORDINARIA","REUNIONES","8","2026-05-06 10:17:03");
INSERT INTO logs_sistema VALUES("79","1","Eliminada reunión ID: 7","REUNIONES","7","2026-05-06 10:18:00");
INSERT INTO logs_sistema VALUES("80","1","Eliminada reunión ID: 8","REUNIONES","8","2026-05-06 10:18:02");
INSERT INTO logs_sistema VALUES("81","1","Eliminada reunión ID: 8","REUNIONES","8","2026-05-06 10:21:05");
INSERT INTO logs_sistema VALUES("82","1","Creada reunión: ORDINARIA","REUNIONES","9","2026-05-06 10:21:19");
INSERT INTO logs_sistema VALUES("83","1","Editada reunión ID: 9","REUNIONES","9","2026-05-06 10:21:35");
INSERT INTO logs_sistema VALUES("84","1","Editada reunión ID: 9","REUNIONES","9","2026-05-06 10:21:59");
INSERT INTO logs_sistema VALUES("85","1","Editada reunión ID: 9","REUNIONES","9","2026-05-06 10:28:52");
INSERT INTO logs_sistema VALUES("86","1","Eliminada reunión ID: 9","REUNIONES","9","2026-05-06 10:28:58");
INSERT INTO logs_sistema VALUES("87","1","Creada reunión: ORDINARIA","REUNIONES","10","2026-05-06 10:29:09");
INSERT INTO logs_sistema VALUES("88","2","Inicio de Sesión","USUARIOS","2","2026-05-06 10:44:18");
INSERT INTO logs_sistema VALUES("89","1","Inicio de Sesión","USUARIOS","1","2026-05-06 11:17:29");
INSERT INTO logs_sistema VALUES("90","1","Inicio de Sesión","USUARIOS","1","2026-05-06 11:18:16");
INSERT INTO logs_sistema VALUES("91","2","Creada reunión: AMPLIADA","REUNIONES","11","2026-05-06 13:04:10");
INSERT INTO logs_sistema VALUES("92","2","Creada reunión: ORDINARIA","REUNIONES","12","2026-05-06 13:18:52");
INSERT INTO logs_sistema VALUES("93","2","Registrada asistencia de 87654321","REGISTRO_ASISTENCIA","8","2026-05-06 13:19:08");
INSERT INTO logs_sistema VALUES("94","2","Operador finalizó reunión ID: 12","REUNIONES","12","2026-05-06 13:22:06");
INSERT INTO logs_sistema VALUES("95","2","Eliminado registro de asistencia ID: 8","REGISTRO_ASISTENCIA","8","2026-05-06 13:22:15");
INSERT INTO logs_sistema VALUES("96","2","Operador eliminó reunión ID: 12","REUNIONES","12","2026-05-06 13:22:34");
INSERT INTO logs_sistema VALUES("97","2","Creada reunión: ORDINARIA","REUNIONES","13","2026-05-06 13:25:36");
INSERT INTO logs_sistema VALUES("98","2","Registrada asistencia de 87654321","REGISTRO_ASISTENCIA","9","2026-05-06 13:25:56");
INSERT INTO logs_sistema VALUES("99","2","Registrada asistencia de 28255318","REGISTRO_ASISTENCIA","10","2026-05-06 13:26:16");
INSERT INTO logs_sistema VALUES("100","2","Eliminado registro de asistencia ID: 10","REGISTRO_ASISTENCIA","10","2026-05-06 13:48:51");
INSERT INTO logs_sistema VALUES("101","2","Eliminado registro de asistencia ID: 9","REGISTRO_ASISTENCIA","9","2026-05-06 13:48:53");
INSERT INTO logs_sistema VALUES("102","2","Operador eliminó reunión ID: 13","REUNIONES","13","2026-05-06 13:48:57");
INSERT INTO logs_sistema VALUES("103","3","Inicio de Sesión","USUARIOS","3","2026-05-06 14:31:30");
INSERT INTO logs_sistema VALUES("104","2","Creada reunión: ORDINARIA","REUNIONES","14","2026-05-06 14:46:16");
INSERT INTO logs_sistema VALUES("105","2","Registrada asistencia de 28255318","REGISTRO_ASISTENCIA","11","2026-05-06 14:46:33");
INSERT INTO logs_sistema VALUES("106","1","Inicio de Sesión","USUARIOS","1","2026-05-07 11:22:46");
INSERT INTO logs_sistema VALUES("107","2","Inicio de Sesión","USUARIOS","2","2026-05-07 11:25:18");
INSERT INTO logs_sistema VALUES("108","3","Inicio de Sesión","USUARIOS","3","2026-05-07 11:25:46");
INSERT INTO logs_sistema VALUES("109","1","Inicio de Sesión","USUARIOS","1","2026-05-11 14:00:03");
INSERT INTO logs_sistema VALUES("110","2","Inicio de Sesión","USUARIOS","2","2026-05-11 14:01:54");
INSERT INTO logs_sistema VALUES("111","3","Inicio de Sesión","USUARIOS","3","2026-05-11 14:07:01");
INSERT INTO logs_sistema VALUES("112","1","Inicio de Sesión","USUARIOS","1","2026-05-13 13:44:59");
INSERT INTO logs_sistema VALUES("113","1","Inicio de Sesión","USUARIOS","1","2026-05-13 14:18:02");
INSERT INTO logs_sistema VALUES("114","1","Inicio de Sesión","USUARIOS","1","2026-05-13 14:27:11");


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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO personas VALUES("1","11111111","Juan","Perez","1","2026-04-28 12:44:31");
INSERT INTO personas VALUES("2","22222222","Maria","Gomez","1","2026-04-28 12:44:31");
INSERT INTO personas VALUES("3","12345678","juan","perez","1","2026-04-28 13:55:38");
INSERT INTO personas VALUES("4","231231","MAXLANDER","HERNANDEZ","1","2026-05-04 11:46:23");
INSERT INTO personas VALUES("5","4564564","MAXLANDER","HERNANDEZ","1","2026-05-04 12:09:49");
INSERT INTO personas VALUES("8","87654321","juan","HERNAN","1","2026-05-06 13:19:08");
INSERT INTO personas VALUES("9","28255318","MAXLANDER","HERNANDEZ","1","2026-05-06 13:26:16");


CREATE TABLE `registro_asistencia` (
  `ID_REGISTRO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERSONAS` int(11) NOT NULL,
  `ID_REUNIONES` int(11) NOT NULL,
  `MARCACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `ESTADO` varchar(50) DEFAULT 'Presente',
  `METODO` varchar(50) DEFAULT 'Manual',
  PRIMARY KEY (`ID_REGISTRO`),
  KEY `ID_PERSONAS` (`ID_PERSONAS`),
  KEY `ID_REUNIONES` (`ID_REUNIONES`) USING BTREE,
  CONSTRAINT `registro_asistencia_ibfk_1` FOREIGN KEY (`ID_PERSONAS`) REFERENCES `personas` (`ID_PERSONAS`) ON DELETE CASCADE,
  CONSTRAINT `registro_reuniones_ibfk_1` FOREIGN KEY (`ID_REUNIONES`) REFERENCES `reuniones` (`ID_REUNION`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO registro_asistencia VALUES("11","9","14","2026-05-06 14:46:33","Presente","Manual");


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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO respaldos VALUES("1","backup_2026-05-04_17-59-47.sql","20260504175947","10133","2026-05-04 11:59:47","1");
INSERT INTO respaldos VALUES("2","backup_2026-05-04_18-11-23.sql","20260504181123","11430","2026-05-04 12:11:23","1");


CREATE TABLE `reuniones` (
  `ID_REUNION` int(11) NOT NULL AUTO_INCREMENT,
  `FECHA` date NOT NULL,
  `HORA` time NOT NULL,
  `TIPO_REUNION` varchar(255) NOT NULL,
  `DESCRIPCION` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `LUGAR` varchar(255) NOT NULL,
  `PARROQUIA` enum('Simon Bolivar','Once de Abril','Vista al Sol','Chirica','Dalla Costa','Cachamay','Universidad','Unare','Yocoima','Pozo Verde','5 de Julio') NOT NULL,
  `RESPONSABLE_NOMBRE` varchar(100) NOT NULL,
  `RESPONSABLE_CEDULA` varchar(20) NOT NULL,
  `RESPONSABLE_TELEFONO` varchar(15) NOT NULL,
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp(),
  `ESTADO` varchar(20) DEFAULT 'Programada',
  PRIMARY KEY (`ID_REUNION`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO reuniones VALUES("14","2026-05-21","08:00:00","ORDINARIA","BLABLABLABLABALBAL","dada","Simon Bolivar","asda","312312","14231412312","2026-05-06 14:46:16","Programada");


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

INSERT INTO usuarios VALUES("1","Maxlander Hernandez","12345678","04120000000","admin","$2y$10$OZZLYhf630e7f6gRvGuWSeaQlLazmple3ovrIhkZiiGe6EInVKWkG","admin","1","","","2026-05-13 14:27:11","2026-05-13 14:53:31","2026-04-28 12:44:31");
INSERT INTO usuarios VALUES("2","Francisco Vallenilla","87654321","04140000000","operador","$2y$10$lZYBRlJG6XJ11oo/1avhheEnm0qma3EkpWD17QDmFiDVkYWMEMwf2","operador","1","","","2026-05-11 14:01:54","2026-05-11 14:04:20","2026-04-28 12:44:31");
INSERT INTO usuarios VALUES("3","Jesus lameda","789456123","2222222222","Jesus","$2y$10$GEwH8CJfWOyXu/gklxqcr.GKy5GHimUHoGXTjklkeff1uY87AGE/W","visualizador","1","","","2026-05-11 14:07:01","2026-05-11 15:09:46","2026-04-28 14:42:51");


SET FOREIGN_KEY_CHECKS=1;