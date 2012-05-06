<?php

require_once "../../ControleGeral.php";

Class Controle extends ControleGeral {
	private $arquivo;
	private $nomeArquivo;
	private $tipoArquivo;
	private $dataUpload;
	private $dimensoesImagem;
	private $urlArquivo;
	private $uploadDir = './upload/';

	public function __construct(){
		parent::__construct();
		parent::executaAcao();
	}
	
	public function uploadArquivo(){
		$retorno = Array(True, '');
		$this->pegaDados();
		
		$this->nomeArquivo = $this->arquivo['name'];
		$this->tipoArquivo = $this->arquivo['type'];
		$this->dataUpload = date("Y-m-d H:i:s");
		$this->urlArquivo = $_POST['path'].'arquivos/upload/'.$this->nomeArquivo;
		
		$tipo = explode('/', $this->tipoArquivo);
		if ($tipo[0] == 'image'){
			$size = getimagesize($this->arquivo["tmp_name"]);
			$this->dimensoesImagem = $size[0].'x'.$size[1];
		} else {
			$this->dimensoesImagem = '';
		}

		$flag = True;
		$ponteiro  = opendir($this->uploadDir);
		// monta os vetores com os itens encontrados na pasta
		while ($nome_itens = readdir($ponteiro)) {
			if ($nome_itens == $this->arquivo["name"])
				$flag = False;
		}
		
		if ($flag){
			$copy = move_uploaded_file($this->arquivo['tmp_name'], $this->uploadDir.$this->arquivo['name']);
			if ($copy){
				if ($this->insertData() == True) {
					$retorno = Array(True, 'O arquivo foi enviado com sucesso!');
				} else {
					$this->deletaArquivo();
					$retorno = Array(False, 'Erro ao enviar o arquivo!');
				}
			} else {
				$retorno = Array(False, 'Erro ao enviar o arquivo!');
			}
		} else {
			$retorno = Array(False, 'J&aacute; existe um arquivo com este nome!');
		}

		parent::retornaResultado($retorno);
	}

	private function insertData(){
		try {
			$insert = parent::executeQuery('INSERT INTO arquivos (nome, tipo, legenda, data, dimensoes, titulo, textoAlternativo, descricao, url)
				VALUES ("'.$this->nomeArquivo.'", "'.$this->tipoArquivo.'", "", "'.$this->dataUpload.'", "'.$this->dimensoesImagem.'", "", "", "", "'.$this->urlArquivo.'")');

			if ($insert)
				return True;
			else
				return False;
		} catch ( Exception $e ){
			return False;
		}
	}

	private function deletaArquivo(){
		exec('rm '.$this->uploadDir.$this->nomeArquivo);
	}

	private function pegaDados(){
		if (isset($_FILES['userfile']))
			$this->arquivo = $_FILES['userfile'];
		else
			parent::retornaResultado(Array(False, 'O arquivo n&atilde;o foi enviado!'));
	}
}

new Controle();

?>
