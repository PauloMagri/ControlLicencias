<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorAuditoria.php';
require_once 'ControladorSesion.php';

class ControladorLicenciaVacaciones extends ControladorGeneral{

	function __construct($datos){
		parent::__construct();
		date_default_timezone_set('America/Argentina/Mendoza');
	}

	public function agregar($datos){
		try {
			$parametros = array("anio" => $datos['anio'], "dias" => $datos['dias'], "pendientes" => $datos['pendientes'], "idempleado" => $datos['legajo'], "antiguedad" => $datos['antiguedad']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_LICENCIAVACACIONES, $parametros);

			$resultado = $this->buscar($datos);

			//Se agrega el registro al momento de agragar una licencia de vacaciones
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Agregar", "fecha" => date('y-m-d g:ia'), "tabla" => "licenciavacaciones", "idregistro" => $resultado['id']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			return $resultado;
			
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){
		try {
			
			$parametros = array("dias" => $datos['dias'], "pendientes" => $datos['pendiente'], "id" => $datos['idlicenciavacaciones']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_LICENCIAVACACIONES, $parametros);

			//Se agrega el registro al momento de modificar una licencia de vacaciones
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Modificar", "fecha" => date('y-m-d g:ia'), "tabla" => "licenciavacaciones", "idregistro" => $datos['idlicenciavacaciones']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

		} catch (Exception $e){
			echo "Failed: " . $e->getMessage();
		}
		
	}

	public function eliminar($datos){
		//No es necesario eliminar
	}

	public function buscar($datos){
		try {
			$parametros = array("idempleado" => $datos['legajo'], "anio" => $datos['anio']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_LICENCIAVACACIONES, $parametros);
			$fila = $resultado->fetch();
			return $fila;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarLicencias($datos){
		try {
			$query = str_replace("? = ?", "`" . $datos['tabla'] . "`." . "`" . $datos['criterio'] . "`" . " = " . $datos['idseccion'] . " AND `licenciavacaciones`.`anio` = " . "'" . $datos['anio'] . "'",DbSentencias::BUSCAR_LICENCIASVACACIONES);
            $resultado = $this->refControladorPersistencia->ejecutarSentencia($query);
            $arrayLicencias = $resultado->fetchAll(PDO::FETCH_ASSOC);
            return $arrayLicencias;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_LICENCIAVACACIONES);
			$arrayLicencias = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayLicencias;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}