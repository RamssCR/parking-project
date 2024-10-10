-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2024 a las 16:53:56
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
  `nombre` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `documento`, `nombre`, `email`, `telefono`) VALUES
(2, 5023538, 'Ramsés Pérez', 'ramsesgpm@gmail.com', '3235089908'),
(3, 1002893471, 'Enrico Gutiérrez', 'enrico.eg12.eg24@yahoo.es', '3118591382');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `deshabilitado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `documento`, `nombre`, `ciudad`, `direccion`, `telefono`, `email`, `deshabilitado`) VALUES
(1, 1034985723, 'Samanta Hernández López', 'Rionegro', 'Cra. 31A #12D - 21', '3029832661', 'saman_thha12@gmail.com', 0),
(2, 1093485734, 'Roberto Botero', 'La Ceja', 'Cra. 45A #33C - 20', '3218932641', 'robertobtr_btr20@gmail.com', 0),
(3, 1290348265, 'Germán González', 'Marinilla', 'Cra. 21C #47D - 29', '3159713491', 'german_german@gmail.com', 0),
(4, 30754185, 'Pablo Quintero', 'El Carmen de Viboral', 'Cra. 40A #18 - 20D', '3205129710', 'pabloqt_q49@gmail.com', 0);

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
(36, 1001849637, 'Ernesto López', 'ernest_balt@vivint.com', '3129502660'),
(37, 1002387423, 'Ricardo Ibarra', 'rick_12@outlook.es', '3160247183'),
(38, 1002003004, 'Jesús Gómez', 'jesusggg@outlook.es', '3196047832');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lockers`
--

