/*
Navicat MySQL Data Transfer

Source Server         : AlwaysData
Source Server Version : 50505
Source Host           : mysql-jherrera.alwaysdata.net:3306
Source Database       : jherrera_lasierra

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-08-11 11:15:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for articulo
-- ----------------------------
DROP TABLE IF EXISTS `articulo`;
CREATE TABLE `articulo` (
  `IdArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(255) NOT NULL,
  `NombreArticulo` varchar(255) NOT NULL,
  `Costo` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `PrecioMayoreo` double DEFAULT NULL,
  `FkCategoria` int(11) NOT NULL,
  PRIMARY KEY (`IdArticulo`),
  KEY `FkCategoria` (`FkCategoria`),
  CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`FkCategoria`) REFERENCES `cat_categoriaarticulos` (`IdCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_calle
-- ----------------------------
DROP TABLE IF EXISTS `cat_calle`;
CREATE TABLE `cat_calle` (
  `IdCalle` int(11) NOT NULL AUTO_INCREMENT,
  `NomCalle` varchar(255) NOT NULL,
  `Latitud` double(14,10) DEFAULT NULL,
  `Longitud` double(14,10) DEFAULT NULL,
  PRIMARY KEY (`IdCalle`)
) ENGINE=InnoDB AUTO_INCREMENT=5264 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_categoriaarticulos
-- ----------------------------
DROP TABLE IF EXISTS `cat_categoriaarticulos`;
CREATE TABLE `cat_categoriaarticulos` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCategoria` varchar(255) NOT NULL,
  PRIMARY KEY (`IdCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_colonia
-- ----------------------------
DROP TABLE IF EXISTS `cat_colonia`;
CREATE TABLE `cat_colonia` (
  `IdColonia` int(11) NOT NULL AUTO_INCREMENT,
  `NomColonia` varchar(255) NOT NULL,
  `CP` int(11) NOT NULL,
  PRIMARY KEY (`IdColonia`)
) ENGINE=InnoDB AUTO_INCREMENT=762 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_estado
-- ----------------------------
DROP TABLE IF EXISTS `cat_estado`;
CREATE TABLE `cat_estado` (
  `IdEstado` int(11) NOT NULL AUTO_INCREMENT,
  `NomEstado` varchar(255) NOT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_lio
-- ----------------------------
DROP TABLE IF EXISTS `cat_lio`;
CREATE TABLE `cat_lio` (
  `IdLio` int(11) NOT NULL AUTO_INCREMENT,
  `TipoLio` varchar(255) NOT NULL,
  PRIMARY KEY (`IdLio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_motivo
-- ----------------------------
DROP TABLE IF EXISTS `cat_motivo`;
CREATE TABLE `cat_motivo` (
  `IdMotivo` int(11) NOT NULL AUTO_INCREMENT,
  `TipoMotivo` varchar(255) NOT NULL,
  PRIMARY KEY (`IdMotivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_municipio
-- ----------------------------
DROP TABLE IF EXISTS `cat_municipio`;
CREATE TABLE `cat_municipio` (
  `IdMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `NomMunicipio` varchar(255) NOT NULL,
  PRIMARY KEY (`IdMunicipio`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cat_tipousuario
-- ----------------------------
DROP TABLE IF EXISTS `cat_tipousuario`;
CREATE TABLE `cat_tipousuario` (
  `IdTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `IdCliente` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Sexo` char(255) DEFAULT '',
  `Telefono` bigint(10) DEFAULT NULL,
  `Celular` bigint(10) DEFAULT NULL,
  `CasaPropia` bit(1) NOT NULL,
  `AutoPropio` bit(1) NOT NULL,
  `LugarTrabajo` varchar(255) DEFAULT NULL,
  `TelTrabajo` bigint(10) DEFAULT NULL,
  `Antiguedad` int(11) DEFAULT NULL,
  `FkDireccion` int(11) NOT NULL,
  `FkDireccionCobro` int(11) NOT NULL,
  `Estatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCliente`),
  KEY `FkDireccion` (`FkDireccion`),
  KEY `FkDireccionCobro` (`FkDireccionCobro`),
  CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`FkDireccion`) REFERENCES `direccion` (`IdDireccion`),
  CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`FkDireccionCobro`) REFERENCES `direccion` (`IdDireccion`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cobrador
-- ----------------------------
DROP TABLE IF EXISTS `cobrador`;
CREATE TABLE `cobrador` (
  `IdCobrador` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCobrador` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Estatus` int(11) DEFAULT NULL,
  `FkRuta` int(11) NOT NULL,
  PRIMARY KEY (`IdCobrador`),
  KEY `FkRuta` (`FkRuta`),
  CONSTRAINT `cobrador_ibfk_1` FOREIGN KEY (`FkRuta`) REFERENCES `ruta` (`IdRuta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cobranza
-- ----------------------------
DROP TABLE IF EXISTS `cobranza`;
CREATE TABLE `cobranza` (
  `IdCobranza` int(11) NOT NULL AUTO_INCREMENT,
  `FkCobrador` int(11) NOT NULL,
  `FkVenta` int(11) NOT NULL,
  `FechaCobro` date NOT NULL,
  `Abono` double NOT NULL,
  `MontoVencido` double DEFAULT NULL,
  `AbonoVencido` int(11) DEFAULT NULL,
  `AbonoAtrasado` int(11) DEFAULT NULL,
  `PrimerCobro` tinyint(4) DEFAULT NULL,
  `FkLio` int(11) DEFAULT NULL,
  `Comentario` text DEFAULT NULL,
  `GpsLat` double DEFAULT NULL,
  `GpsLon` double DEFAULT NULL,
  PRIMARY KEY (`IdCobranza`),
  KEY `FkCobrador` (`FkCobrador`),
  KEY `FkVenta` (`FkVenta`),
  KEY `FkLio` (`FkLio`),
  CONSTRAINT `cobranza_ibfk_1` FOREIGN KEY (`FkCobrador`) REFERENCES `cobrador` (`IdCobrador`),
  CONSTRAINT `cobranza_ibfk_2` FOREIGN KEY (`FkVenta`) REFERENCES `venta` (`IdVenta`),
  CONSTRAINT `cobranza_ibfk_3` FOREIGN KEY (`FkLio`) REFERENCES `cat_lio` (`IdLio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cuenta
-- ----------------------------
DROP TABLE IF EXISTS `cuenta`;
CREATE TABLE `cuenta` (
  `IdCuenta` int(11) NOT NULL AUTO_INCREMENT,
  `NumeroCuenta` int(11) NOT NULL,
  `FkCliente` int(11) NOT NULL,
  `SaldoTotal` double DEFAULT NULL,
  `EstatusPagador` varchar(255) DEFAULT NULL,
  `ContadorVencidos` int(11) DEFAULT NULL,
  `ContadorAtrasados` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for devolucion
-- ----------------------------
DROP TABLE IF EXISTS `devolucion`;
CREATE TABLE `devolucion` (
  `IdDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `FkVenta` int(11) NOT NULL,
  `Comentario` varchar(255) DEFAULT NULL,
  `EstadoArticulo` varchar(255) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`IdDevolucion`),
  KEY `FkVenta` (`FkVenta`),
  CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`FkVenta`) REFERENCES `venta` (`IdVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for direccion
-- ----------------------------
DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `IdDireccion` int(11) NOT NULL AUTO_INCREMENT,
  `FkEstado` int(11) NOT NULL,
  `FkMunicipio` int(11) NOT NULL,
  `FkColonia` int(11) NOT NULL,
  `FkCalle` int(11) NOT NULL,
  `NumExterior` int(11) DEFAULT NULL,
  `NumInterior` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDireccion`),
  KEY `FkEstado` (`FkEstado`),
  KEY `FkMunicipio` (`FkMunicipio`),
  KEY `FkColonia` (`FkColonia`),
  KEY `FkCalle` (`FkCalle`),
  CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`FkEstado`) REFERENCES `cat_estado` (`IdEstado`),
  CONSTRAINT `direccion_ibfk_2` FOREIGN KEY (`FkMunicipio`) REFERENCES `cat_municipio` (`IdMunicipio`),
  CONSTRAINT `direccion_ibfk_3` FOREIGN KEY (`FkColonia`) REFERENCES `cat_colonia` (`IdColonia`),
  CONSTRAINT `direccion_ibfk_4` FOREIGN KEY (`FkCalle`) REFERENCES `cat_calle` (`IdCalle`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for inventariodevolucion
-- ----------------------------
DROP TABLE IF EXISTS `inventariodevolucion`;
CREATE TABLE `inventariodevolucion` (
  `IdInventarioD` int(11) NOT NULL AUTO_INCREMENT,
  `FkDevolucion` int(11) NOT NULL,
  `CantidadDevolucion` int(11) NOT NULL,
  PRIMARY KEY (`IdInventarioD`),
  KEY `FkDevolucion` (`FkDevolucion`),
  CONSTRAINT `inventariodevolucion_ibfk_1` FOREIGN KEY (`FkDevolucion`) REFERENCES `devolucion` (`FkVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for inventarioprincipal
-- ----------------------------
DROP TABLE IF EXISTS `inventarioprincipal`;
CREATE TABLE `inventarioprincipal` (
  `IdInventarioP` int(11) NOT NULL AUTO_INCREMENT,
  `FkArticulo` int(11) NOT NULL,
  `CantidadPrincipal` int(11) NOT NULL,
  PRIMARY KEY (`IdInventarioP`),
  KEY `FkArticulo` (`FkArticulo`),
  CONSTRAINT `inventarioprincipal_ibfk_1` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for inventariosecundario
-- ----------------------------
DROP TABLE IF EXISTS `inventariosecundario`;
CREATE TABLE `inventariosecundario` (
  `IdInventarioS` int(11) NOT NULL AUTO_INCREMENT,
  `FkInventarioP` int(11) NOT NULL,
  `CantidadSecundario` int(11) NOT NULL,
  PRIMARY KEY (`IdInventarioS`),
  KEY `FkInventarioP` (`FkInventarioP`),
  CONSTRAINT `inventariosecundario_ibfk_1` FOREIGN KEY (`FkInventarioP`) REFERENCES `inventarioprincipal` (`IdInventarioP`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for listanegra
-- ----------------------------
DROP TABLE IF EXISTS `listanegra`;
CREATE TABLE `listanegra` (
  `IdLIstaNegra` int(11) NOT NULL AUTO_INCREMENT,
  `FkCliente` int(11) NOT NULL,
  `FkCat_Motivo` int(11) NOT NULL,
  `Comentario` varchar(255) DEFAULT NULL,
  `FechaAgregado` datetime NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`IdLIstaNegra`),
  KEY `FkCliente` (`FkCliente`),
  KEY `FkCat_Motivo` (`FkCat_Motivo`),
  CONSTRAINT `listanegra_ibfk_1` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`),
  CONSTRAINT `listanegra_ibfk_2` FOREIGN KEY (`FkCat_Motivo`) REFERENCES `cat_motivo` (`IdMotivo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for movimientoinventario
-- ----------------------------
DROP TABLE IF EXISTS `movimientoinventario`;
CREATE TABLE `movimientoinventario` (
  `IdMovimientoInventario` int(11) NOT NULL AUTO_INCREMENT,
  `FkInventarioP` int(11) DEFAULT NULL,
  `FkInventarioS` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `FkUsuario` int(11) NOT NULL,
  `FkTipoMovimiento` int(11) NOT NULL,
  PRIMARY KEY (`IdMovimientoInventario`),
  KEY `FkInventarioP` (`FkInventarioP`),
  KEY `FkUsuario` (`FkUsuario`),
  KEY `FkTipoMovimiento` (`FkTipoMovimiento`),
  KEY `FkInventarioS` (`FkInventarioS`),
  CONSTRAINT `movimientoinventario_ibfk_1` FOREIGN KEY (`FkInventarioP`) REFERENCES `inventarioprincipal` (`IdInventarioP`),
  CONSTRAINT `movimientoinventario_ibfk_2` FOREIGN KEY (`FkUsuario`) REFERENCES `usuario` (`IdUsuario`),
  CONSTRAINT `movimientoinventario_ibfk_3` FOREIGN KEY (`FkTipoMovimiento`) REFERENCES `tipomovimiento` (`IdTipoMovimiento`),
  CONSTRAINT `movimientoinventario_ibfk_4` FOREIGN KEY (`FkInventarioS`) REFERENCES `inventariosecundario` (`IdInventarioS`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pedido
-- ----------------------------
DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL AUTO_INCREMENT,
  `FkCliente` int(11) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `FkArticulo` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`IdPedido`),
  KEY `FkCliente` (`FkCliente`),
  KEY `FkArticulo` (`FkArticulo`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`),
  CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for referencia
-- ----------------------------
DROP TABLE IF EXISTS `referencia`;
CREATE TABLE `referencia` (
  `IdReferencia` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `FkDireccion` int(11) DEFAULT NULL,
  `FkCliente` int(11) NOT NULL,
  PRIMARY KEY (`IdReferencia`),
  KEY `FkDireccion` (`FkDireccion`),
  KEY `FkCliente` (`FkCliente`),
  CONSTRAINT `referencia_ibfk_1` FOREIGN KEY (`FkDireccion`) REFERENCES `direccion` (`IdDireccion`),
  CONSTRAINT `referencia_ibfk_2` FOREIGN KEY (`FkCliente`) REFERENCES `cliente` (`IdCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ruta
-- ----------------------------
DROP TABLE IF EXISTS `ruta`;
CREATE TABLE `ruta` (
  `IdRuta` int(11) NOT NULL AUTO_INCREMENT,
  `NumeroRuta` int(11) NOT NULL,
  `FkColonia` int(11) NOT NULL,
  PRIMARY KEY (`IdRuta`),
  KEY `FkColonia` (`FkColonia`),
  CONSTRAINT `ruta_ibfk_1` FOREIGN KEY (`FkColonia`) REFERENCES `cat_colonia` (`IdColonia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for subventa
-- ----------------------------
DROP TABLE IF EXISTS `subventa`;
CREATE TABLE `subventa` (
  `IdSubVenta` int(11) NOT NULL AUTO_INCREMENT,
  `FkArticulo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `SubTotal` double NOT NULL,
  `IdPorVenta` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`IdSubVenta`),
  KEY `FkArticulo` (`FkArticulo`),
  CONSTRAINT `subventa_ibfk_2` FOREIGN KEY (`FkArticulo`) REFERENCES `articulo` (`IdArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipomovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tipomovimiento`;
CREATE TABLE `tipomovimiento` (
  `IdTipoMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `TipoMovimiento` varchar(255) NOT NULL,
  PRIMARY KEY (`IdTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `FkCat_TipoUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuario`),
  KEY `FkCat_TipoUsuario` (`FkCat_TipoUsuario`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`FkCat_TipoUsuario`) REFERENCES `cat_tipousuario` (`IdTipoUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for vendedor
-- ----------------------------
DROP TABLE IF EXISTS `vendedor`;
CREATE TABLE `vendedor` (
  `IdVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `NombreVendedor` varchar(255) NOT NULL,
  `APaterno` varchar(255) NOT NULL,
  `AMaterno` varchar(255) NOT NULL,
  `Estatus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdVendedor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for venta
-- ----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL AUTO_INCREMENT,
  `FkCuenta` int(11) NOT NULL,
  `FkSubVenta` int(11) NOT NULL,
  `TotalVenta` double NOT NULL,
  `Enganche` double NOT NULL,
  `Fecha` date NOT NULL DEFAULT current_timestamp(),
  `FkVendedor` int(11) NOT NULL,
  `PeriodoPago` varchar(255) NOT NULL,
  `CantidadAbono` double(10,2) DEFAULT NULL,
  `SaldoPendiente` double(10,2) DEFAULT NULL,
  `HorarioCobro` int(11) NOT NULL,
  `TipoVenta` tinyint(4) NOT NULL,
  `GpsLat` double DEFAULT NULL,
  `GpsLon` double DEFAULT NULL,
  PRIMARY KEY (`IdVenta`),
  KEY `FkCuenta` (`FkCuenta`),
  KEY `FkVendedor` (`FkVendedor`),
  KEY `FkSubVenta` (`FkSubVenta`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`FkCuenta`) REFERENCES `cuenta` (`IdCuenta`),
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`FkVendedor`) REFERENCES `vendedor` (`IdVendedor`),
  CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`FkSubVenta`) REFERENCES `subventa` (`IdSubVenta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
