<?php

/**
 *	Classe responsável pelas funçoes de manipulação do banco de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class Validation
{
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
}

?>
