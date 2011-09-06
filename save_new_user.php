<?php

require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$nome           = $_POST['nome'];
$email          = $_POST['email'];
$senha          = $_POST['senha'];
$confirm_senha  = $_POST['confirm_senha'];

$flagErro = 1; // FRAG DE ERRO
$msg = ""; // ARMAZENA A MENSAGEM

if (!strRequire($nome) || !strRequire($email) || !strRequire($senha) || !strRequire($confirm_senha)){
    $flagErro = 0;
    $msg = "Preencha todos os campos do formul&aacute;rio!";
}

if (!validaEmail($email)){
    $flagErro = 0;
    if ($msg == '')
        $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
}

if ($senha != $confirm_senha){
    $flagErro = 0;
    if ($msg == '')
       $msg = "Confirme a senha corretamente!";
}

if (strlen($senha) < 6){
    $flagErro = 0;
    if ($msg == '')
        $msg = "A senha deve ter no m&iacute;nimo 6 caracteres!";
}


try {
    // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
    $result = mysql_query("SELECT * FROM usuarios WHERE email='$email'");
    
    if ($result) {
        if (mysql_num_rows($result) >= 1){
            $flagErro = 0;
            if ($msg == '')
                $msg = "Este e-mail j&aacute; est&aacute; cadastrado!";
        }
    } else {
        $flagErro = 0;
        if ($msg == '')
            $msg = "Erro ao cadastrar usuário!";
    }
} catch ( Exception $e ){
    $flagErro = 0;
    if ($msg == '')
        $msg = "Erro ao cadastrar usuário!";
}


if ($flagErro) {
    $senha = sha1($senha);

    $nome = htmlentities($nome, ENT_QUOTES, "UTF-8");
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $insert = mysql_query("INSERT INTO usuarios (nome, email, senha, status) 
                    VALUES ('".$nome."','".$email."', '".$senha."', 0)");
        
        if ($insert) {
            $flagErro = 1; 
            if ($msg == '')
                $msg = "O usu&aacute;rio foi adicionado!";
        } else {
            $flagErro = 0;
            if ($msg == '')
                $msg = "Erro ao adicionar o usu&aacute;rio!";
        }
    } catch ( Exception $e ){
        $flagErro = 0;
        if ($msg == '')
            $msg = "Erro ao adicionar o usu&aacute;rio!";
    }
}


if ($flagErro == 0)
    header("Location: new_user.php?status=0&msg=".urlencode($msg));
elseif ($flagErro == 1)
    header("Location: new_user.php?status=1&msg=".urlencode($msg));


mysql_close($conexao);

?>
