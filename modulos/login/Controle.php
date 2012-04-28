<?php

/**
 *	Classe que valida os dados do formulário de login e cria a sessão
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "../../ControleGeral.php";

Class Controle extends ControleGeral {
    /**
     *  Atributo que guarda o id
     *  @access private
     *  @name $id
     */
	private $id;

    /**
     *  Atributo que guarda o nome
     *  @access private
     *  @name $nome
     */
	private $nome;

    /**
     *  Atributo que guarda o email
     *  @access private
     *  @name $email
     */
    private $email;

    /**
     *  Atributo que guarda a senha
     *  @access private
     *  @name $senha
     */
    private $senha;

    /**
     *  Método construtor da classe
	 *
     *  @access public
     *  @name __construct()
     */
    public function __construct() { 
		parent::__construct();
		parent::executaAcao();
	}

    /**
     *  Autentica os dados enviado do formulário e cria uma sessão caso 
	 *		estejam corretos
	 *
     *  @access public
     *  @name autenticaUsuario()
	 *	@return JSON
     */
	public function autenticaUsuario(){
        session_start();
		$this->pegaDados();
		$data = $this->validaDados();

		if ($data[0] == True) {
            $this->criaSessao();
            parent::retornaResultado(Array(True,'A sess&atilde;o foi criada!'));
        } else {
            $this->destroiSessao();
            parent::retornaResultado(Array(False, $data[1]));
        }
		parent::closeConnect();
	}

    /**
     *  Método que armazena nos atributos os dados recebidos por post
	 *
     *  @access private
     *  @name pegaDados()
     */
    private function pegaDados()
    {
        $this->email = $_GET['email'];
        $this->senha = $_GET['senha'];
    }
    
    /**
     *  Método que cria a sessão e armazena dos dados do usuário
	 *		na sessão
	 *
	 *	@param array $data
     *  @access private
     *  @name criaSessao()
     */
    private function criaSessao()
    {
        $_SESSION['data'] = Array(
			'id' 	=> $this->id,
			'nome' 	=> $this->nome,
			'email' => $this->email,
			'senha' => $this->senha,
		);
    }

    /**
     *  Método que encerra a sessão
	 *
     *  @access private
     *  @name destroiSessao()
     */
    private function destroiSessao()
    {
        session_destroy();
    }

    /**
     *  Método que valida os dados recebidos pelo formulário
     *  @access private
     *  @name validaDados()
	 *	@return array
     */
    private function validaDados() {
		$retorno = Array(False, 'Preencha todos os campos!');
        if (parent::strRequire($this->email) || parent::strRequire($this->senha)) {
            try {
                $result = parent::executeQuery('SELECT * FROM usuarios WHERE 
                    email="'.$this->email.'" and 
                    senha="'.sha1($this->senha).'"');
            
                if ($result) {
                    if (parent::getNumRows($result) == 1) {
						$arrData = Array();
                        while ($row = parent::fetchResults($result)) {
                            $this->nome = $row['nome'];
                            $this->id = $row['id'];
                        }
                        $this->email = $this->email;
                        $this->senha = sha1($this->senha);

						$retorno[0] = True;
						$retorno[1] = 'Usu&aacute;rio autenticado!';
                    } else {
						$retorno[0] = False;
						$retorno[1] = 'Usu&aacute;rio ou senha incorretos!';
                    }
                } else {
					$retorno[0] = False;
					$retorno[1] = 'Erro ao validar os dados!';
                }
            } catch (Exception $e) {
				$retorno[0] = False;
				$retorno[1] = 'Erro ao validar os dados!';
            }
        }

		return $retorno;
    }
}

new Controle();

?>
