<?php
interface DbSentencias{

	//Usuario

	const INSERTAR_USUARIO = "INSERT INTO `usuario`(`nombre`, `clave`) VALUES (?, ?)";

	const ACTUALIZAR_USUARIO = "UPDATE `usuario` SET `clave` = ? WHERE `id` = ?";

	const ELIMINAR_USUARIO = "UPDATE `usuario` SET `baja` = 1 WHERE `id` = ?";

	const BUSCAR_USUARIO = "SELECT `usuario`.`id`, `usuario`.`nombre`, `usuario`.`clave` FROM `usuario` WHERE `usuario`.`nombre` = ?";

	const LISTAR_USUARIOS = "SELECT `usuario`.`id`, `usuario`.`nombre`, `usuario`.`clave` FROM `usuario` WHERE `baja` = 0 ";

	//Permiso

	const BUSCAR_PERMISO = "SELECT `permiso`.`id` FROM `permiso` WHERE `permiso`.`descripcion` = ?";

	const LISTAR_PERMISOS = "SELECT `permiso`.`descripcion` FROM `permiso`";

	//UsuarioPermiso

	const INSERTAR_USUARIOPERMISO = "INSERT INTO `usuariopermiso`(`idusuario`, `idpermiso`) VALUES (?, ?)";

	const ELIMINAR_USUARIOPERMISO = "DELETE FROM `usuariopermiso` WHERE `usuariopermiso`.`id` = ?";

	const BUSCAR_USUARIOPERMISO = "SELECT `usuariopermiso`.`id` FROM `usuariopermiso`
	INNER JOIN `permiso` ON `usuariopermiso`.`idpermiso` = `permiso`.`id`
	INNER JOIN `usuario` ON `usuariopermiso`.`idusuario` = `usuario`.`id` 
	WHERE `usuariopermiso`.`idusuario` = ? AND `permiso`.`descripcion` = ?";

	const LISTAR_USUARIOPERMISOS = "SELECT `permiso`.`id`, `permiso`.`descripcion` FROM `usuariopermiso` 
	INNER JOIN `permiso` ON `usuariopermiso`.`idpermiso` = `permiso`.`id` 
	WHERE `usuariopermiso`.`idusuario` = ?";	

	//Persona

	const INSERTAR_PERSONA = "INSERT INTO `persona`(`dni`, `apellido`, `nombre`, `sexo`, `cuil`, `nacimiento`, `telefono`, `domicilio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

	const ACTUALIZAR_PERSONA = "UPDATE `persona` SET `dni` = ?, `apellido` = ?, `nombre` = ?, `sexo` = ?, `cuil` = ?, `nacimiento` = ?, `telefono` = ?, `domicilio` = ? WHERE `id` = ?";

	const ELIMINAR_PERSONA = "DELETE FROM `persona` WHERE `id` = ?";

	const BUSCAR_PERSONA = "SELECT `id`, `dni`, `apellido`, `nombre`, `sexo`, `cuil`, `nacimiento`, `telefono`, `domicilio` FROM `persona` WHERE `dni` = ?";

	const LISTAR_PERSONAS = "SELECT * FROM `persona`";


	//Socio

	const INSERTAR_SOCIO = "INSERT INTO `socio`(`numero`, `idpersona`, `empresa`, `ingreso`) VALUES (?, (SELECT `id` FROM `persona` WHERE `dni` = ?), ?, ?)";

	const ACTUALIZAR_SOCIO = "UPDATE `socio` SET `empresa` = ?, `ingreso` = ? WHERE `numero` = ?";

	const ELIMINAR_SOCIO = "UPDATE `socio` SET `baja` = 1 WHERE `numero` = ?";

