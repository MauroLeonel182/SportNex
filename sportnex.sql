-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2024 a las 22:25:00
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sportnex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancha`
--

CREATE TABLE `cancha` (
  `cancha_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_deporte_id` int(11) DEFAULT NULL,
  `disponibilidad` varchar(30) DEFAULT 'Disponible',
  `urlfoto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cancha`
--

INSERT INTO `cancha` (`cancha_id`, `nombre`, `precio`, `tipo_deporte_id`, `disponibilidad`, `urlfoto`) VALUES
(2, 'CANCHA UNO PADEL', 8000.00, 1, 'Disponible', 'cancha1.jpeg'),
(7, 'CANCHA DOS PADEL', 10000.00, 1, 'Disponible', 'cancha2.jpg'),
(9, 'CANCHA TRES PADEL', 9000.00, 1, 'Disponible', 'cancha3.jpg'),
(10, 'CANCHA UNO FUTBOL', 10000.00, 2, 'Disponible', 'cancha4.jpeg'),
(11, 'CANCHA DOS FUTBOL', 10000.00, 2, 'Disponible', 'cancha5.jpg'),
(12, 'CANCHA TRES FUTBOL', 90000.00, 2, 'No Disponible', 'cancha6.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `reserva_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `persona_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`persona_id`, `nombre`, `apellido`, `email`, `dni`, `telefono`) VALUES
(7, 'Leo', 'Mauro', 'laionelasd@gmail.com', '41500523', '3644546588'),
(8, 'Prueba', 'Usuario', 'institute.manto@gmail.com', '20223222', '3644328383');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `reserva_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cancha_id` int(11) DEFAULT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`reserva_id`, `usuario_id`, `cancha_id`, `fecha_reserva`, `hora_inicio`, `hora_fin`, `estado`) VALUES
(8, 8, 7, '2024-10-17', '16:00:00', '16:53:00', 'FINALIZADA'),
(11, 7, 7, '2024-10-17', '15:00:00', '16:00:00', 'FINALIZADA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_deporte`
--

CREATE TABLE `tipo_deporte` (
  `tipo_deporte_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_deporte`
--

INSERT INTO `tipo_deporte` (`tipo_deporte_id`, `nombre`) VALUES
(1, 'PADEL'),
(2, 'FUTBOL'),
(7, 'HOCKEY');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nombre_usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('cliente','administrador') NOT NULL DEFAULT 'cliente',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expira` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `email`, `nombre_usuario`, `contrasena`, `fecha_registro`, `rol`, `reset_token`, `reset_token_expira`) VALUES
(7, 'laionelasd@gmail.com', 'MauroErlan7', '$2y$10$sT9zHcCFrP7o1fyCuZ9P5.4Kk1fySy5Z9TYHR2kUXsTJAt91xJGT.', '2024-10-01 22:42:42', 'administrador', NULL, NULL),
(8, 'institute.manto@gmail.com', 'Prueba', '$2y$10$VmQKNgPgGLhIMFHpvlZn1.4Zw8skcJ0N4bIovVpFILSUaFrSWuada', '2024-10-02 22:10:12', 'cliente', 'b83d0449a9435dc17601e7a3fac81b91', '2024-10-17 18:21:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cancha`
--
ALTER TABLE `cancha`
  ADD PRIMARY KEY (`cancha_id`),
  ADD KEY `tipo_deporte_id` (`tipo_deporte_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`persona_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`reserva_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cancha_id` (`cancha_id`);

--
-- Indices de la tabla `tipo_deporte`
--
ALTER TABLE `tipo_deporte`
  ADD PRIMARY KEY (`tipo_deporte_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cancha`
--
ALTER TABLE `cancha`
  MODIFY `cancha_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `persona_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `reserva_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_deporte`
--
ALTER TABLE `tipo_deporte`
  MODIFY `tipo_deporte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cancha`
--
ALTER TABLE `cancha`
  ADD CONSTRAINT `cancha_ibfk_1` FOREIGN KEY (`tipo_deporte_id`) REFERENCES `tipo_deporte` (`tipo_deporte_id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`cancha_id`) REFERENCES `cancha` (`cancha_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`email`) REFERENCES `persona` (`email`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `actualizar_estado_reservas` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-10-17 16:38:26' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE reservas
    SET estado = 'FINALIZADA'
    WHERE hora_fin < NOW() AND estado = 'PENDIENTE'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
