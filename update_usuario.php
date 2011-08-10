<?php

require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

$id             = $_POST['id'];
$nome           = $_POST['nome'];
$email          = $_POST['email'];
$senha          = $_POST['senha'];
$confirm_senha  = $_POST['confirm_senha'];

$fragErro = true; // FRAG DE ERRO
$mensagem = ""; // ARMAZENA A MENSAGEM

if (!strRequire($nome) || !strRequire($email) || !strRequire($senha) || !strRequire($confirm_senha)){
    $fragErro = false;
    $mensagem = "Preencha todos os campos do formul&aacute;rio!";
}

if ($senha != $confirm_senha){
    $fragErro = false;
    $mensagem = "Confirme a senha corretamente!";
}

if (!validaEmail($email)){
    $fragErro = false;
    $mensagem = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
}

if ($senha < 6){
    $fragErro = false;
    $mensagem = "A senha deve ter no m&iacute;nimo 6 caracteres!";
}

if ($fragErro) {
    //$senha = addslashes($senha); // colocando barra invertida em determinados caracteres
    $senha = sha1($senha);

    $nome = htmlentities($nome, ENT_QUOTES, "UTF-8");
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $insert = mysql_query("UPDATE usuarios SET 
                    nome='".$nome."', email='".$email."', senha='".$senha."' 
                    WHERE id=".$id);
        
        if ($insert) {
            header("Location: perfil.php");
        } else {
            print "erro: ".mysql_error();
        }
    } catch ( Exception $e ){
        print "erro: ".$e;
    }
} else {
    print "Erro de validacao";
}
mysql_close($conexao);

?>

