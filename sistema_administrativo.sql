SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-----------------------------------------------------------------------------
-- Base de datos: `sistema_administrativo`
--

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `logs_sistema`
--

CREATE TABLE `logs_sistema` (
  `ID_LOG` int(1) NOT NULL,
  `ID_USUARIO` int(1) DEFAULT NULL,
  `ACCION` varchar(255) NOT NULL,
  `TABLA_AFECTADA` varchar(50) DEFAULT NULL,
  `REGISTRO_ID` int(11) DEFAULT NULL,
  `FECHA` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `ID_PERMISO` int(1) NOT NULL,
  `ID_USUARIO` int(1) DEFAULT NULL,
  `MODULO` varchar(50) DEFAULT NULL,
  `PUEDE_VER` tinyint(1) DEFAULT 1,
  `PUEDE_EDITAR` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `ID_PERSONAS` int(1) NOT NULL,
  `CEDULAS` varchar(20) NOT NULL,
  `NOMBRES` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `ACTIVO` tinyint(1) DEFAULT 1,
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `registro_asistencia`
--

CREATE TABLE `registro_asistencia` (
  `ID_REGISTRO` int(1) NOT NULL,
  `ID_PERSONAS` int(1) NOT NULL,
  `ID_REUNIONES` int(1) NOT NULL,
  `MARCACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `ESTADO` varchar(50) DEFAULT 'Presente',
  `METODO` varchar(50) DEFAULT 'Manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------
-- Estructura de tabla para la tabla `respaldos`
--

CREATE TABLE `respaldos` (
  `ID_RESPALDO` int(1) NOT NULL,
  `NOMBRE_ARCHIVO` varchar(255) NOT NULL,
  `VERSION` varchar(50) NOT NULL,
  `TAMANO` int(11) NOT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------
-- Estructura de tabla para la tabla `reuniones`
--

CREATE TABLE `reuniones` (
  `ID_REUNION` int(1) NOT NULL,
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
  `ESTADO` varchar(20) DEFAULT 'Programada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_USUARIO` int(1) NOT NULL,
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
  `CREADO_EN` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indices de la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD PRIMARY KEY (`ID_LOG`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`ID_PERMISO`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`ID_PERSONAS`),
  ADD UNIQUE KEY `CEDULAS` (`CEDULAS`);

--
-- Indices de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD PRIMARY KEY (`ID_REGISTRO`),
  ADD KEY `ID_PERSONAS` (`ID_PERSONAS`),
  ADD KEY `ID_REUNIONES` (`ID_REUNIONES`) USING BTREE;

--
-- Indices de la tabla `respaldos`
--
ALTER TABLE `respaldos`
  ADD PRIMARY KEY (`ID_RESPALDO`),
  ADD KEY `CREADO_POR` (`CREADO_POR`);

--
-- Indices de la tabla `reuniones`
--
ALTER TABLE `reuniones`
  ADD PRIMARY KEY (`ID_REUNION`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `CEDULA` (`CEDULA`),
  ADD UNIQUE KEY `NOMBRE_USUARIO` (`NOMBRE_USUARIO`);

-----------------------------------------------------------------------------
-- AUTO_INCREMENT de las tablas volcadas

-- AUTO_INCREMENT de la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  MODIFY `ID_LOG` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `ID_PERMISO` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `ID_PERSONAS` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  MODIFY `ID_REGISTRO` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `respaldos`
--
ALTER TABLE `respaldos`
  MODIFY `ID_RESPALDO` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `reuniones`
--
ALTER TABLE `reuniones`
  MODIFY `ID_REUNION` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_USUARIO` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-----------------------------------------------------------------------------
-- Restricciones para tablas volcadas

-- Filtros para la tabla `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD CONSTRAINT `logs_sistema_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`ID_USUARIO`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD CONSTRAINT `registro_asistencia_ibfk_1` FOREIGN KEY (`ID_PERSONAS`) REFERENCES `personas` (`ID_PERSONAS`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_reuniones_ibfk_1` FOREIGN KEY (`ID_REUNIONES`) REFERENCES `reuniones` (`ID_REUNION`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respaldos`
--
ALTER TABLE `respaldos`
  ADD CONSTRAINT `respaldos_ibfk_1` FOREIGN KEY (`CREADO_POR`) REFERENCES `usuarios` (`ID_USUARIO`);


COMMIT;

-----------------------------------------------------------------------------