<?php

require_once "../../ControleGeral.php";

Class Controle extends ControleGeral {
	private $arquivo;
	private $nomeArquivo;
	private $tipoArquivo;
	private $dataUpload;
	private $dimensoesImagem;
	private $urlArquivo;
	private $legenda;
	private $uploadDir = './upload/';
	private $extencaoArquivo;

	public function __construct(){
		parent::__construct();
		parent::executaAcao();
	}
	
	public function uploadArquivo(){
		$retorno = Array(True, '');
		if (isset($_FILES['arquivo']))
			$this->arquivo = $_FILES['arquivo'];
		else
			echo '<script>alert("O arquivo não foi enviado!");window.location = "./index.html";</script>';
		
		$this->nomeArquivo = $this->arquivo['name'];
		$this->tipoArquivo = $this->arquivo['type'];
		$this->dataUpload = date("Y-m-d H:i:s");
		$this->urlArquivo = $_SERVER["SERVER_NAME"].'/modulos/arquivos/upload/'.$this->nomeArquivo;
		$this->legenda = preg_replace('/\.(\w+)$/', '', $this->nomeArquivo);

		$exten = explode('.', $this->nomeArquivo);
		$this->extencaoArquivo = strtoupper($exten[count($exten)-1]);
		
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
			if ($nome_itens == $this->arquivo["name"]){
				$retorno = Array(False, 'J&aacute; existe um arquivo com este nome!');
				$flag = False;
			}
		}
		
		if ($flag){
			$tiposValidos = "/png|jpeg|gif|bmp|vnd\.oasis\.opendocument\.text|".
				"vnd\.openxmlformats-officedocument\.wordprocessingml\.document|msword|plain|pdf|".
				"vnd.ms-excel|vnd.oasis.opendocument.spreadsheet|zip|x-rar/";

			if (!preg_match($tiposValidos, $tipo[1])) {
				$flag = False;
				$retorno = Array(False, 'Erro ao enviar arquivo!'.$this->tipoArquivo);
			}
		}
			

		if ($flag){
			$copy = move_uploaded_file($this->arquivo['tmp_name'], $this->uploadDir.$this->arquivo['name']);
			if ($copy){
				if ($this->adicionaArquivo() == True) {
					$retorno = Array(True, 'O arquivo foi enviado com sucesso!');
				} else {
					exec('rm '.$this->uploadDir.$this->nomeArquivo);
					$retorno = Array(False, 'Erro ao enviar o arquivo!');
				}
			} else {
				$retorno = Array(False, 'Erro ao enviar o arquivo!');
			}
		}

		parent::retornaResultado($retorno);
	}

	private function adicionaArquivo() {
		try {
			$insert = parent::executeQuery('INSERT INTO arquivos (nome, tipo, legenda, data, dimensoes, titulo, textoAlternativo, descricao, url)
				VALUES ("'.$this->nomeArquivo.'", "'.$this->extencaoArquivo.'", "'.$this->legenda.'", 
					"'.$this->dataUpload.'", "'.$this->dimensoesImagem.'", "", "", "", "'.$this->urlArquivo.'")');

			if ($insert)
				return True;
			else
				return False;
		} catch ( Exception $e ){
			return False;
		}
	}
    
	/**
     *  Retorna um array com os dados de todos os arquivos cadastrados
     *  @access public
     *  @name pegaTodosUsuarios()
	 *	@return JSON
     */
	public function pegaTodosArquivos(){
        $retorno = Array(True, '');
		$valores = Array();
        try {
			$select = parent::executeQuery("SELECT * FROM arquivos ORDER BY data DESC");
            
            if ($select) {
				while ($row = parent::fetchResults($select)) {
					$valores[] = Array(
						'id' => $row['id'],
						'nome' => $row['nome'],
						'tipo' => $row['tipo'],
						'legenda' => $row['legenda'],
						'data' => $row['data']
					);
				}
				$retorno[0] = True;
				$retorno[1] = $valores;
            } else {
				$retorno[0] = False;
				$retorno[1] = "Erro ao buscar arquivos!";
            }
        } catch ( Exception $e ){
			$retorno[0] = False;
			$retorno[1] = "Erro ao buscar arquivos!";
        }
        parent::retornaResultado($retorno);
	}

	private function deletaArquivo(){
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
