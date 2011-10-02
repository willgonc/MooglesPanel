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
            return 1;
        else
            return 0;
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
        if (strlen($str) == 0 || empty($str) || $str == '')
            return 0;
        else 
            return 1;
    }

    public function antiInjection($val) {
        $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $sql);
        $sql = trim($sql); 
        $sql = strip_tags($sql);
        $sql = addslashes($sql);
        return $sql;
    }
}
?>
