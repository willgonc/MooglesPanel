<?php
require_once "connect_db.php";
$error = true;


// CRIA TABELA DE CONFIGURAÇÕES
try {
    $conf = mysql_query("CREATE TABLE configuracoes (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email_notificacao TEXT,
        nome_site TEXT
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

// CRIA TABELA DE USUARIOS
try {
    $conf = mysql_query("CREATE TABLE usuarios (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        senha TEXT NOT NULL,
        status TINYINT NOT NULL
    )");

    if ($conf) {
        print "A tabela usuarios foi criada!<br />";
    } else {
        print "Erro ao criar a tabela usuarios Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela usuarios Erro: ".$e."<br />";
    $error = false;
}

/*for ($i = 0; $i < 100; $i++){
    mysql_query("insert into usuarios (nome, email, senha, status) values ('teste".$i."','teste@gmail".$i.".com','098000980',1)");
}*/
try {
    $ins = mysql_query("insert into usuarios (nome, email, senha, status) values ('Administrador','admin@painel.com','".sha1(123456)."',1)");

    if ($ins) {
        print "O usu&aacute;rio admin foi criado!<br />";
    } else {
        print "Erro ao criar usu&aacute;rio Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar usu&aacute;rio Erro: ".$e."<br />";
    $error = false;
}


if ($error)
    echo '<meta http-equiv="refresh" content="3; url=resumo.php">';

mysql_close($conexao);
?>
