<?php

Class Validation
{
    /**
     *  Função: validaEmail
     *  Descrição: Esta função valida um email 
     *  Parâmentro: String
     *  Retorno: true ou false
     */
    public function validaEmail ($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    /*
     *  Função: strRequire
     *  Descrição: Esta função verifica se uma string que está sendo
     *  requerida tem algum caracter fora os espaços em branco
     *  Parâmentro: String
     *  Retorno: true ou false
     */
    public function strRequire($str)
    {
        // removendo espaços em branco
        $str = trim($str);
        if (strlen($str) == 0 || empty($str))
            return false;
        else 
            return true;
    }
}
?>
