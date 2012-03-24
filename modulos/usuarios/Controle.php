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
		$acao = parent::getAcao();

		if ($acao == null)
			parent::retornaResultado(null);
		else
			$this->$acao();
	}

	private function pegaDados(){
		$this->nome = $_GET['nome'];
		$this->email = $_GET['email'];
		$this->senha = $_GET['senha'];
		$this->confirmaSenha = $_GET['confirmaSenha'];
		
	}

	private function adicionaUsuario(){
		$this->pegaDados();
        $data = $this->validaDados();
        if ($data[0]) {
            $checkmail = $this->verificaEmailCadastrado();
            if ($checkmail[0]){

			} else {

			}
		} else {
			parent::retornaResultado(Array('retorno' => $data[0], 'mensagem' => $data[1]));
		}
	}
    
	/**
     *  Método que valida os dados para persitência
     *  @access private
     *  @name validateData()
     */
    private function validaDados() {
        $flagErro = True;
        $msg = "";

        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email) || !parent::strRequire($this->senha) || !parent::strRequire($this->confirmaSenha)) {
            $flagErro = False;
            $msg = "Preencha todos os campos do formul&aacute;rio!";
        } else if (!parent::validaEmail($this->email)) {
            $flagErro = False;
            if ($msg == '')
                $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if ($this->senha != $this->confirmaSenha) {
            $flagErro = False;
            if ($msg == '')
               $msg = "Confirme a senha corretamente!";
        } else if (strlen($this->senha) < 6) {
            $flagErro = False;
            if ($msg == '')
                $msg = "A senha deve ter no m&iacute;nimo 6 caracteres!";
        }
        return Array($flagErro, $msg);
    }
    
	
	public function verificaEmailCadastrado()
    {
        $flagErro = True;
        $msg = '';

        try {
            $result = parent::executeQuery("SELECT * FROM usuarios WHERE email='".$this->email."'");
            if ($result) {
                if (parent::getNumRows($result) >= 1) {
                    $flagErro = False;
                    if ($msg == '')
                        $msg = "Este e-mail j&aacute; est&aacute; cadastrado!";
                } else {
                    $flagErro = True;
                    if ($msg == '')
                        $msg = "";
                }
            } else {
                $flagErro = False;
                if ($msg == '')
                    $msg = "Erro ao cadastrar usuário!";
            }
        } catch ( Exception $e ) {
            $flagErro = False;
            if ($msg == '')
                $msg = "Erro ao cadastrar usuário!";
        }
        return Array($flagErro, $msg);
    }
}

new Controle();

?>
