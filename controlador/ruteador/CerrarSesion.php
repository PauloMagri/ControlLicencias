<?php
require_once '../persistencia/DbSentencias.php';
require_once '../persistencia/ControladorPersistencia.php';
require_once '../controladoresEspecificos/ControladorSesion.php';

//Se crea un controlador de sesion
$sesion = new ControladorSesion();

//Se cierra la sesion
$sesion->cerrar();