	const BUSCAR_SOCIO = "SELECT `socio`.`numero`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`id`, `persona`.`dni`, `persona`.`sexo`, `empresa`.`id`, `empresa`.`razonsocial`, `empresa`.`cuit`
		FROM `socio`
		INNER JOIN `persona` ON `socio`.`idpersona` = `persona`.`id`
		INNER JOIN `empresa` ON `socio`.`idempresa` = `empresa`.`id`
		WHERE `socio`.`baja` = 0 AND `socio`.`numero` = ?";

	const LISTAR_SOCIOS = "SELECT `socio`.`numero`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`id`, `persona`.`dni`, `persona`.`sexo`, `empresa`.`id`, `empresa`.`razonsocial`, `empresa`.`cuit`
		FROM `socio`
		INNER JOIN `persona` ON `socio`.`idpersona` = `persona`.`id`
		INNER JOIN `empresa` ON `socio`.`idempresa` = `empresa`.`id`
		WHERE `socio`.`baja` = 0";

	//Adherentes

	//Autorizado

	//Empleado

	const INSERTAR_EMPLEADO = "INSERT INTO `empleado`(`legajo`, `ingreso`, `idpersona`, `idseccion`, `iddelegacion`) VALUES (?, ?, (SELECT `id` FROM `persona` WHERE `dni` = ?), ?, ?)";

	const ACTUALIZAR_EMPLEADO = "UPDATE `empleado` SET `ingreso` = ?, `idpersona` = ?, `idseccion` = ?, `iddelegacion` = ? WHERE `legajo` = ?";
	
	const ELIMINAR_EMPLEADO = "UPDATE `empleado` SET `baja` = 1 WHERE `legajo` = ?";
	
	const BUSCAR_EMPLEADO = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`id`, `persona`.`dni`, `persona`.`sexo`,`empleado`.`ingreso`, `seccion`.`nombre` AS seccion, `delegacion`.`nombre` AS delegacion, `persona`.`nacimiento`, `persona`.`cuil`, `persona`.`domicilio`, `persona`.`telefono`
		FROM `empleado` 
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		INNER JOIN `seccion` ON `empleado`.`idseccion` = `seccion`.`id`
		INNER JOIN `delegacion` ON `empleado`.`iddelegacion` = `delegacion`.`id`
		WHERE `empleado`.`baja` = 0 AND `empleado`.`legajo` = ?";

	const BUSCAR_EMPLEADOS = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`id`, `persona`.`dni`, `persona`.`sexo`,`empleado`.`ingreso`, `seccion`.`nombre` AS seccion, `delegacion`.`nombre` AS delegacion, `persona`.`nacimiento`, `persona`.`cuil`, `persona`.`domicilio`, `persona`.`telefono`
		FROM `empleado` 
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		INNER JOIN `seccion` ON `empleado`.`idseccion` = `seccion`.`id`
		INNER JOIN `delegacion` ON `empleado`.`iddelegacion` = `delegacion`.`id`
		WHERE `empleado`.`baja` = 0 AND ? = ?";
	
	const LISTAR_EMPLEADOS = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`id`, `persona`.`dni`, `persona`.`sexo`,`empleado`.`ingreso`, `seccion`.`nombre` AS seccion, `delegacion`.`nombre` AS delegacion, `persona`.`nacimiento`, `persona`.`cuil`, `persona`.`domicilio`, `persona`.`telefono`
		FROM `empleado` 
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		INNER JOIN `seccion` ON `empleado`.`idseccion` = `seccion`.`id`
		INNER JOIN `delegacion` ON `empleado`.`iddelegacion` = `delegacion`.`id`
		WHERE `empleado`.`baja` = 0";

