<?php
/**
 *	Classe responsável pelas funções de controle usadas pela maioria dos módulos
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

require_once "Modelo.php";

Class ControleGeral extends Modelo {
	/**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
    }

    /**
     *  Método para pegar a acao que o controle irá executar
     *  @access public
     *  @name pegaAcao()
     *  @return string | False
     */
	public function pegaAcao() {
		if (isset($_GET['acao']))
			return $_GET['acao'];
		else if (isset($_POST['acao']))
			return $_POST['acao'];
		else
			return False;
	}

    /**
     *  Método que executa uma ação passada por parâmetro
     *  @access public
     *  @name executaAcao()
     */
	public function executaAcao(){
		$acao = $this->pegaAcao();

		if ($acao)
			$this->$acao();
		else
			$this->retornaResultado(Array(False,'A&ccedil;&atilde;o n&atilde;o encontrada'));
	}

    /**
     *  Retorna um valor e formato json
     *  @access private
     *  @name retornaResultado()
     */
	public function retornaResultado($resultado) {
		echo json_encode($resultado);
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
            return True;
        else
            return False;
    }


	public function getDirMods(){

	}

    /**
     *  Método que valida uma string requerida
	 *	@param string $str
     *  @access public
     *  @name strRequire()
     *  @return bool
     */
    public function strRequire($str) {
        $str = trim($str);
        if (strlen($str) == 0 || empty($str) || $str == '')
            return False;
        else 
            return True;
    }
    
    /**
     *  Método para retornar a sessão aberta caso tenha uma
     *  @access public
     *  @name pegaSessao()
     *  @return array|false
     */
    public function pegaSessao() {
        return isset($_SESSION['data']) ? $_SESSION['data'] : False;
    }
}

new ControleGeral();

?>
