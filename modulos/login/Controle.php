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
     *  Atributo que armazena a instancia da Classe DataBase
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;
   
    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct() { 
		parent::__construct();
		$acao = parent::getAcao();

		if ($acao == null)
			parent::retornaResultado(null);
		else
			$this->$acao();
	}




	private function autenticaUsuario(){
        session_start();

		$this->pegaDados();

		$data = $this->validateData();

        if ($data) {
            $this->createSession($data);
            echo json_encode(Array("resultado" => True));
        } else {
            $this->destroySession();
            echo json_encode(Array("resultado" => False));
        }
		parent::closeConnect();

	}

    /**
     *  Método que armazena nos atributos os dados recebidos por post
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
	 *	@param array $data
     *  @access private
     *  @name createSession()
     */
    private function createSession($data)
    {
        $_SESSION['data'] = $data;
    }

    /**
     *  Método que encerra a sessão
     *  @access private
     *  @name destroySession()
     */
    private function destroySession()
    {
        session_destroy();
    }

    /**
     *  Método que valida os dados recebidos pelo formulário
     *  @access private
     *  @name validateData()
	 *	@return bool
     */
    private function validateData() {
        if (parent::strRequire($this->email) || parent::strRequire($this->senha)) {
            try {
                $result = parent::executeQuery('SELECT * FROM usuarios WHERE 
                    email="'.$this->email.'" and 
                    senha="'.sha1($this->senha).'" and 
                    status=1');
            
                if ($result) {
                    if (parent::getNumRows($result) == 1) {
						$arrData = Array();
                        while ($row = parent::fetchResults($result)) {
                            $arrData['nome'] = $row['nome'];
                            $arrData['id'] = $row['id'];
                        }
                        $arrData['email'] = $this->email;
                        $arrData['senha'] = sha1($this->senha);

                        return $arrData;
                    } else {
                        return False;
                    }
                } else {
                    return False;
                }
            } catch (Exception $e) {
                return False;
            }
        } else {
            return False;
        }
    }
}

new Controle();

?>
