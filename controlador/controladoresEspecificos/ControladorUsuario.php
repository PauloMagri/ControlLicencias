<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorPermiso.php';
require_once 'ControladorUsuarioPermiso.php';
require_once 'ControladorSesion.php';

class ControladorUsuario extends ControladorGeneral 
{
	function __construct($datos){
		parent::__construct();
	}

	public function agregar($datos){
		
		try {
			//Se inicia la transaccion
			$this->refControladorPersistencia->iniciarTransaccion();

			//Se agrega el usuario
			$parametros = array("nombre" => base64_decode(base64_decode($datos['nombre'])), "clave" => base64_decode($datos['clave']));
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::INSERTAR_USUARIO, $parametros);

			//Una vez ingresado el usuario, buscamos su id
			$parametros = array("nombre" => $datos['nombre']);
			$usuario = $this->buscar($parametros);

			//Se crea una instancia del ControladorPermiso y ControladorUsuarioPermiso 
			$controladorPermiso = new ControladorPermiso($datos['permisos']);
			$controladorUsuarioPermiso = new ControladorUsuarioPermiso($parametros);

			//Se recorre el arreglo de los permisos elegidos por el usuario para buscar su id
			foreach ($datos['permisos'] as $key => $permiso) {
				//Se agregan los permisos para el usuario
				$arrayPermiso = array("permiso" => $permiso);
				$idPermiso = $controladorPermiso->buscar($arrayPermiso);
				$parametros = array("idusuario" => $usuario['id'], "idpermiso" => $idPermiso['id']);
				$resultado = $controladorUsuarioPermiso->agregar($parametros);
			}

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
			$parametros = array("clave" => base64_decode($datos['clave']), "id" => $datos['idusuario']);
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::ACTUALIZAR_USUARIO, $parametros);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

	public function eliminar($datos){

	}

	public function buscar($datos){
		try {
			$parametros = array("nombre" => base64_decode(base64_decode($datos['nombre'])));
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_USUARIO, $parametros);
			$usuario = $resultado->fetch();
			return $usuario;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}

	public function listar($datos){
		try {
			$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_USUARIOS);
			$arrayUsuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
			return $arrayUsuarios;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
		
	}

	public function datosUsuario(){
		try {
			$usuario = array("nombre" => $_SESSION['usuario'], "id" => $_SESSION['idUsuario']);
			return $usuario;
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}

}