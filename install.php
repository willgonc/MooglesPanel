<?php
require_once "Modelo.php";
$dataBase = new Modelo();
$error = true;

/* 
    CRIA TABELA DE POSTS 
*/
try {
    $posts = $dataBase->executeQuery("CREATE TABLE posts (
        id          BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        titulo      MEDIUMTEXT NOT NULL,
        texto       LONGTEXT,
        resumo      LONGTEXT,
        data        DATE NOT NULL,
        status      INT NOT NULL,
        categoria   BIGINT NOT NULL,
        tags        TEXT,
        url         TEXT NOT NULL,
        autor       BIGINT NOT NULL
    )");

    if ($posts) {
        print "A tabela posts foi criada!<br />";
    } else {
        print "Erro ao criar a tabela posts Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela posts Erro: ".$e."<br />";
    $error = false;
}

// CRIA A TABELA categorias
try {
    $categorias = mysql_query("CREATE TABLE categorias (
        id          BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome        TEXT NOT NULL,
        nome_html   TEXT NOT NULL,
        filhos      TEXT,
        categ_pai   INT NOT NULL
    )");

    if ($categorias) {
        print "A tabela categorias foi criada!<br />";
    } else {
        print "Erro ao criar a tabela categorias Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela categorias Erro: ".$e."<br />";
    $error = false;
}

// CATEGORIA PADRÃO
try {
    $categ = mysql_query("INSERT INTO categorias (nome, nome_html, filhos, categ_pai) 
                                VALUES ('Default','default', null, 1)");

    if ($categ) {
        print "A categoria padr&atilde;o foram inseridas!<br />";
    } else {
        print "Erro ao inserir categoria padr&atilde; Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao inserir categorias padr&atilde; Erro: ".$e."<br />";
    $error = false;
}


// CRIA TABELA DE CONFIGURAÇÕES
try {
    $conf = mysql_query("CREATE TABLE config (
        id          BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email       TEXT,
        descricao   TEXT,
        titulo      TEXT
    )");

    if ($conf) {
        print "A tabela config foi criada!<br />";
    } else {
        print "Erro ao criar a tabela config Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela config Erro: ".$e."<br />";
    $error = false;
}


// CONFIGURAÇÕES PADRÃO
try {
    $conf = mysql_query("INSERT INTO config (email, titulo) VALUES ('','')");

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
        senha TEXT NOT NULL
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

try {
    $ins = mysql_query("insert into usuarios (nome, email, senha) values ('Administrador','admin@painel.com','".sha1(123456)."')");

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

/******************************************************************************
 *
 *	Cria tabela arquivos
 *
 *****************************************************************************/
try {
    $conf = mysql_query("CREATE TABLE arquivos (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome TEXT NOT NULL,
        tipo TEXT NOT NULL,
		legenda TEXT NOT NULL,
        data DATETIME NOT NULL,
        dimensoes TEXT NOT NULL,
        titulo TEXT NOT NULL,
        textoAlternativo TEXT NOT NULL,
		descricao TEXT NOT NULL,
		url TEXT NOT NULL
    )");

    if ($conf) {
        print "A tabela arquivos foi criada!<br />";
    } else {
        print "Erro ao criar a tabela arquivos Erro: ".mysql_error()."<br />";
        $error = false;
    }
} catch ( Exception $e ){
    print "Erro ao criar a tabela arquivos Erro: ".$e."<br />";
    $error = false;
}

?>
