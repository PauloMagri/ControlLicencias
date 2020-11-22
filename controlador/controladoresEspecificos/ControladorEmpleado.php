<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorPersona.php';
require_once 'ControladorAuditoria.php';
require_once 'ControladorSesion.php';

class ControladorEmpleado extends ControladorGeneral {
	function __construct($datos){
		parent::__construct();
		date_default_timezone_set('America/Argentina/Mendoza');
	}

	//Se agrega un empleado
	public function agregar($datos){
		try {
			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();
			if($datos['idpersona'] == 0){
				//Se agrega una persona
				$parametros = array("dni" => $datos['dni'], "apellido" => $datos['apellido'], "nombre" => $datos['nombre'], "sexo" => $datos['sexo'], "cuil" => $datos['cuil'], "nacimiento" => $datos['fechaNacimiento'], "telefono" => $datos['telefono'], "domicilio" => $datos['domicilio']);
				$controlador = new ControladorPersona($parametros);
				$controlador->agregar($parametros);
			}
			if($datos['idpersona'] > 0 && $datos['modificar'] == true){
				//Se modifica una persona
				$parametros = array("dni" => $datos['dni'], "apellido" => $datos['apellido'], "nombre" => $datos['nombre'], "sexo" => $datos['sexo'], "cuil" => $datos['cuil'], "nacimiento" => $datos['fechaNacimiento'], "telefono" => $datos['telefono'], "domicilio" => $datos['domicilio'], "idpersona" => $datos['idpersona']);
				$controlador = new ControladorPersona($parametros);
				$controlador->modificar($parametros);
			}
			

			//Se agrega un empleado
			$parametros = array("legajo" => $datos['legajo'], "ingreso" => $datos['fechaIngreso'], "idpersona" => $datos['dni'], "idseccion" => $datos['seccion'], "iddelegacion" => $datos['delegacion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_EMPLEADO, $parametros);

			//Si no hay error se ejecuta un commit
			$this->refControladorPersistencia->confirmarTransaccion();

			//Se devuelve el empleado recientemente agregado
			$resultado = $this->buscar($datos); 

			//Se agrega el registro al momento de agragar un empleado
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Agregar", "fecha" => date('y-m-d g:ia'), "tabla" => "empleado", "idregistro" => $resultado['legajo']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			return $resultado;

		} catch (Exception $e) {
			//Ante un error se ejecuta un rollback
			$this->refControladorPersistencia->rollBackTransaccion();
			echo "Failed: " . $e->getMessage();
		}
	}

	//Se modifican los datos de un empleado
	public function modificar($datos){
		try {
			//Se inicia una transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se modifican los datos de la persona correspondiente
			$parametros = array("dni" => $datos['dni'], "apellido" => $datos['apellido'], "nombre" => $datos['nombre'], "sexo" => $datos['sexo'], "cuil" => $datos['cuil'], "nacimiento" => $datos['fechaNacimiento'], "telefono" => $datos['telefono'], "domicilio" => $datos['domicilio'], "idpersona" => $datos['idpersona']);
			$controlador = new ControladorPersona($parametros);
			$controlador->modificar($parametros);

			//Se modifican los datos del empleado
			$parametros = array("ingreso" => $datos['fechaIngreso'], "idpersona" => $datos['idpersona'], "idseccion" => $datos['seccion'], "iddelegacion" => $datos['delegacion'], "legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_EMPLEADO, $parametros);

			//Se agrega el registro al momento de modificar un empleado
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Modificar", "fecha" => date('y-m-d g:ia'), "tabla" => "empleado", "idregistro" => $datos['legajo']);
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

	//Se eliminan los datos de un empleado, pero no los de persona, ya que tambien puede seguir siendo socio, aherente o autorizado
	public function eliminar($datos){
		try {
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_EMPLEADO, $parametros);
			$legajoEmpleado = $parametros['legajo'];

			//Se agrega el registro al momento de eliminar un empleado
			$parametros = array("usuario" => $_SESSION['usuario'], "accion" => "Eliminar", "fecha" => date('y-m-d g:ia'), "tabla" => "empleado", "idregistro" => $datos['legajo']);
			$auditoria = new ControladorAuditoria($parametros);
			$registro = $auditoria->agregar($parametros);

			return $legajoEmpleado;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}

	}

	//Se buscan los datos de un empleado
	public function buscar($datos){
		try {
			$parametros = array("legajo" => $datos['legajo']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_EMPLEADO, $parametros);
			$fila = $resultado->fetch();
			return $fila;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarEmpleados($datos){
		try {
			$query = str_replace("? = ?", $datos['criterio'] . " = " . $datos['iddelegacion'], DbSentencias::BUSCAR_EMPLEADOS);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia($query);
			$arrayEmpleados = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayEmpleados;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscarEmpleadosLicencia($datos){
		try {
			$parametros = array("pvdesde" => $datos['fecha'], "pvhasta" => $datos['fecha'], "dcldesde" => $datos['fecha'], "dclhasta" => $datos['fecha']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_EMPLEADOSLICENCIA, $parametros);
			$empleadosLicencia = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $empleadosLicencia;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	
	//Se lista a todos los empleados
	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_EMPLEADOS);
			$arrayEmpleados = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayEmpleados;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}