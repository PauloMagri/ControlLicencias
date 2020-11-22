<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorLicenciaVacaciones.php';
require_once 'ControladorAuditoria.php';
require_once 'ControladorSesion.php';

class ControladorDiasCtaLicencia extends ControladorGeneral{

	function __construct($datos){
		parent::__construct();
		date_default_timezone_set('America/Argentina/Mendoza');
	}

	public function agregar($datos){
		try {

			//Se busca el id de la licencia correspondiente del empleado y el año ingresado
			$parametros = array("legajo" => $datos['legajo'], "anio" => $datos['licencia']);
			$controlador = new ControladorLicenciaVacaciones($parametros);
			$idLicenciaVacaciones = $controlador->buscar($parametros);

			//Se agrega el dia a cuenta de licencia
			$parametros = array("fecha" => $datos['fecha'], "idempleado" => $datos['legajo'], "idlicenciavacaciones" => $idLicenciaVacaciones['id']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_DIASCTALICENCIA, $parametros);

			//Una vez ingresado el nuevo dia a cuenta de licencia se busca el ultimo dia a cuenta de licencia del empleado, para imprimir el correspondiente formulario con sus datos
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->buscarUltimoDiasCtaLicencia($parametros);

			//Se agrega el registro al momento de agragar un dia a cuenta de licencia
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Agregar", "fecha" => date('y-m-d g:ia'), "tabla" => "diasctalicencia", "idregistro" => $resultado[0]['iddiasctalicencia']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			return $resultado;

		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){
		try {

			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			$parametros = array("desde" => $datos['desde'], "hasta" => $datos['hasta'], "dias" => $datos['cantidaddias'], "pendientes" => $datos['pendientes'], "id" => $datos['iddiasctalicencia']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_DIASCTALICENCIA, $parametros);

			//Se modifica la licencia
			$parametros = array("dias" => $datos['dias'], "pendiente" => $datos['pendientes'], "idlicenciavacaciones" => $datos['idlicenciavacaciones']);
			$controlador = new ControladorLicenciaVacaciones($parametros);
			$controlador->modificar($parametros);

			//Se agrega el registro al momento de modificar un dias a cuenta de licencia
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Modificar", "fecha" => date('y-m-d g:ia'), "tabla" => "diasctalicencia", "idregistro" => $datos['iddiasctalicencia']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			//Si no hay error se ejecuta un commit
			$this->refControladorPersistencia->confirmarTransaccion();

		} catch (Exception $e) {
			//Ante un error se ejecuta un rollback
			$this->refControladorPersistencia->rollBackTransaccion();
			echo "Failed: " . $e->getMessage();
		}
	}

	public function eliminar($datos){
		try {
			$parametros = array("id" => $datos['iddiasctalicencia']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_DIASCTALICENCIA, $parametros);

			//Se agrega el registro al momento de eliminar un dia a cuenta de licencia
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Eliminar", "fecha" => date('y-m-d g:ia'), "tabla" => "diasctalicencia", "idregistro" => $datos['iddiasctalicencia']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscar($datos){
		try {
			$parametros = array( "iddiasctalicencia" => $datos['iddiasctalicencia'], "legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_DIASCTALICENCIA, $parametros);
			$arrayDiasCtaLicencia = $resultado->fetchAll();
			return $arrayDiasCtaLicencia;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarUltimoDiasCtaLicencia($datos){
		try {
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_ULTIMODIASCTALICENCIA, $parametros);
			$arrayDiasCtaLicencia = $resultado->fetchALL(PDO::FETCH_ASSOC);
			return $arrayDiasCtaLicencia;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_DIASCTALICENCIA);
			$arrayDiasCtaLicencia = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayDiasCtaLicencia;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	
}