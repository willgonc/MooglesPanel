<?php

require_once "Modelo.php";

Class API extends Modelo {
	public function __construct() {
		$acao = $_GET['acao'];
		$this->$acao();
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
