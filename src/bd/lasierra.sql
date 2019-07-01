-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2019 a las 20:03:37
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lasierra`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `consultaCliente` (`id` INT)  select cliente.Nombre, cliente.APaterno, cliente.AMaterno, cliente.Telefono,
  cliente.Celular, cliente.Sexo, cliente.CasaPropia, cliente.AutoPropio, cliente.LugarTrabajo,
  cliente.TelTrabajo, cliente.Antiguedad, cat_estado.NomEstado, cat_municipio.NomMunicipio, 
  cat_colonia.NomColonia, cat_colonia.CP, cat_calle.NomCalle, cat_calle.Tipo, direccion.NumExterior, 
  direccion.NumInterior, cliente.Estatus
from cliente
inner join direccion on cliente.FkDireccion = direccion.IdDireccion
inner join cat_estado on direccion.FkEstado = cat_estado.IdEstado
inner join cat_municipio on direccion.FkMunicipio = cat_municipio.IdMunicipio
inner join cat_colonia on direccion.FkColonia = cat_colonia.IdColonia
inner join cat_calle on direccion.FkCalle = cat_calle.IdCalle
where IdCliente = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consultaUsuarioXNombre` (IN `nombre` VARCHAR(50))  select usuario.Nombre, usuario.Contrasena, cat_tipousuario.TipoUsuario
from usuario
INNER JOIN cat_tipousuario on usuario.FkCat_TipoUsuario = cat_tipousuario.IdTipoUsuario
WHERE Nombre like nombre$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `IdArticulo` int(11) NOT NULL,
  `Codigo` varchar(255) NOT NULL,
  `NombreArticulo` varchar(255) NOT NULL,
  `Costo` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayoreo` double DEFAULT NULL,
  `FkCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`IdArticulo`, `Codigo`, `NombreArticulo`, `Costo`, `PrecioVenta`, `PrecioMayoreo`, `FkCategoria`) VALUES
