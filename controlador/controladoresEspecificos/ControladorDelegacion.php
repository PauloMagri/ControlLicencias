<?php
require_once 'ControladorGeneral.php';

class ControladorDelegacion extends ControladorGeneral {

	function __construct($datos) {
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
    		
    	} catch (Exception $e) {
    		echo "Failed: " . $e->getMessage();
    	}
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_DELEGACIONES);
			$arrayDelegaciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayDelegaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
}