<?php

require_once "Modelo.php";

Class ControleAutenticacao extends Modelo {
	/**
     *  Método construtor da classe
	 *
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
        session_start();
		
		$acao = $this->getAcao();

		if ($acao == null)
			$this->retornaResultado(null);
		else
			$this->$acao();
    }
    
    /**
     *  Método para pegar a acao que o controle irá executar
	 *
     *  @access private
     *  @name getAcao()
     *  @return string | null Null caso nenhuma ação for requisitada
     */
	public function getAcao() {
		return isset($_GET['acao']) ? $_GET['acao'] : null;
	}

    /**
     *  Retorna um valor e formato json
	 *
     *  @access private
     *  @name retornaResultado()
     *  @return json
     */
	public function retornaResultado($resultado) {
		echo json_encode(Array('resultado' => $resultado));
	}
    
	/**
     *  Método para retornar a sessão aberta caso tenha uma
	 *
     *  @access private
     *  @name pegaSessao()
     *  @return array|null
     */
    public function pegaSessao() {
        return isset($_SESSION['data']) ? $_SESSION['data'] : null;
    }

    /**
     *  Método que valida a sessão do usuário imprimindo a resposta
	 *	em formato JSON
	 *
     *  @access private
     *  @name validaUsuario()
     *  @return JSON
     */
    private function validaUsuario() {
		$data = $this->pegaSessao();
		$resultado = False;
		if ($data) {
			$sql = 'SELECT * FROM usuarios WHERE 
                email="'.$data['email'].'" and 
                senha="'.$data['senha'].'" and 
                status=1';
            
            /**
			 *	Executa a query
			 */
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
}

new ControleAutenticacao();

?>
