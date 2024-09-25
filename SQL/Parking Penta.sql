-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2024 a las 16:00:50
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
(2, 5023538, 'Ramsés Pérez', 'ramsesgpm@gmail.com', '3235089908');

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
(3, 1290348265, 'Germán González', 'Marinilla', 'Cra. 21C #47D - 29', '3159713491', 'german_german@gmail.com', 0);

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
(9, 'Jesús Gómez', 'jesusggg@outlook.es', '$2y$10$VoyNbV0SIvhYq.VkSBVzZelmP/l.CYw2O/NMnJUquJ4IHBKlyGiVa', 'Empleado', 'blank-avatar.webp');

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
(4, 'BAL-96C', 'Yamaha', 'XGKG 39', 2022, 'moto', 0, 1, 38),
(6, 'BAL-969', 'Ford', 'Ford B9917', 2024, 'carro', 0, 1, 38),
(7, 'KRB-051', 'Toyota', 'Toyota 25GY', 2023, 'carro', 0, 1, 38),
(8, 'GOQ-97B', 'Yamaha', 'Blue Eagle X205', 2024, 'moto', 0, 2, 38);

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
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_Pago_vehiculos1_idx` (`id_vehiculo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_Pago_vehiculos1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`);

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
