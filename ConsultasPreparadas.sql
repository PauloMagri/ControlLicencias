-- Consultas preparadas

-- Usuario
SELECT * FROM usuario WHERE nombre = ?;
INSERT INTO `usuario`(`nombre`, `clave`) VALUES (?,?);
DELETE FROM `usuario` WHERE `id` = ?;
UPDATE `usuario` SET `nombre` = ?, `clave` = ? WHERE `id` = ?;

-- Permiso 
SELECT * FROM `permiso` WHERE `descripcion` = ?;
INSERT INTO `permiso`(`descripcion`) VALUES (?);
DELETE FROM `permiso` WHERE `id` = ?;
UPDATE `permiso` SET `descripcion` = ? WHERE `id` = ?;

-- UsuarioPermiso
SELECT `usuariopermiso`.`idusuario`, `permiso`.`descripcion` FROM `usuariopermiso` INNER JOIN `permiso` ON `usuariopermiso`.`idpermiso` = `permiso`.`id` WHERE `usuariopermiso`.`idusuario` = (SELECT `usuario`.`id` FROM usuario WHERE nombre = "admin");
INSERT INTO `usuariopermiso`(`idusuario`, `idpermiso`) VALUES (?, ?);
DELETE FROM `usuariopermiso` WHERE `id` = ?;
UPDATE `usuariopermiso` SET `idpermiso` = ? WHERE `id` = ?;

-- Persona
SELECT * FROM `persona` WHERE `dni` = ?;
INSERT INTO `persona`(`dni`, `apellido`, `nombre`, `sexo`, `cuil`, `nacimiento`, `telefono`, `domicilio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);
DELETE FROM `persona` WHERE `dni` = ?;
UPDATE `persona` SET `dni` = ?, `apellido` = ?, `nombre` = ?, `sexo` = ?, `cuil` = ?, `nacimiento` = ?, `telefono` = ?, `domicilio` = ? WHERE `dni` = ?;

-- Empleado
SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`dni`, `persona`.`sexo`,`empleado`.`ingreso`, `seccion`.`nombre` AS seccion, `delegacion`.`nombre` AS delegacion, `persona`.`nacimiento`, `persona`.`cuil`, `persona`.`domicilio`, `persona`.`telefono`
FROM `empleado` 
INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
INNER JOIN `seccion` ON `empleado`.`idseccion` = `seccion`.`id`
INNER JOIN `delegacion` ON `empleado`.`iddelegacion` = `delegacion`.`id`
WHERE `dni` = 12345678;

SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `persona`.`dni`, `persona`.`sexo`,`empleado`.`ingreso`, `seccion`.`nombre` AS seccion, `delegacion`.`nombre` AS delegacion, `persona`.`nacimiento`, `persona`.`cuil`, `persona`.`domicilio`, `persona`.`telefono`
FROM `empleado` 
INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
INNER JOIN `seccion` ON `empleado`.`idseccion` = `seccion`.`id`
INNER JOIN `delegacion` ON `empleado`.`iddelegacion` = `delegacion`.`id`;

INSERT INTO `empleado`(`legajo`, `ingreso`, `idpersona`, `idseccion`, `iddelegacion`) VALUES (?, ?, ?, ?, ?);
DELETE FROM `empleado` WHERE `legajo` = ?;
UPDATE `empleado` SET `ingreso` = ?, `idpersona` = ?, `idseccion` = ?, `iddelegacion` = ? WHERE `legajo` = ?;

-- Socio
SELECT * FROM `socio` WHERE `numero`=1;

-- Delegaciones
SELECT `delegacion`.`id`, `delegacion`.`nombre` FROM `delegacion`;

-- Secciones
SELECT `seccion`.`id`, `seccion`.`nombre` FROM `seccion`;

-- Licencia vacaciones
INSERT INTO `licenciavacaciones`(`anio`, `dias`, `pendientes`, `idempleado`) VALUES (?, ?, ?, ?);

SELECT `licenciavacaciones`.`anio`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`pendientes`, `licenciavacaciones`.`idempleado`
FROM `licenciavacaciones`
WHERE `licenciavacaciones`.`idempleado` = ? AND `licenciavacaciones`.`anio` = ?;

SELECT `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`anio`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`pendientes`, `licenciavacaciones`.`id`
FROM `empleado`
INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
INNER JOIN `licenciavacaciones` ON `empleado`.`legajo` = `licenciavacaciones`.`idempleado`
WHERE `empleado`.`baja` = 0
ORDER BY `licenciavacaciones`.`anio`;

UPDATE `licenciavacaciones` 
SET `pendientes` = (SELECT `licenciavacaciones`.`pendientes` FROM `licenciavacaciones` WHERE `licenciavacaciones`.`id` = ?) - ?
WHERE `licenciavacaciones`.`id` = ?;

-- Pedido vacaciones
INSERT INTO `pedidovacaciones`(`fecha`, `idempleado`, `idlicenciavacaciones`, `desde`, `hasta`, `dias`) VALUES (?, ?, ?, ?, ?, ?);

SELECT `pedidovacaciones`.`id`, `pedidovacaciones`.`fecha`, `empleado`.`legajo`, `persona`.`apellido`, `persona`.`nombre`, `empleado`.`ingreso`, `licenciavacaciones`.`dias`, `licenciavacaciones`.`anio`, `pedidovacaciones`.`desde`, `pedidovacaciones`.`hasta`, `licenciavacaciones`.`pendientes`
FROM `pedidovacaciones`
INNER JOIN `empleado` ON `pedidovacaciones`.`idempleado` = `empleado`.`legajo`
INNER JOIN `licenciavacaciones` ON `pedidovacaciones`.`idlicenciavacaciones` = `licenciavacaciones`.`id`
INNER JOIN `persona` ON `empleado`.`idpersona` = `persona`.`id`
WHERE `pedidovacaciones`.`id` = ? OR `pedidovacaciones`.`idempleado` = ?;

UPDATE `pedidovacaciones` SET `desde` = ?, `hasta` = ?, `dias` = ? WHERE `id` = ?;

DELETE FROM `pedidovacaciones` WHERE `pedidovacaciones`.`id` = ?;
