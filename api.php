<?php

require_once "Modelo.php";

Class API extends Modelo {
	public function __construct() {
		$comando = $_GET['comando'];
		$this->$comando();
	}

	public function pegaUsuarioAutenticado() {
		$data = $this->pegaSessao();
		echo json_encode(Array("resposta" => $data['nome']));
	}
	
	public function pegaSessao() {
		session_start();
		return isset($_SESSION['data'])?$_SESSION['data']:null;
	}
}

new API();

?>
