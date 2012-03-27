<?php

/**
 *	Classe que valida os dados do formulário de login e cria a sessão
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "../../ControleGeral.php";

Class Controle extends ControleGeral {

	private $nome;
	private $email;
	private $senha;
	private $confirmaSenha;

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct() { 
		parent::__construct();
		parent::executaAcao();
	}

	/**
     *  Método para adicionar um usuário
     *  @access puplic
     *  @name adicionaUsuario()
	 *	@return JSON
     */
	public function adicionaUsuario(){
		$this->pegaDados();
        $data = $this->validaDados();
        if ($data[0]) {
			$insert = $this->fazPersistenciaDosDados();
			parent::retornaResultado($insert);
		} else {
			parent::retornaResultado($data);
		}
	}
    
	/**
     *  Pega os dados recebidos na requisição
     *  @access puplic
     *  @name pegaDados()
     */
	private function pegaDados(){
		$this->nome = $_GET['nome'];
		$this->email = $_GET['email'];
		$this->senha = $_GET['senha'];
		$this->confirmaSenha = $_GET['confirmaSenha'];
	}

	/**
     *  Método que valida os dados para persitência
     *  @access private
     *  @name validateData()
	 *	@return array
     */
    private function validaDados() {
        $retorno = Array(True, '');
		
        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email) || !parent::strRequire($this->senha) || !parent::strRequire($this->confirmaSenha)) {
            $retorno[0] = False;
            $retorno[1] = "Preencha todos os campos obrigat&oacute;rios do formul&aacute;rio!";
        } else if (!parent::validaEmail($this->email)) {
            $retorno[0] = False;
            $retorno[1] = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if ($this->senha != $this->confirmaSenha) {
            $retorno[0] = False;
            $retorno[1] = "Confirme a senha corretamente!";
        } else if (strlen($this->senha) < 6) {
            $retorno[0] = False;
            $retorno[1] = "A senha deve ter no m&iacute;nimo 6 caracteres!";
        } else {
			$check = $this->verificaEmailCadastrado();
			if ($check[0] == False){
				$retorno[0] = $check[0];
				$retorno[1] = $check[1];
			}
		}
        return $retorno;
    }
    
	/**
     *  Verifaca um endereço de e-mail
     *  @access private
     *  @name verificaEmailCadastrado()
	 *	@return array
     */
	private function verificaEmailCadastrado()
    {
        $retorno = Array(True, '');
        try {
            $result = parent::executeQuery("SELECT * FROM usuarios WHERE email='".$this->email."'");
            if ($result) {
                if (parent::getNumRows($result) >= 1) {
					$retorno[0] = False;
					$retorno[1] = "Este e-mail j&aacute; est&aacute; cadastrado!";
                } else {
					$retorno[0] = True;
					$retorno[1] = "";
                }
            } else {
				$retorno[0] = False;
				$retorno[1] = "Erro ao verificar o e-mail!";
            }
        } catch ( Exception $e ) {
			$retorno[0] = False;
			$retorno[1] = "Erro ao verificar o e-mail!";
        }
        return $retorno;
    }

    /**
     *  Faz a insersão dos dados no banco
     *  @access private
     *  @name fazPersistenciaDosDados()
	 *	@return array
     */
    private function fazPersistenciaDosDados(){
        $retorno = Array(True, '');
        $this->senha = sha1($this->senha);

        $this->nome = htmlentities($this->nome, ENT_QUOTES, "UTF-8");
        try {
            // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
            $insert = parent::executeQuery("INSERT INTO usuarios (nome, email, senha, status) 
                        VALUES ('".$this->nome."','".$this->email."', '".$this->senha."', 0)");
            
            if ($insert) {
				$retorno[0] = True;
				$retorno[1] = "O usu&aacute;rio foi adicionado com sucesso!";
            } else {
				$retorno[0] = False;
				$retorno[1] = "Erro ao adicionar o usu&aacute;rio!";
            }
        } catch ( Exception $e ){
			$retorno[0] = False;
			$retorno[1] = "Erro ao adicionar o usu&aacute;rio!";
        }
        return $retorno;
    }

    /**
     *  Retorna um array com os dados de todos os usuários
     *  @access public
     *  @name pegaTodosUsuarios()
	 *	@return array
     */
	public function pegaTodosUsuarios(){
        $retorno = Array(True, '');
		$valores = Array();
        try {
			$select = parent::executeQuery("SELECT * FROM usuarios ORDER BY nome");
            
            if ($select) {
				while ($row = parent::fetchResults($select)) {
					$valores[] = Array(
						'id' => $row['id'],
						'nome' => $row['nome'],
						'email' => $row['email'],
						'senha' => $row['senha'],
						'status' => $row['status']
					);
				}
				$retorno[0] = True;
				$retorno[1] = $valores;
            } else {
				$retorno[0] = False;
				$retorno[1] = "Erro ao buscar usu&aacute;rios!";
            }
        } catch ( Exception $e ){
			$retorno[0] = False;
			$retorno[1] = "Erro ao buscar usu&aacute;rios!";
        }
        parent::retornaResultado($retorno);
	}
}

new Controle();

?>
