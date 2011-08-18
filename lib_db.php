<?php

function getUsuarioLogado(){
    $email = $_SESSION['data']['email'];
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $result = mysql_query("SELECT * FROM usuarios WHERE email='$email'");
        
        if ($result) {
            if (mysql_num_rows($result) == 1){
                return Array(
                    'id' => mysql_result($result, 0, 'id'),
                    'nome' => mysql_result($result, 0, 'nome'),
                    'email' => mysql_result($result, 0, 'email')
                );
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch ( Exception $e ){
        return false;
    }

}

?>