	const BUSCAR_EMPLEADOSLICENCIA = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`
		FROM `pedidovacaciones`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `pedidovacaciones`.`desde` <= ? AND `pedidovacaciones`.`hasta` >= ?
		UNION
		SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `diasctalicencia`.`desde`, `diasctalicencia`.`hasta`
		FROM `diasctalicencia`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `diasctalicencia`.`desde` <= ? AND `diasctalicencia`.`hasta` >= ?";

	//Delegacion

	const LISTAR_DELEGACIONES = "SELECT `delegacion`.`id`, `delegacion`.`nombre` FROM `delegacion`";

	//Seccion

	const LISTAR_SECCIONES = "SELECT `seccion`.`id`, `seccion`.`nombre` FROM `seccion`";

	const BUSCAR_DELEGACION = "SELECT `seccion`.`nombre` FROM `seccion`
	WHERE `seccion`.`id` = ?";

	//LicenciaVacaciones

	const INSERTAR_LICENCIAVACACIONES = "INSERT INTO `licenciavacaciones`(`anio`, `dias`, `pendientes`, `idempleado`, `antiguedad`) VALUES (?, ?, ?, ?, ?)";
	
	const ACTUALIZAR_LICENCIAVACACIONES = "UPDATE `licenciavacaciones` SET `dias` = ?, `pendientes` = ?
		WHERE `licenciavacaciones`.`id` = ?";
	
	const BUSCAR_LICENCIAVACACIONES = "SELECT `licenciavacaciones`.`id`, `licenciavacaciones`.`anio`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`pendientes`, `licenciavacaciones`.`idempleado`
		FROM `licenciavacaciones`
		WHERE `licenciavacaciones`.`idempleado` = ? AND `licenciavacaciones`.`anio` = ?";

	const BUSCAR_LICENCIASVACACIONES = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `licenciavacaciones`.`antiguedad`, `licenciavacaciones`.`anio`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`pendientes`, `licenciavacaciones`.`id` 
		FROM `empleado`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		INNER JOIN `licenciavacaciones` ON `empleado`.`legajo` = `licenciavacaciones`.`idempleado`
		WHERE `empleado`.`baja` = 0 AND ? = ?";
	
	const LISTAR_LICENCIAVACACIONES = "SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `licenciavacaciones`.`antiguedad`, `licenciavacaciones`.`anio`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`pendientes`, `licenciavacaciones`.`id` 
		FROM `empleado`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		INNER JOIN `licenciavacaciones` ON `empleado`.`legajo` = `licenciavacaciones`.`idempleado`
		WHERE `empleado`.`baja` = 0
		ORDER BY `licenciavacaciones`.`anio` DESC";

	//PedidosVacaciones

	const INSERTAR_PEDIDOVACACIONES = "INSERT INTO `pedidovacaciones`(`fecha`, `idempleado`, `idlicenciavacaciones`) VALUES (?, ?, ?)";

	const ACTUALIZAR_PEDIDOVACACIONES = "UPDATE `pedidovacaciones` SET `desde` = ?, `hasta` = ?, `dias` = ?, `pendientes` = ? WHERE `id` = ?";

	const ELIMINAR_PEDIDOVACACIONES = "DELETE FROM `pedidovacaciones` WHERE `pedidovacaciones`.`id` = ?";

	const BUSCAR_PEDIDOSVACACIONES = "SELECT `pedidovacaciones`.`id`, `pedidovacaciones`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`, `licenciavacaciones`.`pendientes`
		FROM `pedidovacaciones`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `pedidovacaciones`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `pedidovacaciones`.`id` = ? OR `pedidovacaciones`.`idempleado` = ? AND `pedidovacaciones`.`desde` != ''
		ORDER BY `pedidovacaciones`.`desde` DESC";

	const BUSCAR_PVPORSECCION = "SELECT `pedidovacaciones`.`id`, `pedidovacaciones`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`, `licenciavacaciones`.`pendientes`
		FROM `pedidovacaciones`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `pedidovacaciones`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `empleado`.`idseccion` = ?";

	const BUSCAR_ULTIMOPEDIDOVACACIONES = "SELECT `pedidovacaciones`.`id` AS idpedidovacaciones, `pedidovacaciones`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`, `licenciavacaciones`.`pendientes`
		FROM `pedidovacaciones`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `pedidovacaciones`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `pedidovacaciones`.`idempleado` = ?
		ORDER BY `pedidovacaciones`.`id` DESC
		LIMIT 1";
	
