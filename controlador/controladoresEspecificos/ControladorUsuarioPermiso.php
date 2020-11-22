<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorPermiso.php';

class ControladorUsuarioPermiso extends ControladorGeneral 
{
	function __construct($datos)
	{
		parent::__construct();
	}

	public function agregar($datos){
		try {
			$parametros = array("idusuario" => $datos['idusuario'], "idpermiso" => $datos['idpermiso']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_USUARIOPERMISO ,$parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function modificar($datos){
		try {
			//Se recorre la lista de los permisos a eliminar
			if(isset($datos['borrarPermisos'])){
				foreach ($datos['borrarPermisos'] as $key => $value) {
					//Se busca el id del usuarioPermiso
					$parametros = array("id" => $datos['idusuario'], "descripcion" => $value);
					$idUsuarioPermiso = $this->buscar($parametros);
					//Se elimina el permiso usando su id
					$parametros = array("idUsuarioPermiso" => $idUsuarioPermiso['id']);
					$resultado = $this->eliminar($parametros);
				}
			}
			

			//Se recorre la lista de los permisos a agregar
			if (isset($datos['agregarPermisos'])) {
				foreach ($datos['agregarPermisos'] as $key => $value) {
					//Se busca el id del permiso
					$parametros = array("descripcion" => $value);
					$controladorPermiso = new ControladorPermiso($parametros);
					$idPermiso = $controladorPermiso->buscar($parametros);
					//Se agrega el nuevo usuarioPermiso
					$parametros = array("idusuario" => $datos['idusuario'], "idpermiso" => $idPermiso['id']);
					$resultado = $this->agregar($parametros);
				}
			}
			
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function eliminar($datos){
		try {
			$parametros = array("id" => $datos['idUsuarioPermiso']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ELIMINAR_USUARIOPERMISO, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function buscar($datos){
		try {
			$parametros = array("idusuario" => $datos['id'], "descripcion" => $datos['descripcion']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_USUARIOPERMISO, $parametros);
			$idUsuarioPermiso = $resultado->fetch();
			return $idUsuarioPermiso;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}	

	public function listar($datos){
		try {
			$parametros = array("idusuario" => $datos['id']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_USUARIOPERMISOS, $parametros);
			$arrayPermisos = $resultado->fetchALL(PDO::FETCH_ASSOC);
			return $arrayPermisos;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}