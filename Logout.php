<?php
/**
 *	Classe responsável por encerrar a sessão do usuário
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class Logout
{
    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
        session_start();
        session_destroy();
        header('Location: login.php');
    }
}

new Logout();

?>