	const LISTAR_PEDIDOVACACIONES = "SELECT `pedidovacaciones`.`id`, `pedidovacaciones`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`id` AS idlicenciavacaciones, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`, `pedidovacaciones`.`dias` AS cantidaddias,`pedidovacaciones`.`pendientes`
		FROM `pedidovacaciones`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `pedidovacaciones`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`";

	//DiasCtaLicencia

	const INSERTAR_DIASCTALICENCIA = "INSERT INTO `diasctalicencia`(`fecha`, `idempleado`, `idlicenciavacaciones`) VALUES (?, ?, ?)";

	const ACTUALIZAR_DIASCTALICENCIA = "UPDATE `diasctalicencia` SET `desde` = ?, `hasta` = ?, `dias` = ?, `pendientes` = ? WHERE `id` = ?";

	const ELIMINAR_DIASCTALICENCIA = "DELETE FROM `diasctalicencia` WHERE `diasctalicencia`.`id` = ?";

	const BUSCAR_DIASCTALICENCIA = "SELECT `diasctalicencia`.`id`, `diasctalicencia`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `diasctalicencia`.`desde`, `diasctalicencia`.`hasta`, `licenciavacaciones`.`pendientes`
		FROM `diasctalicencia`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `diasctalicencia`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `diasctalicencia`.`id` = ? OR `diasctalicencia`.`idempleado` = ? AND `diasctalicencia`.`desde` != ''
		ORDER BY `diasctalicencia`.`desde` DESC";

	const BUSCAR_ULTIMODIASCTALICENCIA = "SELECT `diasctalicencia`.`id` AS iddiasctalicencia, `diasctalicencia`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `diasctalicencia`.`desde`, `diasctalicencia`.`hasta`, `licenciavacaciones`.`pendientes`
		FROM `diasctalicencia`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `diasctalicencia`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `diasctalicencia`.`idempleado` = ?
		ORDER BY `diasctalicencia`.`id` DESC
		LIMIT 1";
	
	const LISTAR_DIASCTALICENCIA = "SELECT `diasctalicencia`.`id`, `diasctalicencia`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`id` AS idlicenciavacaciones, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `diasctalicencia`.`desde`, `diasctalicencia`.`hasta`, `diasctalicencia`.`dias` AS cantidaddias,`diasctalicencia`.`pendientes`
		FROM `diasctalicencia`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `licenciavacaciones` ON `diasctalicencia`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`";

	//Liquidacion vacaciones

	const AGREGAR_LIQUIDACION = "INSERT INTO `liquidacion`(`mes`, `dias`) VALUES (?, ?)";

	const MODIFICAR_ESTADOLIQUIDACION = "UPDATE `liquidacion` SET `liquidado` = 1 WHERE `id` = ?";

	const MODIFICAR_LIQUIDACION = "UPDATE `liquidacion` SET `mes` = ?, `dias` = ? WHERE `id` = ?";

	const ELIMINAR_LIQUIDACION = "DELETE FROM `liquidacion` WHERE `id` = ?";

	const BUSCAR_ULTIMALIQUIDACION = "SELECT MAX(`id`) AS `id` FROM `liquidacion`";

	const BUSCAR_LIQUIDACION = "";

