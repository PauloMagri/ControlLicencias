/*
SQLyog Ultimate v9.63 
MySQL - 5.5.5-10.1.40-MariaDB : Database - controllicencias
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`controllicencias` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `controllicencias`;

/*Table structure for table `auditoria` */

DROP TABLE IF EXISTS `auditoria`;

CREATE TABLE `auditoria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario` tinytext,
  `accion` tinytext,
  `fecha` datetime DEFAULT NULL,
  `tabla` tinytext,
  `idregistro` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auditoria` */

/*Table structure for table `delegacion` */

DROP TABLE IF EXISTS `delegacion`;

CREATE TABLE `delegacion` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `delegacion` */

/*Table structure for table `diasctalicencia` */

DROP TABLE IF EXISTS `diasctalicencia`;

CREATE TABLE `diasctalicencia` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `dias` int(2) DEFAULT NULL,
  `idempleado` int(10) DEFAULT NULL,
  `idlicenciavacaciones` int(10) DEFAULT NULL,
  `pendientes` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idempleado` (`idempleado`),
  KEY `idlicenciavacaciones` (`idlicenciavacaciones`),
  CONSTRAINT `diasctalicencia_ibfk_1` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`legajo`),
  CONSTRAINT `diasctalicencia_ibfk_2` FOREIGN KEY (`idlicenciavacaciones`) REFERENCES `licenciavacaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `diasctalicencia` */

/*Table structure for table `empleado` */

DROP TABLE IF EXISTS `empleado`;

CREATE TABLE `empleado` (
  `legajo` int(8) NOT NULL AUTO_INCREMENT,
  `ingreso` date DEFAULT NULL,
  `idpersona` int(10) DEFAULT NULL,
  `idseccion` int(3) DEFAULT NULL,
  `iddelegacion` int(3) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`legajo`),
  KEY `empleado_ibseccion` (`idseccion`),
  KEY `empleado_ibdelegacion` (`iddelegacion`),
  KEY `empleado_ibpersona` (`idpersona`),
  CONSTRAINT `empleado_ibdelegacion` FOREIGN KEY (`iddelegacion`) REFERENCES `delegacion` (`id`),
  CONSTRAINT `empleado_ibpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`),
  CONSTRAINT `empleado_ibseccion` FOREIGN KEY (`idseccion`) REFERENCES `seccion` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `empleado` */

/*Table structure for table `licenciavacaciones` */

DROP TABLE IF EXISTS `licenciavacaciones`;

CREATE TABLE `licenciavacaciones` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `anio` tinytext,
  `dias` int(2) DEFAULT NULL,
  `pendientes` tinyint(2) DEFAULT NULL,
  `idempleado` int(10) DEFAULT NULL,
  `antiguedad` tinytext,
  PRIMARY KEY (`id`),
  KEY `licenciavacaciones_ibempleado` (`idempleado`),
  CONSTRAINT `licenciavacaciones_ibempleado` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`legajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `licenciavacaciones` */

/*Table structure for table `liquidacion` */

DROP TABLE IF EXISTS `liquidacion`;

CREATE TABLE `liquidacion` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mes` int(2) DEFAULT NULL,
  `dias` int(3) DEFAULT NULL,
  `liquidado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `liquidacion` */

/*Table structure for table `liquidaciondiasctalicencia` */

DROP TABLE IF EXISTS `liquidaciondiasctalicencia`;

CREATE TABLE `liquidaciondiasctalicencia` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idliquidacion` int(10) NOT NULL,
  `iddiasctalicencia` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `liquidaciondiasctalicencia_idliquidacion` (`idliquidacion`),
  KEY `liquidaciondiasctalicencia_iddiasctalicencia` (`iddiasctalicencia`),
  CONSTRAINT `liquidaciondiasctalicencia_iddiasctalicencia` FOREIGN KEY (`iddiasctalicencia`) REFERENCES `diasctalicencia` (`id`),
  CONSTRAINT `liquidaciondiasctalicencia_idliquidacion` FOREIGN KEY (`idliquidacion`) REFERENCES `liquidacion` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `liquidaciondiasctalicencia` */

/*Table structure for table `liquidacionpedidovacaciones` */

DROP TABLE IF EXISTS `liquidacionpedidovacaciones`;

CREATE TABLE `liquidacionpedidovacaciones` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idliquidacion` int(10) NOT NULL,
  `idpedidovacaciones` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `liquidacionpedidovacaciones_idliquidacion` (`idliquidacion`),
  KEY `liquidacionpedidovacaciones_idpedidovacaciones` (`idpedidovacaciones`),
  CONSTRAINT `liquidacionpedidovacaciones_idliquidacion` FOREIGN KEY (`idliquidacion`) REFERENCES `liquidacion` (`id`),
  CONSTRAINT `liquidacionpedidovacaciones_idpedidovacaciones` FOREIGN KEY (`idpedidovacaciones`) REFERENCES `pedidovacaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `liquidacionpedidovacaciones` */

/*Table structure for table `pedidovacaciones` */

DROP TABLE IF EXISTS `pedidovacaciones`;

CREATE TABLE `pedidovacaciones` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `dias` tinyint(2) DEFAULT NULL,
  `idlicenciavacaciones` int(10) DEFAULT NULL,
  `pendientes` tinyint(3) DEFAULT NULL,
  `idempleado` int(10) DEFAULT NULL,
  `autorizado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pedidovacaciones_ibempleado` (`idempleado`),
  KEY `pedidovacaciones_iblicenciavacaciones` (`idlicenciavacaciones`),
  CONSTRAINT `pedidovacaciones_ibempleado` FOREIGN KEY (`idempleado`) REFERENCES `empleado` (`legajo`),
  CONSTRAINT `pedidovacaciones_iblicenciavacaciones` FOREIGN KEY (`idlicenciavacaciones`) REFERENCES `licenciavacaciones` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pedidovacaciones` */

