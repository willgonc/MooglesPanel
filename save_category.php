<?php
require_once "connect_db.php";
require_once "lib.php";

$nome = $_POST['nome'];

$flagErro = 1; // FRAG DE ERRO
$msg = ""; // ARMAZENA A MENSAGEM

if (!strRequire($nome)){
    $flagErro = 0;
    $msg = "Preencha o nome da categoria!";
} else {
    $flagErro = 1;
    $msg = "Categoria ok!";
}


if ($flagErro)
    echo 'categories.php?msg='.urlencode($msg).'&status=1';
else
    echo 'categories.php?msg='.urlencode($msg).'&status=0';

?>
