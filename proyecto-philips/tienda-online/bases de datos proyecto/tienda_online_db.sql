-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2024 a las 04:55:53
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
-- Base de datos: `tienda_online_db`
--
CREATE DATABASE IF NOT EXISTS `tienda_online_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tienda_online_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--
-- Creación: 27-11-2024 a las 20:51:58
-- Última actualización: 28-11-2024 a las 03:54:50
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--
-- Creación: 27-11-2024 a las 21:10:08
-- Última actualización: 28-11-2024 a las 03:54:50
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` int(10) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 24-11-2024 a las 23:37:06
-- Última actualización: 28-11-2024 a las 03:44:06
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `id_categoria`, `activo`) VALUES
(1, 'Nevera Mabe 421 Lt Brutos No Frost', '<p>¡Mantén tus alimentos frescos por más tiempo con la nevera Philips FreshCool! Con tecnología de refrigeración avanzada y un diseño espacioso, esta nevera de 350L ofrece un rendimiento superior para almacenar tus productos de manera eficiente. Su sistema de distribución de aire de múltiples direcciones asegura una temperatura constante en cada compartimiento, mientras que su sistema de control de humedad mantiene las frutas y verduras frescas por más tiempo. Con un diseño moderno y elegante, la FreshCool es perfecta para hogares que buscan calidad, eficiencia energética y un estilo único.</p> <br> <b>Características:</b><br> <ul> <li>Capacidad total de 350L, ideal para familias medianas y grandes.</li> <li>Sistema de refrigeración de múltiples direcciones para temperatura uniforme.</li> <li>Control de humedad para mantener la frescura de frutas y verduras.</li> <li>Clasificación energética A+ para ahorro de energía.</li> <li>Diseño moderno con puertas reversibles para mayor comodidad.</li> </ul>', 100, 10, 1, 1),
(2, 'Licuadora Oster 6 Velocidades Vaso de Vidrio', '<p>¡Lleva la preparación de tus bebidas al siguiente nivel! Esta licuadora de alta potencia es perfecta para mezclar, triturar y licuar con facilidad, obteniendo resultados suaves y cremosos en segundos. Con su motor de 1200W y 5 velocidades ajustables, puedes lograr desde jugos frescos hasta batidos densos. Su jarra de vidrio resistente a altas temperaturas y su diseño ergonómico hacen que sea fácil de usar y limpiar. Ideal para la cocina moderna, esta licuadora ofrece un rendimiento duradero y un excelente control sobre cada mezcla.</p> <br> <b>Características:</b><br> <ul> <li>Motor potente de 1200W para una mezcla rápida y eficiente.</li> <li>5 velocidades ajustables y función de pulsado para un control total.</li> <li>Jarra de vidrio resistente y de gran capacidad (1.5L).</li> <li>Fácil de limpiar con partes aptas para lavavajillas.</li> <li>Base antideslizante para mayor estabilidad durante su uso.</li> </ul>', 50, 0, 1, 1),
(3, 'Estufa Mabe 20 pulgadas Mercury EM5030BAIS1', '<p>¡Disfruta de una cocina más eficiente y elegante con esta estufa a gas de alto rendimiento! Con 4 quemadores de alta potencia, puedes cocinar tus platos favoritos con rapidez y precisión. Su diseño moderno y duradero se adapta a cualquier estilo de cocina, mientras que sus controles ergonómicos te ofrecen un fácil manejo de la temperatura. La estufa también cuenta con una superficie de acero inoxidable fácil de limpiar, asegurando que tu cocina siempre se mantenga impecable. Perfecta para familias y chefs caseros que buscan calidad y rendimiento.</p> <br> <b>Características:</b><br> <ul> <li>4 quemadores de alto rendimiento para cocinar rápidamente.</li> <li>Superficie de acero inoxidable resistente y fácil de limpiar.</li> <li>Controles ergonómicos de fácil acceso para un manejo preciso.</li> <li>Encendido electrónico para mayor seguridad y comodidad.</li> <li>Diseño compacto y elegante que se adapta a cualquier cocina.</li> </ul>', 300, 0, 1, 1),
(4, 'Philips 65 Pulgadas 4K UHD LED Smart TV', '<p>¡Vive la experiencia visual más impresionante con el televisor Philips UltraVision! Con una pantalla 4K UHD de 55 pulgadas, disfrutarás de imágenes nítidas, colores vibrantes y detalles precisos que hacen que cada película, serie y partido cobre vida. Su tecnología HDR+ mejora el contraste y los colores para una visualización más realista, mientras que el sonido envolvente Dolby Atmos te sumerge en una experiencia auditiva de alta calidad. Con su sistema operativo Android integrado, podrás acceder a tus aplicaciones favoritas y disfrutar de contenido en streaming de forma rápida y sencilla. El diseño elegante de marco delgado y el sistema de montaje en pared hacen que se adapte perfectamente a cualquier espacio.</p> <br> <b>Características:</b><br> <ul> <li>Pantalla 4K UHD de 55 pulgadas para una calidad de imagen excepcional.</li> <li>Compatible con HDR+ para colores más ricos y mayor contraste.</li> <li>Sistema de sonido Dolby Atmos para una experiencia de audio envolvente.</li> <li>Sistema operativo Android para acceso a aplicaciones y contenido en streaming.</li> <li>Diseño elegante con marco delgado y compatible con montaje en pared.</li> </ul>', 250, 0, 1, 1),
(5, ' Lámpara LED Inteligente Multicolor con Control por Voz', '<p>¡Ilumina tu hogar como nunca antes! Esta lámpara LED inteligente te permite personalizar la luz de cada espacio con más de 16 millones de colores y tonos ajustables. Compatible con Alexa y Google Assistant, controla la intensidad y el color con comandos de voz o desde tu celular. Perfecta para crear ambientes únicos en salas, dormitorios o estudios. Ahorra energía con tecnología LED y disfruta de una vida útil de hasta 50.000 horas.</p>\r\n<br>\r\n<b>Características:</b><br>\r\n<ul>\r\n<li>Conexión WiFi compatible con iOS y Android.</li>\r\n<li>Más de 16 millones de colores personalizables.</li>\r\n<li>Control por aplicación móvil o voz (Alexa/Google Assistant).</li>\r\n<li>Consumo de energía ultra bajo (9W).</li>\r\n<li>Fácil instalación en casquillos estándar E27.</li>\r\n</ul>', 15, 0, 1, 1),
(6, 'Bose SoundLink Flex Bluetooth Speaker (Black)', '<p>¡Lleva la música a otro nivel con el parlante Philips SoundBoost! Con un diseño compacto y potente, este parlante portátil ofrece un sonido claro y envolvente con graves profundos gracias a su tecnología de audio de alta calidad. Equipado con Bluetooth 5.0, podrás conectarlo fácilmente a tus dispositivos y disfrutar de tu música favorita sin cables. Su batería de larga duración te permite hasta 12 horas de reproducción continua, ideal para cualquier ocasión, ya sea en casa, en el parque o de viaje. Además, es resistente al agua con certificación IPX7, lo que lo hace perfecto para usar al aire libre. ¡Disfruta de un sonido increíble dondequiera que vayas!</p> <br> <b>Características:</b><br> <ul> <li>Sonido potente con graves profundos para una experiencia auditiva envolvente.</li> <li>Conexión Bluetooth 5.0 para emparejamiento rápido y estable.</li> <li>Batería de hasta 12 horas de reproducción continua.</li> <li>Resistente al agua con certificación IPX7 para uso al aire libre.</li> <li>Diseño compacto y portátil para fácil transporte.</li> </ul>', 100, 0, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
