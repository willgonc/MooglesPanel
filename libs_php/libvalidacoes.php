<?php

/*
    Função: validaEmail
    Descrição: Esta função valida um email 
    Parâmentro: String
    Retorno: true ou false
*/
function validaEmail ($email)
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    else
        return false;
}

?>
