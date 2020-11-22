<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorLiquidacion.php';

class ControladorLiquidacionDiasCtaLicencia extends ControladorGeneral 
{
	function __construct($datos)
	{
		parent::__construct();
	}

	public function agregar($datos){
		try {
			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se agrega la liquidacion y se obtiene el id
			$parametros = array("mes" => $datos['mes'], "dias" => $datos['dias']);
			$controladorLiquidacion = new ControladorLiquidacion($parametros);
			$idLiquidacion = $controladorLiquidacion->agregar($parametros);
			
			$parametros = array("idliquidacion" => $idLiquidacion[0]['id'], "iddiasctalicencia" => $datos['iddiasctalicencia']);
			$resualtado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::AGREGAR_LIQUIDACIONDIASCTALICENCIA, $parametros);

			//Si no hay error se ejecuta un commit
			$this->refControladorPersistencia->confirmarTransaccion();
		} catch (Exception $e) {
			//Ante un error se ejecuta un rollback
			$this->refControladorPersistencia->rollBackTransaccion();
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
			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se elimina la liquidacion del pedido vacaciones para luego eliminar la liquidacion correspondiente
			$parametros = array("idliquidacion" => $datos['idliquidacion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_LIQUIDACIONDIASCTALICENCIA, $parametros);

			$controladorLiquidacion = new ControladorLiquidacion($parametros);
			$controladorLiquidacion->eliminar($parametros);

			//Si no hay error se ejecuta un commit
			$this->refControladorPersistencia->confirmarTransaccion();
		} catch (Exception $e) {
			//Ante un error se ejecuta un rollback
			$this->refControladorPersistencia->rollBackTransaccion();
			echo "Failed: " . $e->getMessage();
		}
	}
	public function buscar($datos){
		try {
			$parametros = array("iddiasctalicencia" => $datos['iddiasctalicencia']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_LIQUIDACIONDIASCTALICENCIA, $parametros);
			$arrayLiquidaciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayLiquidaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	public function listar($datos){
		try {
			
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}