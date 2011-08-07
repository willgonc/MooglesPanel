<?php
require_once "connect_db.php";
$error = true;


// CRIA TABELA DE CONFIGURAÇÕES
try {
    $conf = mysql_query("CREATE TABLE configuracoes (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email_notificacao TEXT NOT NULL,
        nome_site TEXT NOT NULL
    )");

    if ($conf) {
        print "A tabela configuracoes foi criada!<br />";
    } else {
        print "Erro ao criar a tabela configuracoes Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela configuracoes Erro: ".$e."<br />";
    $error = false;
}


// CONFIGURAÇÕES PADRÃO
try {
    $conf = mysql_query("INSERT INTO configuracoes (email_notificacao, nome_site) VALUES ('','')");

    if ($conf) {
        print "A configuracoes padr&atilde;o foram inseridas!<br />";
    } else {
        print "Erro ao inserir configura&ccedil;&otilde;es padr&atilde; Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao inserir configura&ccedil;&otilde;es padr&atilde; Erro: ".$e."<br />";
    $error = false;
}



if ($error)
    echo '<meta http-equiv="refresh" content="3; url=resumo.php">';

mysql_close($conexao);
?>
