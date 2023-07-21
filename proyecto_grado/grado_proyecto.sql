-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-07-2023 a las 01:03:51
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grado_proyecto`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `add_product_car`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_product_car` (IN `idProducto` INT, IN `tokenU` VARCHAR(50), IN `cantidadP` INT)   BEGIN
DECLARE precioProduct DECIMAL(10,2);
SET precioProduct = (SELECT precio FROM productos WHERE id = idProducto);
INSERT INTO carrito_ventas (token, producto, cantidad, precio) VALUES(tokenU, idProducto, cantidadP, precioProduct);
END$$

DROP PROCEDURE IF EXISTS `add_product_carR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_product_carR` (IN `idProducto` INT, IN `cantidadC` INT)   BEGIN
DECLARE cantidadU INT;
DECLARE cantidadSuma INT;
SET cantidadU = (SELECT cantidad FROM carrito_ventas WHERE producto = idProducto);
SET cantidadSuma = cantidadU + cantidadC;
UPDATE carrito_ventas SET cantidad = cantidadSuma WHERE producto = idProducto;
END$$

DROP PROCEDURE IF EXISTS `procesarVenta`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `procesarVenta` (IN `idUsuario` INT, IN `token_user` VARCHAR(50), IN `totalVenta` DECIMAL(10,2))   BEGIN
DECLARE venta INT;
DECLARE registros INT;
DECLARE total DECIMAL(10,2);
DECLARE tmp_cod_producto int;
DECLARE tmp_cant_producto int;
DECLARE a int;
    SET a = 1;
    SET registros = (SELECT COUNT(*) FROM carrito_ventas WHERE token= token_user);
    IF registros > 0 THEN
        INSERT INTO ventas(usuario) VALUES(idUsuario);
        SET venta = LAST_INSERT_ID();
        INSERT INTO detalle_ventas(venta, producto, cantidad, precio) SELECT (venta) as noventa, producto, cantidad, precio FROM carrito_ventas WHERE token = token_user;
        UPDATE ventas SET total = totalVenta WHERE id_venta = venta;
        DELETE FROM carrito_ventas WHERE token = token_user;
        SELECT * FROM ventas WHERE id_venta = venta;
    ELSE
    	SELECT 0;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_ventas`
--

DROP TABLE IF EXISTS `carrito_ventas`;
CREATE TABLE IF NOT EXISTS `carrito_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(50) COLLATE utf8mb3_esperanto_ci NOT NULL,
  `producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto` (`producto`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_esperanto_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `usuario` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `usuario`, `status`) VALUES
(1, 'Productos', 1, 1),
(2, 'Refrescos', 1, 1),
(3, 'Extra', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `ci` varchar(255) DEFAULT NULL,
  `usuario` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `ci`, `usuario`, `status`) VALUES
(1, 'Laura', 'Garcia', '12345678', 1, 1),
(2, 'Carlos', 'Torres', '98765432', 1, 1),
(3, 'Sofia', 'Lopez', '45678912', 1, 1),
(4, 'Alejandro', 'Martinez', '74125896', 1, 1),
(5, 'Paula', 'Ramirez', '36987451', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `venta` int NOT NULL,
  `producto` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producto` (`producto`),
  KEY `venta` (`venta`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_esperanto_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta`, `producto`, `cantidad`, `precio`) VALUES
(1, 1, 13, 3, '23.00'),
(2, 1, 4, 3, '49.99'),
(4, 2, 2, 1, '29.99'),
(5, 2, 3, 1, '9.99'),
(7, 3, 3, 1, '9.99'),
(8, 3, 4, 1, '49.99'),
(9, 3, 5, 1, '4.99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `lote` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `unidades` int DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `nombre`, `lote`, `descripcion`, `precio`, `unidades`, `fecha_registro`, `usuario`, `status`) VALUES
(1, 'Camiseddddd', 'LT-001', 'Camiseta blancassss', '15.99', 50, '2023-06-01 08:00:00', 1, 0),
(2, 'Pantalón', 'LT-002', 'Pantalón azul', '29.99', 30, '2023-06-02 08:00:00', 1, 1),
(3, 'Gorra', 'LT-003', 'Gorra negra', '9.99', 20, '2023-06-03 08:00:00', 1, 1),
(4, 'Zapatillas', 'LT-004', 'Zapatillas deportivas', '49.99', 10, '2023-06-04 08:00:00', 1, 1),
(5, 'Calcetines', 'LT-005', 'Calcetines blancos', '4.99', 100, '2023-06-05 08:00:00', 1, 1),
(7, 'guantes', '13as', 'asd', '21.00', 23, '2023-07-04 12:25:47', 1, 1),
(8, 'guantesqw', '14', 'asdqw', '12.00', 14, '2023-07-04 19:35:21', 1, 0),
(9, 'sssss', '1', 'sss', '112.00', 21, '2023-07-05 23:11:01', 1, 0),
(10, 'dddd', '1', 'ddd', '11.00', 123, '2023-07-05 23:15:05', 1, 0),
(11, 'ddd', '1', 'sdasd', '123.00', 1, '2023-07-05 23:21:45', 1, 0),
(12, 'dsdsda', '1', 'asdas', '312.00', 1, '2023-07-05 23:22:09', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `categoria_id` int DEFAULT NULL,
  `usuario` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria_id`, `usuario`, `status`) VALUES
(1, 'Camiseta', 'Camiseta blancadtghdfghgj', '15.99', 1, 1, 0),
(2, 'Pantalón', 'Pantalón azul', '29.99', 3, 1, 1),
(3, 'Gorra', 'Gorra negra', '9.99', 2, 1, 1),
(4, 'Zapatillas', 'Zapatillas deportivas', '49.99', 1, 1, 1),
(5, 'Calcetines', 'Camiseta blancadtghddddd', '4.99', 1, 1, 1),
(7, 'asd', 'qwsdas', '12.00', 1, 1, 0),
(8, 'dsadas', 'asdas', '354.00', 1, 1, 0),
(9, 'dsdas', 'aaa', '23.00', 1, 1, 0),
(10, 'dsadas', 'dsadas', '2123.00', 1, 1, 0),
(11, 'dasdas', 'dsada', '3.00', 1, 1, 0),
(12, 'ddddd', 'dddd', '23.00', 1, 1, 0),
(13, 'fsdfs', 'fsf', '23.00', 2, 1, 1),
(14, 'rrrr', 'rrrr', '23.00', 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `status`) VALUES
(1, 'Administrador', 1),
(2, 'Vendedor', 1),
(3, 'Cliente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol_id` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `correo`, `contraseña`, `rol_id`, `status`) VALUES
(1, 'John', 'Doe', 'johndoe@example.com', '123456', 1, 1),
(2, 'Jane', 'Smith', 'janesmith@example.com', 'abcdef', 2, 1),
(3, 'Michael', 'Johnson', 'michaeljohnson@example.com', 'qwerty', 2, 1),
(4, 'Sarah', 'Williams', 'sarahwilliams@example.com', 'password', 2, 1),
(5, 'David', 'Brown', 'davidbrown@example.com', '987654', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `usuario` int NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_venta`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `usuario`, `total`, `fecha`, `status`) VALUES
(1, 1, '13.00', '2023-07-09 21:48:14', 1),
(2, 1, '96.00', '2023-07-09 21:49:03', 1),
(3, 1, '64.97', '2023-07-09 22:03:03', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_ventas`
--
ALTER TABLE `carrito_ventas`
  ADD CONSTRAINT `carrito_ventas_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`venta`) REFERENCES `ventas` (`id_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
