<?php

require_once "DataBase.php";

Class API extends DataBase
{
	public function __construct()
	{
		$comando = $_GET['comando'];
		$this->$comando();
	}

	public function pegaUsuarioAutenticado()
	{
		$data = $this->pegaSessao();
		echo json_encode(Array("resposta" => $data['nome']));
	}
	
	public function pegaSessao()
	{
		session_start();
		return isset($_SESSION['data'])?$_SESSION['data']:null;
	}
}

new API();

?>
