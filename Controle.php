<?php

require_once "Modelo.php";

Class Controle Extends Modelo {
	/**
	 *	Atributo para guardar o nome do método a ser executado
	 *
	 */
	private $acao;

	/**
     *  Método construtor da classe
	 *
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
        
		$this->getAcao();

		if ($this->acao == null) {
			$this->retornaResultado(null);
		} else {
			$this->$this->acao();
		}
    }

    /**
     *  Método para pegar a acao que o controle irá executar
	 *
     *  @access private
     *  @name getAcao()
     *  @return string | null Null caso nenhuma ação for requisitada
     */
	private function getAcao() {
		return isset($_GET['acao']) ? $_GET['acao'] : null;
	}

	private function retornaResultado($resultado) {
		echo json_encode(Array('resultado' => $resultado));
	}

    /**
     *  Método que valida um email
	 *	@param string $email
     *  @access publico
     *  @name validaEmail()
     *  @return bool
     */
    public function validaEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
            return 1;
        else
            return 0;
    }

    /**
     *  Método que valida uma string, se ela é vazia ou não
	 *	@param string $str
     *  @access publico
     *  @name strRequire()
     *  @return bool
     */
    public function strRequire($str)
    {
        // removendo espaços em branco
        $str = trim($str);
        if (strlen($str) == 0 || empty($str) || $str == '')
            return 0;
        else 
            return 1;
    }
    

    /**
     *  Método que valida a sessão do usuário
	 *
     *  @param array
     *  @access private
     *  @name validaUsuario()
     *  @return bool
     */
    private function validaUsuario($data) {
		$session = $this->pegaSessao();
		$resultado = False;

		if ($session) {
			$sql = 'SELECT * FROM usuarios WHERE 
                email="'.$data['email'].'" and 
                senha="'.$data['senha'].'" and 
                status=1';
            
            // consulta na base os dados
            $result = parent::executeQuery($sql);

            if ($result) {
                if (parent::getNumRows($result) == 1)
                    $resultado = True;
                else
                    $resultado = False;
            } else { 
                $resultado = False;
            }

			$this->retornaResultado($resultado);
		} else {
			$this->retornaResultado($resultado);
		}
    }

    /**
     *  Método para retornar a sessão aberta caso tenha uma
	 *
     *  @access private
     *  @name pegaSessao()
     *  @return array|null
     */
    private function pegaSessao()
    {
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : null;
    }
}


?>
