<?php
require_once 'ControladorGeneral.php';

class ControladorAuditoria extends ControladorGeneral{

	function __construct($datos){
		parent::__construct();
	}

	public function agregar($datos){
		try {
			$parametros = array("usuario" => $datos['usuario'], "accion" => $datos['accion'], "fecha" => $datos['fecha'], "tabla" => $datos['tabla'], "idregistro" => $datos['idregistro']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_AUDITORIA, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){}

	public function eliminar($datos){}

	public function buscar($datos){
		try {
			$parametros = array("tabla" => $datos['tabla'], "idregistro" => $datos['idregistro']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_AUDITORIAS, $parametros);
			$arrayAuditoria = $resultado->fetchALL(PDO::FETCH_ASSOC);
			return $arrayAuditoria;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	
	public function listar($datos){}

}