CREATE TABLE `lockers` (
  `id_locker` int(11) NOT NULL,
  `codigo_locker` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lockers`
--

INSERT INTO `lockers` (`id_locker`, `codigo_locker`) VALUES
(1, 'A01'),
(2, 'A02'),
(3, 'A03'),
(4, 'A04'),
(5, 'A05'),
(6, 'A06'),
(7, 'A07'),
(8, 'A08'),
(9, 'A09'),
(10, 'A10'),
(11, 'A11'),
(12, 'A12'),
(13, 'A13'),
(14, 'A14'),
(15, 'A15'),
(16, 'A16'),
(17, 'A17'),
(18, 'A18'),
(19, 'A19'),
(20, 'A20'),
(21, 'B01'),
(22, 'B02'),
(23, 'B03'),
(24, 'B04'),
(25, 'B05'),
(26, 'B06'),
(27, 'B07'),
(28, 'B08'),
(29, 'B09'),
(30, 'B10'),
(31, 'B11'),
(32, 'B12'),
(33, 'B13'),
(34, 'B14'),
(35, 'B15'),
(36, 'B16'),
(37, 'B17'),
(38, 'B18'),
(39, 'B19'),
(40, 'B20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locker_cliente`
--

CREATE TABLE `locker_cliente` (
  `id_cliente_locker` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_locker` int(11) NOT NULL,
  `asignado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tiempo` int(11) NOT NULL,
  `tarifa` int(11) NOT NULL,
  `deshabilitado` tinyint(4) NOT NULL DEFAULT 0,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `total`, `tiempo`, `tarifa`, `deshabilitado`, `id_vehiculo`) VALUES
(1, 40000, 2, 20000, 0, 8),
(14, 15000, 1, 15000, 0, 8),
(16, 20000, 1, 20000, 0, 7),
(18, 60000, 3, 20000, 0, 6),
(19, 40000, 2, 20000, 0, 6),
(20, 30000, 2, 15000, 0, 4),
(21, 80000, 4, 20000, 0, 7),
(22, 960000, 64, 15000, 0, 4),
(23, 255000, 17, 15000, 0, 8),
(24, 15000, 1, 15000, 0, 4),
(25, 15000, 1, 15000, 0, 8),
(26, 1890000, 126, 15000, 0, 4),
(27, 2520000, 126, 20000, 0, 6),
(28, 2520000, 126, 20000, 0, 7),
(29, 15000, 1, 15000, 0, 9),
(30, 15000, 1, 15000, 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_cliente_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(30) NOT NULL,
  `id_cliente_fk` int(11) NOT NULL,
  `habilitado` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_cliente_servicio`, `nombre_servicio`, `id_cliente_fk`, `habilitado`) VALUES
(3, 'Locker', 2, 1),
(4, 'Autolavado', 2, 1),
(5, 'Locker', 1, 1),
(6, 'Autolavado', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('Admin','Empleado') DEFAULT NULL,
  `pic_user` varchar(100) NOT NULL DEFAULT 'blank-avatar.webp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email`, `password`, `tipo_usuario`, `pic_user`) VALUES
(4, 'Ramsés Pérez', 'ramsesgpm@gmail.com', '$2y$10$xGbbuHfDaOzEiCQx.eVq5u73U4F75E/RiX.b0AK6tXdvQSuWaHl7u', 'Admin', 'blank-avatar.webp'),
(7, 'Ernesto López', 'ernest_balt@vivint.com', '$2y$10$Z1b12tB.lFk/h7ztBUGcaeQe5/FLfbSDAoBxBVODyv6p3GB3VMCLe', 'Empleado', 'blank-avatar.webp'),
(8, 'Ricardo Ibarra', 'rick_12@outlook.es', '$2y$10$BPcULcn.HOQyXtZpZTtCB.GYfjwhud/SOK7L805gypEqJBX7GxLPO', 'Empleado', 'blank-avatar.webp'),
(9, 'Jesús Gómez', 'jesusggg@outlook.es', '$2y$10$VoyNbV0SIvhYq.VkSBVzZelmP/l.CYw2O/NMnJUquJ4IHBKlyGiVa', 'Empleado', 'blank-avatar.webp'),
(10, 'Enrico Gutiérrez', 'enrico.eg12.eg24@yahoo.es', '$2y$10$ertY2EePYdULXM80BQ3Iie2RUy6IZHleM0PZ86OpDsXwf5OO1ejra', 'Admin', 'blank-avatar.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL,
  `tipo_vehiculo` varchar(15) NOT NULL,
  `deshabilitado` tinyint(4) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `placa`, `marca`, `modelo`, `ano`, `tipo_vehiculo`, `deshabilitado`, `id_cliente`, `id_empleado`) VALUES
(4, 'BAL-96C', 'Yamaha', 'XGKG 40', 2024, 'moto', 0, 1, 38),
(6, 'BAL-969', 'Ford', 'Ford B9917', 2024, 'carro', 0, 1, 38),
(7, 'KRB-051', 'Toyota', 'Toyota 25GY', 2023, 'carro', 0, 1, 38),
(8, 'GOQ-97B', 'Yamaha', 'Blue Eagle X209', 2024, 'moto', 0, 2, 38),
(9, 'HUD-06H', 'Mitsubishi', 'Dark Ocean HYQ18', 2020, 'moto', 0, 4, 38);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `lockers`
--
ALTER TABLE `lockers`
  ADD PRIMARY KEY (`id_locker`),
  ADD UNIQUE KEY `codigo_locker` (`codigo_locker`) USING HASH;

--
-- Indices de la tabla `locker_cliente`
--
ALTER TABLE `locker_cliente`
  ADD PRIMARY KEY (`id_cliente_locker`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_locker` (`id_locker`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_Pago_vehiculos1_idx` (`id_vehiculo`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_cliente_servicio`),
  ADD KEY `id_cliente_fk` (`id_cliente_fk`),
  ADD KEY `id_cliente_fk_2` (`id_cliente_fk`);

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
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `fk_vehiculos_empleados1_idx` (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `lockers`
--
ALTER TABLE `lockers`
  MODIFY `id_locker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `locker_cliente`
--
ALTER TABLE `locker_cliente`
  MODIFY `id_cliente_locker` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_cliente_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `locker_cliente`
--
ALTER TABLE `locker_cliente`
  ADD CONSTRAINT `locker_cliente_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `locker_cliente_ibfk_2` FOREIGN KEY (`id_locker`) REFERENCES `lockers` (`id_locker`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_Pago_vehiculos1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_cliente_fk`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `fk_vehiculos_empleados1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