/*Table structure for table `permiso` */

DROP TABLE IF EXISTS `permiso`;

CREATE TABLE `permiso` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descripcion` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `permiso` */

insert  into `permiso`(`id`,`descripcion`) values (1,'usuarios'),(2,'subsidios'),(3,'rrhh'),(4,'turismo'),(5,'linkLegajos'),(6,'agregarEmpleado'),(7,'modificarEmpleado'),(8,'eliminarEmpleado'),(9,'AuditoriaEmpleados'),(10,'linkVacaciones'),(11,'linkPedidoVacaciones'),(12,'agregarPedidoVacaciones'),(13,'generarPedidoVacaciones'),(14,'modificarPedidoVacaciones'),(15,'eliminarPedidoVacaciones'),(16,'autorizarPedidoVacaciones'),(17,'AuditoriaPedidoVacaciones'),(18,'linkDiasCtaLicencia'),(19,'agregarDiasCtaLicencia'),(20,'modificarDiasCtaLicencia'),(21,'eliminarDiasCtaLicencia'),(22,'autorizarDiasCtaLicencia'),(23,'AuditoriaDiasCtaLicencia'),(24,'linkLicenciaVacaciones'),(25,'agregarLicenciaVacaciones'),(26,'generarLicenciasVacaciones'),(27,'modificarLicenciaVacaciones'),(28,'AuditoriaLicenciaVacaciones'),(29,'agregarUsuario'),(30,'modificarUsuario'),(31,'auditoriaUsuario'),(32,'linkLiquidacion'),(33,'modificarLiquidacion');

/*Table structure for table `persona` */

DROP TABLE IF EXISTS `persona`;

CREATE TABLE `persona` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `dni` int(10) NOT NULL,
  `apellido` tinytext,
  `nombre` tinytext,
  `sexo` char(1) DEFAULT NULL,
  `cuil` tinytext,
  `nacimiento` date DEFAULT NULL,
  `telefono` tinytext,
  `domicilio` text,
  `localidad` tinytext,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `persona` */

/*Table structure for table `seccion` */

DROP TABLE IF EXISTS `seccion`;

CREATE TABLE `seccion` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `seccion` */

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` tinytext NOT NULL,
  `clave` text NOT NULL,
  `baja` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`nombre`,`clave`,`baja`) values (1,'admin','MTIz',0),(11,'paulo','MTIz',0),(12,'juan','MTIz',0),(13,'yaya','MTIz',0),(14,'federico','aG9saXM=',0),(15,'claudio','YXNk',0),(18,'pauloooo','enhj',0);

/*Table structure for table `usuariopermiso` */

DROP TABLE IF EXISTS `usuariopermiso`;

CREATE TABLE `usuariopermiso` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idusuario` int(10) DEFAULT NULL,
  `idpermiso` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuariopermiso_ibusuario` (`idusuario`),
  KEY `usuariopermiso_ibpermiso` (`idpermiso`),
  CONSTRAINT `usuariopermiso_ibpermiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`id`),
  CONSTRAINT `usuariopermiso_ibusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

/*Data for the table `usuariopermiso` */

insert  into `usuariopermiso`(`id`,`idusuario`,`idpermiso`) values (1,1,3),(2,1,1),(7,11,3),(10,12,1),(11,12,29),(14,13,3),(15,13,5),(16,13,6),(17,13,7),(18,13,8),(19,13,9),(20,13,10),(21,13,11),(22,13,12),(23,13,13),(24,13,14),(25,13,15),(26,13,16),(27,13,17),(28,13,18),(29,13,19),(30,13,20),(31,13,21),(32,13,22),(33,13,23),(34,13,24),(35,13,25),(36,13,26),(37,13,27),(38,13,28),(39,13,1),(40,13,29),(41,13,30),(42,13,31),(43,18,3),(44,18,5),(45,18,6),(46,18,1),(47,18,29),(52,11,5),(53,11,6),(54,11,7),(55,1,5),(56,1,6),(57,1,29),(59,1,30),(60,1,10),(61,1,11),(62,1,12),(63,1,18),(64,1,19),(65,1,24),(66,1,7),(67,1,14),(68,1,20),(69,1,25),(70,1,8),(71,1,9),(72,1,13),(73,1,15),(74,1,17),(75,1,21),(76,1,23),(77,1,26),(78,1,27),(79,1,28),(81,1,32),(82,1,33);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
