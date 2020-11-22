<?php
require_once 'ControladorGeneral.php';

class ControladorPersona extends ControladorGeneral 
{
	function __construct($datos)
	{
		parent::__construct();
	}

	//Se agrega una Persona, primero se verifica si existe la persona, para modificarla o ingresarla
	public function agregar($datos){
		try {
			$parametros = array("dni" => $datos['dni'], "apellido" => $datos['apellido'], "nombre" => $datos['nombre'], "sexo" => $datos['sexo'], "cuil" => $datos['cuil'], "nacimiento" => $datos['nacimiento'], "telefono" => $datos['telefono'], "domicilio" => $datos['domicilio']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_PERSONA, $parametros);
		}catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}			
	
	
	//Se actualizan los datos de una Persona
	public function modificar($datos){
		try {
			$parametros = array("dni" => $datos['dni'], "apellido" => $datos['apellido'], "nombre" => $datos['nombre'], "sexo" => $datos['sexo'], "cuil" => $datos['cuil'], "nacimiento" => $datos['nacimiento'], "telefono" => $datos['telefono'], "domicilio" => $datos['domicilio'], "id" => $datos['idpersona']);
		$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_PERSONA, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}

	//Se elimina los datos de una persona
	public function eliminar($datos){
		try {
			$parametros = array("id" => $datos['id']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_PERSONA, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}

	//Se buscan los datos de una solo persona segun su dni
	public function buscar($datos){
		try {
		$parametros = array("dni" => $datos['dni']);
		$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_PERSONA, $parametros);
		$fila = $resultado->fetch();
		return $fila;	
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}

	//Se lista a todas las personas
	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_PERSONAS);
			$arrayPersonas = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayPersonas;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}

	}

}