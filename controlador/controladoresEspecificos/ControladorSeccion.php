<?php
require_once 'ControladorGeneral.php';

class ControladorSeccion extends ControladorGeneral{

	function __construct($datos){
		parent::__construct();
	}

	public function agregar($datos){
    	try {
    		
    	} catch (Exception $e) {
    		echo "Failed: " . $e->getMessage();
    	}
    }	

	public function modificar($datos){
		try {
    		
    	} catch (Exception $e) {
    		echo "Failed: " . $e->getMessage();
    	}
	}	

	public function eliminar($datos){
		try {
    		
    	} catch (Exception $e) {
    		echo "Failed: " . $e->getMessage();
    	}
	}

	public function buscar($datos){
		try {
    		$parametros = array("idseccion" => $datos['idseccion']);
    		$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_DELEGACION, $parametros);
    		$seccion = $resultado->fetch();
    		return $seccion;
    	} catch (Exception $e) {
    		echo "Failed: " . $e->getMessage();
    	}
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_SECCIONES);
			$arraySecciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arraySecciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
}