	const LISTAR_LIQUIDACIONES = "SELECT 'Pedido Vacaciones' AS `tipo`, `pedidovacaciones`.`id` AS `idpedido`, `liquidacion`.`mes`, `liquidacion`.`dias`, `liquidacion`.`id`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`
		FROM `liquidacionpedidovacaciones`
		INNER JOIN `liquidacion` ON `liquidacionpedidovacaciones`.`idliquidacion` = `liquidacion`.`id`
        INNER JOIN `pedidovacaciones` ON `liquidacionpedidovacaciones`.`idpedidovacaciones` = `pedidovacaciones`.`id`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo` 
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `liquidacion`.`liquidado` = 0
        
		UNION

		SELECT 'Dias a cuenta' AS `tipo`, `diasctalicencia`.`id` AS `idpedido`, `liquidacion`.`mes`, `liquidacion`.`dias`, `liquidacion`.`id`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`
		FROM `liquidaciondiasctalicencia`
		INNER JOIN `liquidacion` ON `liquidaciondiasctalicencia`.`idliquidacion` = `liquidacion`.`id`
        INNER JOIN `diasctalicencia` ON `liquidaciondiasctalicencia`.`iddiasctalicencia` = `diasctalicencia`.`id`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo` 
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `liquidacion`.`liquidado` = 0";

	//LiquidacionPedidoVacaciones

	const AGREGAR_LIQUIDACIONPEDIDOVACACIONES = "INSERT INTO `liquidacionpedidovacaciones` (`idliquidacion`, `idpedidovacaciones`) VALUES (?, ?)";

	const BUSCAR_LIQUIDACIONPEDIDOVACACIONES = "SELECT `pedidovacaciones`.`id` AS 'idpedidovacaciones', `liquidacion`.`mes`, `liquidacion`.`dias`, `liquidacion`.`id`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`
		FROM `liquidacionpedidovacaciones`
		INNER JOIN `liquidacion` ON `liquidacionpedidovacaciones`.`idliquidacion` = `liquidacion`.`id`
		INNER JOIN `pedidovacaciones` ON `liquidacionpedidovacaciones`.`idpedidovacaciones` = `pedidovacaciones`.`id`
		INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `liquidacionpedidovacaciones`.`idpedidovacaciones` = ?";

	const ELIMINAR_LIQUIDACIONPEDIDOVACACIONES = "DELETE FROM `liquidacionpedidovacaciones` WHERE `idliquidacion` = ?";

	//LiquidacionDiasCtaLicencia

	const AGREGAR_LIQUIDACIONDIASCTALICENCIA = "INSERT INTO `liquidaciondiasctalicencia` (`idliquidacion`, `iddiasctalicencia`) VALUES (?, ?)";

	const BUSCAR_LIQUIDACIONDIASCTALICENCIA = "SELECT `diasctalicencia`.`id` AS 'iddiasctalicencia', `liquidacion`.`mes`, `liquidacion`.`dias`, `liquidacion`.`id`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`
		FROM `liquidaciondiasctalicencia`
		INNER JOIN `liquidacion` ON `liquidaciondiasctalicencia`.`idliquidacion` = `liquidacion`.`id`
		INNER JOIN `diasctalicencia` ON `liquidaciondiasctalicencia`.`iddiasctalicencia` = `diasctalicencia`.`id`
		INNER JOIN `empleado` ON `diasctalicencia`.`idempleado` = `empleado`.`legajo`
		INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
		WHERE `liquidaciondiasctalicencia`.`iddiasctalicencia` = ?";

	const ELIMINAR_LIQUIDACIONDIASCTALICENCIA = "DELETE FROM `liquidaciondiasctalicencia` WHERE `idliquidacion` = ?";

	//Subsidios

	//Turismo

	//Auditoria

	const INSERTAR_AUDITORIA = "INSERT INTO `auditoria`(`usuario`, `accion`, `fecha`, `tabla`, `idregistro`) VALUES (?, ?, ?, ?, ?)";

	const BUSCAR_AUDITORIAS = "SELECT `auditoria`.`usuario`, `auditoria`.`accion`, `auditoria`.`fecha` 
		FROM `auditoria` 
		WHERE `auditoria`.`tabla` = ? AND `auditoria`.`idregistro` = ?
		ORDER BY `auditoria`.`fecha` DESC";

}