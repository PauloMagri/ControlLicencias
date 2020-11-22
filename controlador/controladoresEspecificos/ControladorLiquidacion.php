<?php
require_once 'ControladorGeneral.php';

class ControladorLiquidacion extends ControladorGeneral {
	function __construct($datos){
		parent::__construct();
	}

	public function agregar($datos){
		try {
			$parametros = array("mes" => $datos['mes'], "dias" => $datos['dias']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::AGREGAR_LIQUIDACION, $parametros);
			$ultimoId = $this->buscar($parametros);
			return $ultimoId;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){
		try {
			if (isset($datos['mes']) && isset($datos['dias'])){
				$parametros = array("mes" => $datos['mes'], "dias" => $datos['dias'], "id" => $datos['id']);
				$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::MODIFICAR_LIQUIDACION, $parametros);
			} else{
				$parametros = array("id" => $datos['id']);
				$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::MODIFICAR_ESTADOLIQUIDACION, $parametros);
			}	
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function eliminar($datos){
		try {
			$parametros = array("id" => $datos['idliquidacion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_LIQUIDACION, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscar($datos){
		try {
			//$parametros = array("idpedidovacaciones" => $datos['idpedidovacaciones']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_ULTIMALIQUIDACION);
			$arrayLiquidaciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayLiquidaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_LIQUIDACIONES);
			$arrayLiquidaciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayLiquidaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}