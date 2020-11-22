<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorLicenciaVacaciones.php';
require_once 'ControladorAuditoria.php';
require_once 'ControladorSesion.php';

class ControladorPedidoVacaciones extends ControladorGeneral {
	
	function __construct($datos){
		parent::__construct();
		date_default_timezone_set('America/Argentina/Mendoza');
	}

	public function agregar($datos){
		try {

			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se busca el id de la licencia correspondiente del empleado y el año ingresado
			$parametros = array("legajo" => $datos['legajo'], "anio" => $datos['licencia']);
			$controlador = new ControladorLicenciaVacaciones($parametros);
			$idLicenciaVacaciones = $controlador->buscar($parametros);

			//Se agrega el pedido de vacaciones
			$parametros = array("fecha" => $datos['fecha'], "idempleado" => $datos['legajo'], "idlicenciavacaciones" => $idLicenciaVacaciones['id']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_PEDIDOVACACIONES, $parametros);

			//Una vez ingresado el nuevo pedido de vacaciones se busca el ultimo pedido de vacaciones del empleado, para imprimir el correspondiente formulario con sus datos
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->buscarUltimoPedidoVacaciones($parametros);

			//Se agrega el registro al momento de agragar un pedido de vacaciones
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Agregar", "fecha" => date('y-m-d g:ia'), "tabla" => "pedidovacaciones", "idregistro" => $resultado[0]['idpedidovacaciones']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			//Si no hay error se ejecuta un commit
			$this->refControladorPersistencia->confirmarTransaccion();

			return $resultado;

		} catch (Exception $e){
			//Ante un error se ejecuta un rollback
			$this->refControladorPersistencia->rollBackTransaccion();
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){
		try {

			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se modifica el pedido de vacaciones
			$parametros = array("desde" => $datos['desde'], "hasta" => $datos['hasta'], "dias" => $datos['cantidaddias'], "pendientes" => $datos['pendientes'], "id" => $datos['idpedidovacaciones']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_PEDIDOVACACIONES, $parametros);

			//Se modifica la licencia
			$parametros = array("dias" => $datos['dias'], "pendiente" => $datos['pendientes'], "idlicenciavacaciones" => $datos['idlicenciavacaciones']);
			$controlador = new ControladorLicenciaVacaciones($parametros);
			$controlador->modificar($parametros);

			//Se agrega el registro al momento de modificar un pedido de vacaciones
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Modificar", "fecha" => date('y-m-d g:ia'), "tabla" => "pedidovacaciones", "idregistro" => $datos['idpedidovacaciones']);
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
			$parametros = array("id" => $datos['idpedidovacaciones']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_PEDIDOVACACIONES, $parametros);

			//Se agrega el registro al momento de eliminar un pedido de vacaciones
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Eliminar", "fecha" => date('y-m-d g:ia'), "tabla" => "pedidovacaciones", "idregistro" => $datos['idpedidovacaciones']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscar($datos){
		try {
			$parametros = array("idpedidovacaciones" => $datos['idpedidovacaciones'], "legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_PEDIDOSVACACIONES, $parametros);
			$arrayPedidoVacaciones = $resultado->fetchAll();
			return $arrayPedidoVacaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarPorDelegacion($datos){
		try {
			$parametros = array("iddelegacion" => $datos['delegacion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_PVPORDELEGACION, $parametros);
			$arrayPedidoVacaciones = $resultado->fetchAll();
			return $arrayPedidoVacaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarUltimoPedidoVacaciones($datos){
		try {
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_ULTIMOPEDIDOVACACIONES, $parametros);
			$arrayPedidoVacaciones = $resultado->fetchALL(PDO::FETCH_ASSOC);
			return $arrayPedidoVacaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	
	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_PEDIDOVACACIONES);
			$arrayPedidoVacaciones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayPedidoVacaciones;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}