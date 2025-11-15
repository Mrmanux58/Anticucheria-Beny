-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2025 a las 03:11:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `anticucheria_beny`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(2, 'administrador', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(10, 6, 1, 'Mixto 3', 27, 1, 'Mixto_3.webp'),
(11, 6, 2, 'Mixto 4', 27, 1, 'Mixto_4.webp'),
(15, 2, 1, 'Mixto 3', 27, 1, 'Mixto_3.webp'),
(16, 7, 3, 'Mixto 7', 33, 1, 'Mixto_7.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `read_status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `subject`, `message`, `timestamp`, `read_status`) VALUES
(2, 3, 'Romina', 'Romina@gmail.com', '999999456', '', 'Mensajee de prueba', '2025-06-07 23:42:06', 0),
(3, 4, 'Alex Cabrera', 'alex.cabreralazaro1@gmail.com', '999888552', '', 'mensaje de prueba abril 2025', '2025-06-07 23:42:06', 0),
(5, 4, 'Alex Cabrera', 'alex.cabreralazaro1@gmail.com', '974452859', 'prueba', 'hola', '2025-06-07 23:42:44', 0),
(6, 4, 'Alex Cabrera', 'alex.cabreralazaro1@gmail.com', '974452859', 'prueba', 'hola', '2025-06-07 23:44:11', 0),
(7, 4, 'Alex Cabrera', 'alex.cabreralazaro1@gmail.com', '974452859', 'prueba', 'hola', '2025-06-07 23:45:20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` text NOT NULL,
  `total_price` float NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `updated_at`, `updated_by`) VALUES
(3, 1, 'Jose', '241421241', 'jose@gmail.com', 'tarjeta de credito', 'Av lANUS, ATE', 'Mixto 4 (27 x 1) - ', 27, '2024-11-30 23:16:11', 'pending', NULL, NULL),
(4, 3, 'Romina', '999999456', 'Romina@gmail.com', 'pago contra entrega', 'Lima, Los olivos', 'Mixto 4 (27 x 1) - Coca Cola (8 x 1) - ', 35, '2024-11-30 23:37:44', 'Terminada', NULL, NULL),
(5, 6, 'Alex Cabrera', '97445555', 'alex_cl16@hotmail.com', 'cash on delivery', 'flat no. Calle Miguel Anco Las Magnolias Mz B lt 21, aa, Lima, Lima Metropolitana, Perú - 15312', 'Mixto 4 (27 x 3) - ', 81, '2025-05-27 01:08:30', 'Pendiente', NULL, NULL),
(6, 4, 'Alex Cabrera', '974452859', 'alex.cabreralazaro@gmail.com', 'cash on delivery', 'flat no. 1, 2, lima, lima, peru - 15932', 'Coca Cola (8 x 1) - Mixto 3 (27 x 1) - ', 35, '2025-06-08 04:57:29', 'Terminada', '2025-06-08 00:13:29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(11) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(1, 'Mixto 3', 'Pancita, rachi y anticucho de corazón de res a la parrilla acompañados de papas fritas o sancochadas, rodaja de choclo y fresca ensalada.', 27, 'Mixto_3.webp', 'Mixto_3.webp', 'Mixto_3.webp'),
(2, 'Mixto 4', 'Mollejitas de pollo y anticucho de corazón a la parrilla acompañados de papas fritas o sancochadas, rodaja de choclo y fresca ensalada.', 27, 'Mixto_4.webp', 'Mixto_4.webp', 'Mixto_4.webp'),
(3, 'Mixto 7', 'Molleja, pancita, rachi, anticucho y chuleta de cerdo a la parrilla acompañados de papas fritas o sancochadas, rodaja de choclo y fresca ensalada.', 33, 'Mixto_7.webp', 'Mixto_7.webp', 'Mixto_7.webp'),
(4, 'Chicha Morada', '1 Litro', 6, 'chicha.png', 'chicha.png', 'chicha.png'),
(5, 'Coca Cola', '1.5 Litros', 8, 'Coca_Cola.webp', 'Coca_Cola.webp', 'Coca_Cola.webp'),
(8, 'parrilla combo20', 'la mejor promocion', 50, 'images.jpg', 'images.jpg', 'images.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Jose', 'jose@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964'),
(2, 'Alex', 'alex.cabreralazaro@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(3, 'Romina', 'Romina@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(4, 'Alex Cabrera', 'alex.cabreralazaro1@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(5, 'administrador2', 'alex_cl16@hotmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(6, 'Alex', 'alex_cl1611@hotmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(7, 'juan', 'juan123@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
(12, 'Maria', 'maria1234@gmail.com', '9e9fb64c5fc4f351b8214465a824311070527b3c');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `name`, `price`, `image`) VALUES
(4, 12, 8, 'parrilla combo20', 50, 'images.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pid` (`pid`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pid` (`pid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
