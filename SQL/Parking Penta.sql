-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-08-2024 a las 23:02:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbpenta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `documento`, `nombre`, `email`, `telefono`) VALUES
(1, 1018741691, 'Maria Valencia', 'mariagv@gmail.com', '3128216442'),
(2, 1082375241, 'Antonio Botero', 'antonio_12_b@gmail.com', '3104880912'),
(4, 100238974, 'Camila', 'camila_12@gmail.com', '3120182636'),
(5, 19129366, 'Ana Carla', 'ana_carla_33@hotmail.com', '3120012880'),
(6, 1416680, 'Robert Pérez', 'robert.j12@gmail.com', '3040018926'),
(7, 30900021, 'Karla Bustamante', 'karlacc@outlook.es', '3115928177'),
(8, 30900022, 'Juan Gómez', 'juan_gomez@gmail.com', '3002401267');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `documento`, `nombre`, `email`, `telefono`) VALUES
(1, 1083473822, 'Angel Bustamante', 'angelbst_0101@hotmail.com', '3019182612'),
(2, 1082375241, 'Sara Ospina', 'sara077@hotmail.com', '3019182612'),
(3, 5023538, 'RamssC16', 'ramsesgpm@gmail.com', '3237832452'),
(26, 30900020, 'Ernesto Ramírez', 'ernesto_ramirez@hotmail.com', '3102030952'),
(28, 5001012, 'Ximena Toro', 'ximetorowert_@yahoo.es', '3152037108');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `idPago` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `tiempo` int(11) DEFAULT NULL,
  `tarifa` int(11) DEFAULT NULL,
  `vehiculos_id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('Admin','Empleado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `password`, `tipo_usuario`) VALUES
(2, 'camila_12@gmail.com', '$2y$10$hhI2huLUpxAGdOmMWW/Vi.XBamaO64hdeUwr/LjBhOgmsnRZXpapC', 'Admin'),
(3, 'ramsesgpm@gmail.com', '$2y$10$U1jhQplkzywNdhXh5SQsh.gLIqwJ2dTcGJAlXqC3wwDZ2PMGs77qm', 'Empleado'),
(9, 'ana_carla_33@hotmail.com', '$2y$10$DzZfslHlW7mkEYCF859mh.IijCCCCSfHF4YsZQCUTm0ECK7rVqAAq', 'Admin'),
(10, 'robert.j12@gmail.com', '$2y$10$0zJlfp5oaWHRjpp4WoRV0OyiiQw1nypZLsFUJ8mCU4CdyxGwtTO7C', 'Admin'),
(12, 'karlacc@outlook.es', '$2y$10$iBKDtjWVNdPoNq8w5vmLR.2paaVLyPiTvlqmMz9F2ZQN/ITGqhcJy', 'Admin'),
(14, 'ernesto_ramirez@hotmail.com', '$2y$10$9M0vou2s.ahi/4.c0xx4J..WyEaFzXpurcjyEgJISEz9Ksm9Jblm6', 'Empleado'),
(16, 'ximetorowert_@yahoo.es', '$2y$10$J9ycJ0LT8sMy0jhIycTbf.5.nj12nVc9oVAQejIvTJMnZ.iV78mia', 'Empleado'),
(17, 'juan_gomez@gmail.com', '$2y$10$b/LrTI.Q0x4mpbmZHLwYSuFLmHC1WZWumpVyuOvZO8PwUvJ6g2qJa', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `placa` int(11) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `empleados_id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document` (`documento`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `fk_Pago_vehiculos1_idx` (`vehiculos_id_vehiculo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `fk_vehiculos_empleados1_idx` (`empleados_id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `placa` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_Pago_vehiculos1` FOREIGN KEY (`vehiculos_id_vehiculo`) REFERENCES `vehiculos` (`placa`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `fk_vehiculos_empleados1` FOREIGN KEY (`empleados_id_empleado`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
