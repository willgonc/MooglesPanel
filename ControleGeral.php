<?php
/**
 *	Classe responsável pelas funções de controle geréricas usadas
 *		pela maioria dos módulos
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

require_once "Modelo.php";

Class Controle Extends Modelo {

	/**
     *  Método construtor da classe
	 *
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
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
     *  Método que valida um email
	 *	@param string $email
     *  @access publico
     *  @name validaEmail()
     *  @return bool
     */
    public function validaEmail($email) {
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
    public function strRequire($str) {
        // removendo espaços em branco
        $str = trim($str);
        if (strlen($str) == 0 || empty($str) || $str == '')
            return 0;
        else 
            return 1;
    }
    

    /**
     *  Método para retornar a sessão aberta caso tenha uma
	 *
     *  @access private
     *  @name pegaSessao()
     *  @return array|null
     */
    public function pegaSessao() {
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : null;
    }
    
}

new Controle();

?>
