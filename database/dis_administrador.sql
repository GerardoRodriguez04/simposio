-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-09-2023 a las 17:05:50
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dis_administrador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `articulo_id` int(11) NOT NULL,
  `descripcion` int(11) NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `imagen` varchar(550) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `contacto_id` int(11) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `correo_electronico` varchar(500) NOT NULL,
  `telefono` varchar(550) NOT NULL,
  `mapa` text NOT NULL,
  `facebook` text NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `departamento_id` int(11) NOT NULL,
  `departamento` varchar(350) NOT NULL,
  `descripcion` text NOT NULL,
  `creado_por` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`departamento_id`, `departamento`, `descripcion`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`, `activo`, `visible`) VALUES
(1, 'TICS', 'Tecnologías de la información.', 1, '2023-08-06 14:30:05', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `empresa_id` int(11) NOT NULL,
  `razon_social` varchar(250) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 1,
  `creado_por` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`empresa_id`, `razon_social`, `direccion`, `telefono`, `activo`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(1, 'Dqmedica integral', 'Plaza La Fayette, Prol. Paseo Montejo, C. 39 esquina, Campestre, 97120 Mérida, Yuc.', '9993666382', 1, 1, '2023-08-01 17:58:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_tiempo`
--

CREATE TABLE `linea_tiempo` (
  `acontecimiento_id` int(11) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `año` varchar(450) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `mantenimiento_id` int(11) NOT NULL,
  `principal_id` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `creado_por` varchar(500) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `principal_id` int(11) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `perfil_id` int(11) NOT NULL,
  `perfil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`perfil_id`, `perfil`) VALUES
(1, 'Administrador'),
(2, 'Gerentes'),
(3, 'Coordinadores'),
(4, 'Colaborador'),
(5, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `permiso_id` int(11) NOT NULL,
  `modulo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `perfil_1` tinyint(4) NOT NULL DEFAULT 1,
  `perfil_2` tinyint(4) NOT NULL DEFAULT 1,
  `perfil_3` tinyint(4) NOT NULL DEFAULT 0,
  `perfil_4` tinyint(4) NOT NULL DEFAULT 0,
  `perfil_5` tinyint(4) NOT NULL DEFAULT 0,
  `perfil_6` int(11) NOT NULL,
  `perfil_7` int(11) NOT NULL,
  `grupo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`permiso_id`, `modulo`, `nombre`, `perfil_1`, `perfil_2`, `perfil_3`, `perfil_4`, `perfil_5`, `perfil_6`, `perfil_7`, `grupo`) VALUES
(1, 'Permisos-List', 'Listar Permisos', 1, 0, 0, 0, 0, 0, 0, 1),
(2, 'Permisos-Add', 'Agregar Permisos', 1, 0, 0, 0, 0, 0, 0, 0),
(3, 'Permisos-Edit', 'Actualizar Permisos', 1, 0, 0, 0, 0, 0, 0, 0),
(4, 'Permisos-Delete', 'Eliminar Permisos', 1, 0, 0, 0, 0, 0, 0, 0),
(5, 'Usuarios-List', 'Listar Usuarios', 1, 0, 0, 0, 0, 0, 0, 1),
(6, 'Usuarios-Add', 'Agregar Usuarios', 1, 0, 0, 0, 0, 0, 0, 0),
(7, 'Usuarios-Edit', 'Actualizar Usuarios', 1, 0, 0, 0, 0, 0, 0, 0),
(8, 'Usuarios-Delete', 'Eliminar Usuarios', 1, 0, 0, 0, 0, 0, 0, 0),
(9, 'Departamentos-List', 'Listar Departamentos', 1, 0, 0, 0, 0, 0, 0, 1),
(10, 'Departamentos-Add', 'Agregar Departamentos', 1, 0, 0, 0, 0, 0, 0, 0),
(11, 'Departamentos-Edit', 'Actualizar Departamentos', 1, 0, 0, 0, 0, 0, 0, 0),
(12, 'Departamentos-Delete', 'Eliminar Departamentos', 1, 0, 0, 0, 0, 0, 0, 0),
(37, 'Configuraciones-List', 'Listar Configuraciones', 1, 0, 0, 0, 0, 0, 0, 1),
(38, 'Configuraciones-Add', 'Agregar Configuraciones', 1, 0, 0, 0, 0, 0, 0, 0),
(39, 'Configuraciones-Edit', 'Actualizar Configuraciones', 1, 0, 0, 0, 0, 0, 0, 0),
(40, 'Configuraciones-Delete', 'Eliminar Configuraciones', 1, 0, 0, 0, 0, 0, 0, 0),
(66, 'Dashboard-List', 'Listar Dashboard', 1, 0, 0, 0, 0, 0, 0, 1),
(67, 'Dashboard-Add', 'Agregar Dashboard', 1, 0, 0, 0, 0, 0, 0, 0),
(68, 'Dashboard-Edit', 'Actualizar Dashboard', 1, 0, 0, 0, 0, 0, 0, 0),
(69, 'Dashboard-Delete', 'Eliminar Dashboard', 1, 0, 0, 0, 0, 0, 0, 0),
(74, 'Empresas-List', 'Listar Empresas', 1, 0, 0, 0, 0, 0, 0, 1),
(75, 'Empresas-Add', 'Agregar Empresas', 1, 0, 0, 0, 0, 0, 0, 0),
(76, 'Empresas-Edit', 'Actualizar Empresas', 1, 0, 0, 0, 0, 0, 0, 0),
(77, 'Empresas-Delete', 'Eliminar Empresas', 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `principales`
--

CREATE TABLE `principales` (
  `principal_id` int(11) NOT NULL,
  `correo_principal` varchar(450) DEFAULT NULL,
  `telefono_1` varchar(450) DEFAULT NULL,
  `telefono_2` varchar(450) DEFAULT NULL,
  `logo_inicio` varchar(500) DEFAULT NULL,
  `mensaje_inicio_1` varchar(450) DEFAULT NULL,
  `mensaje_inicio_2` varchar(450) DEFAULT NULL,
  `mision_inicio` varchar(750) DEFAULT NULL,
  `vision_inicio` varchar(750) DEFAULT NULL,
  `giro_inicio` varchar(750) DEFAULT NULL,
  `subtitulo_nosotros` varchar(350) DEFAULT NULL,
  `descripcion_nosotros` varchar(500) DEFAULT NULL,
  `imagen_nosotros_1` varchar(550) DEFAULT NULL,
  `imagen_nosotros_2` varchar(550) DEFAULT NULL,
  `subtitulo_linea` varchar(500) DEFAULT NULL,
  `titulo_mantenimientos` varchar(500) DEFAULT NULL,
  `subtitulo_mantenimientos` varchar(500) DEFAULT NULL,
  `subtitulo_clientes` varchar(500) DEFAULT NULL,
  `subtitulo_marcas` varchar(500) DEFAULT NULL,
  `titulo_articulos` varchar(500) DEFAULT NULL,
  `titulo_contactos` varchar(500) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `principales`
--

INSERT INTO `principales` (`principal_id`, `correo_principal`, `telefono_1`, `telefono_2`, `logo_inicio`, `mensaje_inicio_1`, `mensaje_inicio_2`, `mision_inicio`, `vision_inicio`, `giro_inicio`, `subtitulo_nosotros`, `descripcion_nosotros`, `imagen_nosotros_1`, `imagen_nosotros_2`, `subtitulo_linea`, `titulo_mantenimientos`, `subtitulo_mantenimientos`, `subtitulo_clientes`, `subtitulo_marcas`, `titulo_articulos`, `titulo_contactos`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(1, 'ventasprivadasyucatan01@disintegral.com.mx', '+52 9999-26-30-04 ', '+52 9996-88-63-13', NULL, 'Bienvenidos a DISTRIBUCIÓN INTEGRAL SURESTE', 'Más que un proveedor, es parte de tu equipo.', 'Es ser la mejor comercializadora en productos y servicios de laboratorio a nivel sureste, ofreciendo seguridad, el mejor servicio y confianza a nuestros clientes. Solucionando cualquier tipo de necesidad en el área de la salud.', 'Ser una empresa con una amplia experiencia en el área de los servicios de salud, ofreciendo insumos, reactivos, material quirúrgico y servicios integrales a laboratorios, clínicas, hospitales privados o gubernamentales con calidad y prestigio en todo el sureste del país.', 'Comercio al por mayor de mobiliario, equipo e instrumental médico y de laboratorio Laboratorios médicos y de diagnóstico pertenecientes al sector privado.', 'Descubre más sobre Nosotros', 'Distribución Integral Sureste, S.A de C.V, es una empresa orgullosamente mexicana con una amplia experiencia en el área de los servicios de salud, ofreciendo SERVICIOS INTEGRALES a laboratorios, clínicas y hospitales, a demás de la gran gama de reactivos, equipos y material de marcas de calidad.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-05 18:20:12', 1, '2023-09-05 20:19:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `categoria_modulo_id` int(1) NOT NULL DEFAULT 0,
  `nombre` varchar(255) DEFAULT '',
  `apellido` varchar(255) DEFAULT '',
  `telefono` varchar(20) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `creado_por` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `perfil_id`, `empresa_id`, `categoria_modulo_id`, `nombre`, `apellido`, `telefono`, `email`, `password`, `activo`, `creado_por`, `fecha_creacion`, `modificado_por`, `fecha_modificacion`) VALUES
(1, 1, 1, 0, 'Super', 'Administrador', '123456789', 'administrador@hotmail.com', 'f3c3bd6b1922093e85eda96b12711f65', 1, 0, '2023-06-07 22:21:15', 1, '2023-07-21 18:52:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_departamentos`
--

CREATE TABLE `usuario_departamentos` (
  `usuario_departamento_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_departamentos`
--

INSERT INTO `usuario_departamentos` (`usuario_departamento_id`, `usuario_id`, `departamento_id`, `creado_por`, `fecha_creacion`) VALUES
(1, 3, 1, 1, '2023-08-06 14:30:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`articulo_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`contacto_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`departamento_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `linea_tiempo`
--
ALTER TABLE `linea_tiempo`
  ADD PRIMARY KEY (`acontecimiento_id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`mantenimiento_id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`perfil_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`permiso_id`);

--
-- Indices de la tabla `principales`
--
ALTER TABLE `principales`
  ADD PRIMARY KEY (`principal_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `usuario_departamentos`
--
ALTER TABLE `usuario_departamentos`
  ADD PRIMARY KEY (`usuario_departamento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `articulo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `contacto_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `departamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `linea_tiempo`
--
ALTER TABLE `linea_tiempo`
  MODIFY `acontecimiento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `mantenimiento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `permiso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `principales`
--
ALTER TABLE `principales`
  MODIFY `principal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_departamentos`
--
ALTER TABLE `usuario_departamentos`
  MODIFY `usuario_departamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