(1, 'PRUEBA123', 'Prueba', 11, 11, 11, 1),
(2, 'a', 'a', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_calle`
--

CREATE TABLE `cat_calle` (
  `IdCalle` int(11) NOT NULL,
  `NomCalle` varchar(255) NOT NULL,
  `Tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_categoriaarticulos`
--

CREATE TABLE `cat_categoriaarticulos` (
  `IdCategoria` int(11) NOT NULL,
  `NombreCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_categoriaarticulos`
--

INSERT INTO `cat_categoriaarticulos` (`IdCategoria`, `NombreCategoria`) VALUES
(1, 'Prueba'),
(2, 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_colonia`
--

CREATE TABLE `cat_colonia` (
  `IdColonia` int(11) NOT NULL,
  `NomColonia` varchar(255) NOT NULL,
  `CP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estado`
--

CREATE TABLE `cat_estado` (
  `IdEstado` int(11) NOT NULL,
  `NomEstado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_lio`
--

CREATE TABLE `cat_lio` (
  `IdLio` int(11) NOT NULL,
  `TipoLio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_motivo`
--

CREATE TABLE `cat_motivo` (
  `IdMotivo` int(11) NOT NULL,
  `TipoMotivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_municipio`
--

CREATE TABLE `cat_municipio` (
  `IdMunicipio` int(11) NOT NULL,
  `NomMunicipio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipousuario`
--

CREATE TABLE `cat_tipousuario` (
  `IdTipoUsuario` int(11) NOT NULL,
  `TipoUsuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_tipousuario`
--

INSERT INTO `cat_tipousuario` (`IdTipoUsuario`, `TipoUsuario`) VALUES
(1, 'Administrador'),
(2, 'Cobrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IdCliente` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `Sexo` char(255) DEFAULT NULL,
  `CasaPropia` bit(1) NOT NULL,
  `AutoPropio` bit(1) NOT NULL,
  `LugarTrabajo` varchar(255) DEFAULT NULL,
  `TelTrabajo` int(11) DEFAULT NULL,
  `Antiguedad` int(11) DEFAULT NULL,
  `FkDireccion` int(11) NOT NULL,
  `FkDireccionCobro` int(11) NOT NULL,
  `Estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobrador`
--

CREATE TABLE `cobrador` (
  `IdCobrador` int(11) NOT NULL,
  `NombreCobrador` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Estatus` int(11) DEFAULT NULL,
  `FkRuta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobranza`
--

CREATE TABLE `cobranza` (
  `IdCobranza` int(11) NOT NULL,
  `FkCobrador` int(11) NOT NULL,
  `FkVenta` int(11) NOT NULL,
  `FechaCobro` date NOT NULL,
  `Abono` double NOT NULL,
  `MontoVencido` double DEFAULT NULL,
  `AbonoVencido` int(11) DEFAULT NULL,
  `AbonoAtrasado` int(11) DEFAULT NULL,
  `PrimerCobro` tinyint(4) DEFAULT NULL,
  `FkLio` int(11) DEFAULT NULL,
  `Comentario` text,
  `GpsLat` double DEFAULT NULL,
  `GpsLon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `IdCuenta` int(11) NOT NULL,
  `NumeroCuenta` int(11) NOT NULL,
  `FkCliente` int(11) NOT NULL,
  `SaldoTotal` double DEFAULT NULL,
  `EstatusPagador` varchar(255) DEFAULT NULL,
  `ContadorVencidos` int(11) DEFAULT NULL,
  `ContadorAtrasados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `IdDevolucion` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `FkVenta` int(11) NOT NULL,
  `Comentario` varchar(255) DEFAULT NULL,
  `EstadoArticulo` varchar(255) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `IdDireccion` int(11) NOT NULL,
  `FkEstado` int(11) NOT NULL,
  `FkMunicipio` int(11) NOT NULL,
  `FkColonia` int(11) NOT NULL,
  `FkCalle` int(11) NOT NULL,
  `NumExterior` int(11) DEFAULT NULL,
  `NumInterior` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventariodevolucion`
--

CREATE TABLE `inventariodevolucion` (
  `IdInventarioD` int(11) NOT NULL,
  `FkDevolucion` int(11) NOT NULL,
  `CantidadDevolucion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarioprincipal`
--

CREATE TABLE `inventarioprincipal` (
  `IdInventarioP` int(11) NOT NULL,
  `FkArticulo` int(11) NOT NULL,
  `CantidadPrincipal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `inventarioprincipal`
--

INSERT INTO `inventarioprincipal` (`IdInventarioP`, `FkArticulo`, `CantidadPrincipal`) VALUES
(100, 2, 24),
(108, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventariosecundario`
--

CREATE TABLE `inventariosecundario` (
  `IdInventarioS` int(11) NOT NULL,
  `FkInventarioP` int(11) NOT NULL,
  `CantidadSecundario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventariosecundario`
--

INSERT INTO `inventariosecundario` (`IdInventarioS`, `FkInventarioP`, `CantidadSecundario`) VALUES
(2, 100, 24),
(8, 108, 1111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listanegra`
--

CREATE TABLE `listanegra` (
  `IdLIstaNegra` int(11) NOT NULL,
  `FkCliente` int(11) NOT NULL,
  `FkCat_Motivo` int(11) NOT NULL,
  `Comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoinventario`
--

CREATE TABLE `movimientoinventario` (
  `IdMovimientoInventario` int(11) NOT NULL,
  `FkInventarioP` int(11) DEFAULT NULL,
  `FkInventarioS` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `FkUsuario` int(11) NOT NULL,
  `FkTipoMovimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimientoinventario`
--

INSERT INTO `movimientoinventario` (`IdMovimientoInventario`, `FkInventarioP`, `FkInventarioS`, `Cantidad`, `Fecha`, `FkUsuario`, `FkTipoMovimiento`) VALUES
(16, 108, NULL, 1, '2019-06-24', 2, 1),
(19, NULL, 2, 1111, '2019-06-26', 2, 1),
(20, 100, NULL, 24, '2019-06-27', 2, 1),
(26, NULL, 2, 24, '2019-06-27', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL,
  `FkCliente` int(11) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `FkArticulo` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencia`
--

CREATE TABLE `referencia` (
  `IdReferencia` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `FkDireccion` int(11) DEFAULT NULL,
  `FkCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `IdRuta` int(11) NOT NULL,
  `NumeroRuta` int(11) NOT NULL,
  `FkColonia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subventa`
--

CREATE TABLE `subventa` (
  `IdSubVenta` int(11) NOT NULL,
  `FkVenta` int(11) NOT NULL,
  `FkArticulo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `SubTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomovimiento`
--

CREATE TABLE `tipomovimiento` (
  `IdTipoMovimiento` int(11) NOT NULL,
  `TipoMovimiento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipomovimiento`
--

INSERT INTO `tipomovimiento` (`IdTipoMovimiento`, `TipoMovimiento`) VALUES
(1, 'EntradaProducto'),
(2, 'SalidaProducto'),
(3, 'EntradaPrincipalASecundario'),
(4, 'EliminaciónProducto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `FkCat_TipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nombre`, `Contrasena`, `FkCat_TipoUsuario`) VALUES
(2, 'Andrik Miranda', '1104', 1),
(3, 'Arturo Herrera', 'puto', 1),
(4, 'Sergio', 'asdasdasd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `IdVendedor` int(11) NOT NULL,
  `NombreVendedor` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Estatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL,
  `FkCuenta` int(11) NOT NULL,
  `FkSubVenta` int(11) NOT NULL,
  `TotalVenta` double NOT NULL,
  `Enganche` double NOT NULL,
  `Fecha` date NOT NULL,
  `FkVendedor` int(11) NOT NULL,
  `PeriodoPago` varchar(255) NOT NULL,
  `CantidadAbono` double DEFAULT NULL,
  `SaldoPendiente` double DEFAULT NULL,
  `HorarioCobro` int(11) NOT NULL,
  `TipoVenta` tinyint(4) NOT NULL,
  `GpsLat` double DEFAULT NULL,
  `GpsLon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`IdArticulo`),
  ADD KEY `FkCategoria` (`FkCategoria`);

--
-- Indices de la tabla `cat_calle`
--
ALTER TABLE `cat_calle`
  ADD PRIMARY KEY (`IdCalle`);

--
-- Indices de la tabla `cat_categoriaarticulos`
--
ALTER TABLE `cat_categoriaarticulos`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `cat_colonia`
--
ALTER TABLE `cat_colonia`
  ADD PRIMARY KEY (`IdColonia`);

--
-- Indices de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
  ADD PRIMARY KEY (`IdEstado`);

--
-- Indices de la tabla `cat_lio`
--
ALTER TABLE `cat_lio`
  ADD PRIMARY KEY (`IdLio`);

--
-- Indices de la tabla `cat_motivo`
--
ALTER TABLE `cat_motivo`
  ADD PRIMARY KEY (`IdMotivo`);

--
-- Indices de la tabla `cat_municipio`
--
ALTER TABLE `cat_municipio`
  ADD PRIMARY KEY (`IdMunicipio`);

--
-- Indices de la tabla `cat_tipousuario`
--
ALTER TABLE `cat_tipousuario`
  ADD PRIMARY KEY (`IdTipoUsuario`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IdCliente`),
  ADD KEY `FkDireccion` (`FkDireccion`),
  ADD KEY `FkDireccionCobro` (`FkDireccionCobro`);

--
-- Indices de la tabla `cobrador`
--
ALTER TABLE `cobrador`
  ADD PRIMARY KEY (`IdCobrador`),
  ADD KEY `FkRuta` (`FkRuta`);

--
-- Indices de la tabla `cobranza`
--
ALTER TABLE `cobranza`
  ADD PRIMARY KEY (`IdCobranza`),
  ADD KEY `FkCobrador` (`FkCobrador`),
  ADD KEY `FkVenta` (`FkVenta`),
  ADD KEY `FkLio` (`FkLio`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`IdCuenta`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`IdDevolucion`),
  ADD KEY `FkVenta` (`FkVenta`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`IdDireccion`),
  ADD KEY `FkEstado` (`FkEstado`),
  ADD KEY `FkMunicipio` (`FkMunicipio`),
  ADD KEY `FkColonia` (`FkColonia`),
  ADD KEY `FkCalle` (`FkCalle`);

--
-- Indices de la tabla `inventariodevolucion`
--
ALTER TABLE `inventariodevolucion`
  ADD PRIMARY KEY (`IdInventarioD`),
  ADD KEY `FkDevolucion` (`FkDevolucion`);

--
-- Indices de la tabla `inventarioprincipal`
--
ALTER TABLE `inventarioprincipal`
  ADD PRIMARY KEY (`IdInventarioP`),
  ADD KEY `FkArticulo` (`FkArticulo`);

--
-- Indices de la tabla `inventariosecundario`
--
ALTER TABLE `inventariosecundario`
  ADD PRIMARY KEY (`IdInventarioS`),
  ADD KEY `FkInventarioP` (`FkInventarioP`);

--
-- Indices de la tabla `listanegra`
--
ALTER TABLE `listanegra`
  ADD PRIMARY KEY (`IdLIstaNegra`),
  ADD KEY `FkCliente` (`FkCliente`),
  ADD KEY `FkCat_Motivo` (`FkCat_Motivo`);

--
-- Indices de la tabla `movimientoinventario`
--
ALTER TABLE `movimientoinventario`
  ADD PRIMARY KEY (`IdMovimientoInventario`),
  ADD KEY `FkInventarioP` (`FkInventarioP`),
  ADD KEY `FkUsuario` (`FkUsuario`),
  ADD KEY `FkTipoMovimiento` (`FkTipoMovimiento`),
  ADD KEY `FkInventarioS` (`FkInventarioS`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `FkCliente` (`FkCliente`),
  ADD KEY `FkArticulo` (`FkArticulo`);

--
-- Indices de la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD PRIMARY KEY (`IdReferencia`),
  ADD KEY `FkDireccion` (`FkDireccion`),
  ADD KEY `FkCliente` (`FkCliente`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`IdRuta`),
  ADD KEY `FkColonia` (`FkColonia`);

--
-- Indices de la tabla `subventa`
--
ALTER TABLE `subventa`
  ADD PRIMARY KEY (`IdSubVenta`),
  ADD KEY `FkVenta` (`FkVenta`),
  ADD KEY `FkArticulo` (`FkArticulo`);

--
-- Indices de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  ADD PRIMARY KEY (`IdTipoMovimiento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `FkCat_TipoUsuario` (`FkCat_TipoUsuario`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`IdVendedor`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `FkCuenta` (`FkCuenta`),
  ADD KEY `FkVendedor` (`FkVendedor`),
  ADD KEY `FkSubVenta` (`FkSubVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `IdArticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_calle`
--
ALTER TABLE `cat_calle`
  MODIFY `IdCalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_categoriaarticulos`
--
ALTER TABLE `cat_categoriaarticulos`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_colonia`
--
ALTER TABLE `cat_colonia`
  MODIFY `IdColonia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
  MODIFY `IdEstado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_lio`
--
ALTER TABLE `cat_lio`
  MODIFY `IdLio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_motivo`
--
ALTER TABLE `cat_motivo`
  MODIFY `IdMotivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_municipio`
--
ALTER TABLE `cat_municipio`
  MODIFY `IdMunicipio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_tipousuario`
--
ALTER TABLE `cat_tipousuario`
  MODIFY `IdTipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cobrador`
--
ALTER TABLE `cobrador`
  MODIFY `IdCobrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cobranza`
--
ALTER TABLE `cobranza`
  MODIFY `IdCobranza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `IdCuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `IdDevolucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `IdDireccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventariodevolucion`
--
ALTER TABLE `inventariodevolucion`
  MODIFY `IdInventarioD` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarioprincipal`
--
ALTER TABLE `inventarioprincipal`
  MODIFY `IdInventarioP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `inventariosecundario`
--
ALTER TABLE `inventariosecundario`
  MODIFY `IdInventarioS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `listanegra`
--
ALTER TABLE `listanegra`
  MODIFY `IdLIstaNegra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientoinventario`
--
ALTER TABLE `movimientoinventario`
  MODIFY `IdMovimientoInventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `referencia`
--
ALTER TABLE `referencia`
  MODIFY `IdReferencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `IdRuta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subventa`
--
ALTER TABLE `subventa`
  MODIFY `IdSubVenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipomovimiento`
--
ALTER TABLE `tipomovimiento`
  MODIFY `IdTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `IdVendedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`FkCategoria`) REFERENCES `cat_categoriaarticulos` (`IdCategoria`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`FkDireccion`) REFERENCES `direccion` (`IdDireccion`),
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`FkDireccionCobro`) REFERENCES `direccion` (`IdDireccion`);

--
-- Filtros para la tabla `cobrador`
--
ALTER TABLE `cobrador`
  ADD CONSTRAINT `cobrador_ibfk_1` FOREIGN KEY (`FkRuta`) REFERENCES `ruta` (`IdRuta`);

--
-- Filtros para la tabla `cobranza`
--
ALTER TABLE `cobranza`
  ADD CONSTRAINT `cobranza_ibfk_1` FOREIGN KEY (`FkCobrador`) REFERENCES `cobrador` (`IdCobrador`),
  ADD CONSTRAINT `cobranza_ibfk_2` FOREIGN KEY (`FkVenta`) REFERENCES `venta` (`IdVenta`),
  ADD CONSTRAINT `cobranza_ibfk_3` FOREIGN KEY (`FkLio`) REFERENCES `cat_lio` (`IdLio`);

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`FkVenta`) REFERENCES `venta` (`IdVenta`);

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`FkEstado`) REFERENCES `cat_estado` (`IdEstado`),
  ADD CONSTRAINT `direccion_ibfk_2` FOREIGN KEY (`FkMunicipio`) REFERENCES `cat_municipio` (`IdMunicipio`),
  ADD CONSTRAINT `direccion_ibfk_3` FOREIGN KEY (`FkColonia`) REFERENCES `cat_colonia` (`IdColonia`),
  ADD CONSTRAINT `direccion_ibfk_4` FOREIGN KEY (`FkCalle`) REFERENCES `cat_calle` (`IdCalle`);

--
-- Filtros para la tabla `inventariodevolucion`
--
ALTER TABLE `inventariodevolucion`
  ADD CONSTRAINT `inventariodevolucion_ibfk_1` FOREIGN KEY (`FkDevolucion`) REFERENCES `devolucion` (`FkVenta`);

--
-- Filtros para la tabla `inventarioprincipal`
--
ALTER TABLE `inventarioprincipal`
  ADD CONSTRAINT `inventarioprincipal_ibfk_1` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`);

--
-- Filtros para la tabla `inventariosecundario`
--
ALTER TABLE `inventariosecundario`
  ADD CONSTRAINT `inventariosecundario_ibfk_1` FOREIGN KEY (`FkInventarioP`) REFERENCES `inventarioprincipal` (`IdInventarioP`);

--
-- Filtros para la tabla `listanegra`
--
ALTER TABLE `listanegra`
  ADD CONSTRAINT `listanegra_ibfk_1` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `listanegra_ibfk_2` FOREIGN KEY (`FkCat_Motivo`) REFERENCES `cat_motivo` (`IdMotivo`);

--
-- Filtros para la tabla `movimientoinventario`
--
ALTER TABLE `movimientoinventario`
  ADD CONSTRAINT `movimientoinventario_ibfk_1` FOREIGN KEY (`FkInventarioP`) REFERENCES `inventarioprincipal` (`IdInventarioP`),
  ADD CONSTRAINT `movimientoinventario_ibfk_2` FOREIGN KEY (`FkUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `movimientoinventario_ibfk_3` FOREIGN KEY (`FkTipoMovimiento`) REFERENCES `tipomovimiento` (`IdTipoMovimiento`),
  ADD CONSTRAINT `movimientoinventario_ibfk_4` FOREIGN KEY (`FkInventarioS`) REFERENCES `inventariosecundario` (`IdInventarioS`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`);

--
-- Filtros para la tabla `referencia`
--
ALTER TABLE `referencia`
  ADD CONSTRAINT `referencia_ibfk_1` FOREIGN KEY (`FkDireccion`) REFERENCES `direccion` (`IdDireccion`),
  ADD CONSTRAINT `referencia_ibfk_2` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`);

--
-- Filtros para la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `ruta_ibfk_1` FOREIGN KEY (`FkColonia`) REFERENCES `cat_colonia` (`IdColonia`);

--
-- Filtros para la tabla `subventa`
--
ALTER TABLE `subventa`
  ADD CONSTRAINT `subventa_ibfk_1` FOREIGN KEY (`FkVenta`) REFERENCES `venta` (`IdVenta`),
  ADD CONSTRAINT `subventa_ibfk_2` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`FkCat_TipoUsuario`) REFERENCES `cat_tipousuario` (`IdTipoUsuario`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`FkCuenta`) REFERENCES `cuenta` (`IdCuenta`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`FkVendedor`) REFERENCES `vendedor` (`IdVendedor`),
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`FkSubVenta`) REFERENCES `subventa` (`IdSubVenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
