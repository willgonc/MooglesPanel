<?php

/**
 *	Classe que valida os dados do formulário de login e cria a sessão
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "../../ControleGeral.php";

Class Controle extends ControleGeral {

	private $id;
	private $nome;
	private $email;
	private $status;
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
        $data = Array(True, '');
		
		// validados os dados do formulário
        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email) || !parent::strRequire($this->senha) || !parent::strRequire($this->confirmaSenha)) {
            $data[0] = False;
            $data[1] = "Preencha todos os campos obrigat&oacute;rios do formul&aacute;rio!";
        } else if (!parent::validaEmail($this->email)) {
            $data[0] = False;
            $data[1] = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if ($this->senha != $this->confirmaSenha) {
            $data[0] = False;
            $data[1] = "Confirme a senha corretamente!";
        } else if (strlen($this->senha) < 6) {
            $data[0] = False;
            $data[1] = "A senha deve ter no m&iacute;nimo 6 caracteres!";
        } else {
			$check = $this->verificaEmailCadastrado();
			if ($check[0] == False){
				$data[0] = $check[0];
				$data[1] = $check[1];
			}
		}

        if ($data[0]) {
			$this->senha = sha1($this->senha);

			$this->nome = htmlentities($this->nome, ENT_QUOTES, "UTF-8");
			try {
				// FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
				$insert = parent::executeQuery("INSERT INTO usuarios (nome, email, senha, status) 
							VALUES ('".$this->nome."','".$this->email."', '".$this->senha."', 0)");
				
				if ($insert) {
					$data[0] = True;
					$data[1] = "O usu&aacute;rio foi adicionado com sucesso!";
				} else {
					$data[0] = False;
					$data[1] = "Erro ao adicionar o usu&aacute;rio!";
				}
			} catch ( Exception $e ){
				$data[0] = False;
				$data[1] = "Erro ao adicionar o usu&aacute;rio!";
			}
		}
		parent::retornaResultado($data);
	}

    /**
     *  Remove um usuário da base de dados
     *  @access public
     *  @name removerUsuario()
	 *	@return JSON
     */
	public function removerUsuario(){
		$select = parent::executeQuery("DELETE FROM usuarios WHERE id=".$_GET['id']);

		if ($select) {
			$retorno[0] = True;
			$retorno[1] = "O usu&aacute;rio foi removido!";
		} else {
			$retorno[0] = False;
			$retorno[1] = "Erro ao remover usu&aacute;rios!";
		}

        parent::retornaResultado($retorno);
	}
	
    /**
     *  Atualiza os dados de um usuário da base de dados

     *  @access public
     *  @name editarUsuario()
	 *	@return JSON
     */
	public function editarUsuario(){
		$this->pegaDados();
        $data = Array(True, '');
		
		// validados os dados do formulário
        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email)) {
            $data[0] = False;
            $data[1] = "Preencha todos os campos obrigat&oacute;rios do formul&aacute;rio!";
        } else if (!parent::validaEmail($this->email)) {
            $data[0] = False;
            $data[1] = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if (parent::strRequire($this->senha) || parent::strRequire($this->confirmaSenha)){
			if ($this->senha != $this->confirmaSenha) {
				$data[0] = False;
				$data[1] = "Confirme a senha corretamente!";
			} else if (strlen($this->senha) < 6) {
				$data[0] = False;
				$data[1] = "A senha deve ter no m&iacute;nimo 6 caracteres!";
			}
        } else {
			$check = $this->verificaEmailCadastrado();
			if (!$check[0]){
				$data[0] = $check[0];
				$data[1] = $check[1];
			}
		}

        if ($data[0]) {
			$this->senha = parent::strRequire($this->senha) ? sha1($this->senha) : null;

			$this->nome = htmlentities($this->nome, ENT_QUOTES, "UTF-8");
			try {
				// FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
				$update = parent::executeQuery("UPDATE usuarios SET 
					nome='".$this->nome."', 
					email='".$this->email."',
					".($this->senha != null ? "senha='".$this->senha."'," : "")."
					status=".$this->status." 
					WHERE id=".$this->id);

				if ($update) {
					$data[0] = True;
					$data[1] = "O usu&aacute;rio foi editado!";
				} else {
					$data[0] = False;
					$data[1] = "Erro ao editar usu&aacute;rio!2";
				}
			} catch ( Exception $e ){
				$data[0] = False;
				$data[1] = "Erro ao editar usu&aacute;rio!1";
			}
		}

		parent::retornaResultado($data);
	}
    
	/**
     *  Pega os dados recebidos na requisição
     *  @access puplic
     *  @name pegaDados()
     */
	private function pegaDados(){
		$this->id = 			isset($_GET['id']) ? $_GET['id'] : null;
		$this->nome =		 	isset($_GET['nome']) ? $_GET['nome'] : null;
		$this->email = 			isset($_GET['email']) ? $_GET['email'] : null;
		$this->status = 		isset($_GET['status']) ? $_GET['status'] : null;
		$this->senha = 			isset($_GET['senha']) ? $_GET['senha'] : null;
		$this->confirmaSenha = 	isset($_GET['confirmaSenha']) ? $_GET['confirmaSenha'] : null;
	}

	/**
     *  Verifaca um endereço de e-mail
     *  @access private
     *  @name verificaEmailCadastrado()
	 *	@return array
     */
	private function verificaEmailCadastrado()
    {
		//Em caso edição o id tambem é verificado
		$whereId = $this->id != null ? ' and id<>'.$this->id : '';
        $retorno = Array(True, '');
        try {
            $result = parent::executeQuery("SELECT * FROM usuarios WHERE email='".$this->email."'".$whereId);
            if ($result) {
                if (parent::getNumRows($result) == 0) {
					$retorno[0] = True;
					$retorno[1] = "";
                } else {
					$retorno[0] = False;
					$retorno[1] = "Este e-mail j&aacute; est&aacute; cadastrado!";
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
     *  Retorna um array com os dados de todos os usuários cadastrados
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

	/**
     *  Método para retornar os dados de um usuário
	 *
     *  @access public
     *  @name pegaDadosUsuarioPorId()
     *  @return array|false
     */
	public function pegaDadosUsuario() {
	 	$this->pegaDados();
	 	$select = parent::executeQuery('SELECT * FROM usuarios WHERE id='.$this->id);
		if ($select) {
			if (parent::getNumRows($select) == 1) {
				while($row = parent::fetchResults($select)) {
					$arr = Array(
						'id' => $row['id'],
						'nome' => $row['nome'],
						'email' => $row['email'],
						'status' => $row['status'],
						'senha' => $row['senha']
					);
				}
				parent::retornaResultado(Array(true, $arr));
			} else {
				parent::retornaResultado(Array(False,'Erro ao buscar dados do usuário!'));
			}
		} else {
			parent::retornaResultado(Array(False, 'Erro ao buscar dados do usuário!'));
		}
	}
}

new Controle();

?>
