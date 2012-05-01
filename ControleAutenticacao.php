<?php

require_once "ControleGeral.php";

Class ControleAutenticacao extends ControleGeral {
	/**
     *  Método construtor da classe
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
		parent::executaAcao();
    }
    
    
    /**
     *  Método que valida a sessão do usuário imprimindo a resposta
	 *	em formato JSON
	 *
     *  @access public
     *  @name validaUsuario()
     *  @return JSON
     */
    public function validaUsuario() {
		$data = parent::pegaSessao();
		$resultado = Array(False, 'Nenhuma sess&atilde;o foi encontrada!');
		if ($data) {
			$sql = 'SELECT * FROM usuarios WHERE email="'.$data['email'].'" and senha="'.$data['senha'].'"'; 
            
            $result = parent::executeQuery($sql);

            if ($result) {
                if (parent::getNumRows($result) == 1){
                    $resultado[0] = True;
                    $resultado[1] = 'Usu&aacute;rio validado!';
                } else {
                    $resultado[0] = False;
                    $resultado[1] = 'E-mail ou Senha incorretos!';
				}
            } else { 
                $resultado[0] = False;
				$resultado[1] = 'Erro ao validar o usu&aacute;rio!';
            }
		}
		parent::retornaResultado($resultado);
    }
	
	/**
     *  Método que fecha a sessão aberta pelo usuário
     *  @access public
     *  @name fechaSessao()
     *  @return JSON
     */
    public function fechaSessao() {
        session_destroy();
		parent::retornaResultado(Array(True, 'A sess&atilde;o foi fechada com sucesso!'));
    }
}

new ControleAutenticacao();

?>
