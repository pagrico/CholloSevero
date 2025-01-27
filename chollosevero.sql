-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 27-01-2025 a las 11:10:44
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chollosevero`
--
CREATE DATABASE IF NOT EXISTS `chollosevero` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `chollosevero`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chollos`
--

CREATE TABLE `chollos` (
  `id_chollo` int NOT NULL,
  `id_usuario` int NOT NULL,
  `titulo_chollo` varchar(100) NOT NULL,
  `descripcion_chollo` text NOT NULL,
  `precio_chollo` decimal(10,2) NOT NULL,
  `imagen_chollo` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `chollos`
--

INSERT INTO `chollos` (`id_chollo`, `id_usuario`, `titulo_chollo`, `descripcion_chollo`, `precio_chollo`, `imagen_chollo`, `fecha_creacion`) VALUES
(1, 1, 'Oferta en portátil HP', 'Portátil HP Pavilion con descuento del 20%. Ideal para estudiantes y profesionales.', 750.00, '/imagenes/foto1.jpg', '2025-01-24 00:00:00'),
(2, 2, 'Auriculares Sony WH-1000XM4', 'Auriculares con cancelación de ruido y sonido de alta calidad. Oferta especial por tiempo limitado.', 300.00, '/imagenes/foto1.jpg', '2025-01-23 00:00:00'),
(3, 3, 'Smartphone Samsung Galaxy S22', 'Teléfono de última generación con descuento del 15%. ¡No te lo pierdas!', 999.99, '/imagenes/foto1.jpg', '2025-01-22 00:00:00'),
(4, 4, 'Smartwatch Fitbit Versa 3', 'Reloj inteligente con monitorización de actividad física y funciones avanzadas.', 199.99, '/imagenes/foto1.jpg', '2025-01-21 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena_usuario` varchar(255) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `id_rol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `contrasena_usuario`, `correo_usuario`, `id_rol`) VALUES
(1, 'admin', '$2y$10$HMAkrVUipn11YhwAYS/j3OntjTMp/10rKKmLK7In19WRmmg7uKS8C', 'admin@example.com', 1),
(2, 'usuario1', '$2y$10$Y4XHVe1YRiRFPLFQ8To1o.ORQVcwvmer1AmGYcKA/fkmOVa93w2sW', 'usuario1@example.com', 2),
(3, 'usuario2', '$2y$10$SQbnrD9iaXli2zFmnDr7eO0yCCYVb20RRcXCP9l/sXiQSEKhARf4O', 'usuario2@example.com', 2),
(4, 'usuario3', '$2y$10$wKdTMiWkaV5LZ4.kxPLdge0p3Xo0yLbdjbLSpBGCuO7HxRqZyjtPa', 'usuario3@example.com', 2),
(5, 'usuario4', '$2y$10$IEfuCDwscoeswAGZT1zU5utWnlwNBvTMqgI6WC/cU2CWc5ACHxFOm', 'usuario4@example.com', 2),
(6, 'usuario5', '$2y$10$vomPo58ti86uMzeRqsg8j.iKK.pI5Krg6LyPyxcBYTBSo49rCc6Iq', 'usuario5@example.com', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chollos`
--
ALTER TABLE `chollos`
  ADD PRIMARY KEY (`id_chollo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chollos`
--
ALTER TABLE `chollos`
  MODIFY `id_chollo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chollos`
--
ALTER TABLE `chollos`
  ADD CONSTRAINT `chollos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
