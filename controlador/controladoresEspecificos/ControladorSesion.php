<?php
require_once '../persistencia/DbSentencias.php';
require_once '../persistencia/ControladorPersistencia.php';

class ControladorSesion implements DbSentencias {

	private $usuario;
	private $refControladorPersistencia;

	public function __construct(){
		session_start();
		$this->usuario = 'usuario';
		$this->refControladorPersistencia = ControladorPersistencia::obtenerCP();
	}

	//Se inicia sesion de usuario
	public function iniciar($datos){
		//Se verifica que el usuario exista
		$parametros = array("usuario" => base64_decode(base64_decode($datos['u'])));
		$resultado = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::BUSCAR_USUARIO, $parametros);
		$registro = $resultado->fetch();

		//Si existe
		if($registro){
			//Se verifica que la contraseña sea la correcta
			if($registro['clave'] == base64_decode($datos['c'])){
				$_SESSION[$this->usuario] = $registro['nombre'];
				$_SESSION['idUsuario'] = $registro['id'];
				//Se verifico exitosamente usuario y contraseña
				try {
					$par = array("idusuario" => $registro['id']);
					$res = $this->refControladorPersistencia->ejecutarSentencia(DbSentencias::LISTAR_USUARIOPERMISOS, $par);
					$permisos = $res->fetchAll(PDO::FETCH_ASSOC);
					echo json_encode($permisos);
				} catch (Exception $e) {
					echo "Failed: " . $e->getMessage();
				}
				
			} else {
				//La contraseña es incorrecta
				echo 1;
			}
		} else {
			//El usuario no existe
			echo 2;
		}
	}

	//Se cierra sesion y se redirecciona a la pagina inicial
	public function cerrar(){
		session_destroy();
		$this->usuario = NULL;
		header('Location: ../../index.html');
	}

	//Se verifica que haya una sesion abierta
	public function verificar(){
		if(!isset($_SESSION[$this->usuario])){
			return false;
		}else{
			return true;
		}
	}

	public function getUsuario(){
		return $_SESSION[$this->usuario];	
	}

	public function getIdUsuario(){
		//$idUsuario = array("idusuario" => $_SESSION['idUsuario']);
		//return $idUsuario;
		if ($this->verificar()) {
			return $_SESSION['idUsuario'];
		} else{
			return false;
		}
		
	}

	public function getRefControladorPersistencia(){
		return $this->refControladorPersistencia;
	}
	
}