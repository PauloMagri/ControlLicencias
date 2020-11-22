<?php
require_once 'ControladorGeneral.php';

class ControladorPermiso extends ControladorGeneral 
{
	function __construct($datos)
	{
		parent::__construct();
	}

	public function agregar($datos){}
	public function modificar($datos){}
	public function eliminar($datos){}
	public function buscar($datos){
		try {
			$parametros = array("descripcion" => $datos['descripcion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_PERMISO, $parametros);
			$permiso = $resultado->fetch();
			return $permiso;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}
	
	public function listar($datos){
		$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_PERMISOS);
		$arrayPermisos = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return $arrayPermisos;
	}

}