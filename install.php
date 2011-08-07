<?php
    require_once "connect_db.php";

    // CRIA TABELA DE CONFIGURAÇÕES
    try {
        $conf = mysql_query("CREATE TABLE configuracoes (
            id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            email_notificacao TEXT NOT NULL
        )");

        if ($conf)
            print "A tabela configuracoes foi cria!<br />";
        else
            print "Erro ao criar a tabela configuracoes Erro: ".mysql_error()."<br />";
    } catch ( Exception $e ){
        print "Erro ao criar a tabela configuracoes Erro: ".$e."<br />";
    }

    mysql_close($conexao);
?>
