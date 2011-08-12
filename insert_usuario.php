<?php

require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

$nome           = $_POST['nome'];
$email          = $_POST['email'];
$senha          = $_POST['senha'];
$confirm_senha  = $_POST['confirm_senha'];

$fragErro = true; // FRAG DE ERRO
$mensagem = ""; // ARMAZENA A MENSAGEM

if (strRequire($nome) == false || !strRequire($email) || !strRequire($senha) || !strRequire($confirm_senha)){
    $fragErro = false;
    $mensagem = "Preencha todos os campos do formul&aacute;rio!";
}

if (!validaEmail($email)){
    $fragErro = false;
    if (strlen($mensagem) == 0)
        $mensagem = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
}

if ($senha != $confirm_senha){
    $fragErro = false;
    if (strlen($mensagem) == 0)
       $mensagem = "Confirme a senha corretamente!";
}

if (strlen($senha) < 6){
    $fragErro = false;
    if (strlen($mensagem) == 0)
        $mensagem = "A senha deve ter no m&iacute;nimo 6 caracteres!";
}


try {
    // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
    $result = mysql_query("SELECT * FROM usuarios WHERE email='$email'");
    
    if ($result) {
        if (mysql_num_rows($result) >= 1){
            $fragErro = false;
            if (strlen($mensagem) == 0)
                $mensagem = "Este e-mail j&aacute; est&aacute; cadastrado!";
        }
    } else {
        $fragErro = false;
        if (strlen($mensagem) == 0)
            $mensagem = "Erro ao cadastrar usuário!";
    }
} catch ( Exception $e ){
    $fragErro = false;
    if (strlen($mensagem) == 0)
        $mensagem = "Erro ao cadastrar usuário!";
}


if ($fragErro) {
    //$senha = addslashes($senha); // colocando barra invertida em determinados caracteres
    $senha = sha1($senha);

    $nome = htmlentities($nome, ENT_QUOTES, "UTF-8");
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $insert = mysql_query("INSERT INTO usuarios (nome, email, senha, status) 
                    VALUES ('".$nome."','".$email."', '".$senha."', 0)");
        
        if ($insert) {
            header('Location: adicionar_usuario.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="okMsg">O usu&aacute;rio foi adicionado!</p>'));
        } else {
            header('Location: adicionar_usuario.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="errorMsg">Erro ao adicionar o usu&aacute;rio!</p>'));
        }
    } catch ( Exception $e ){
        header('Location: adicionar_usuario.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="errorMsg">Erro ao adicionar o usu&aacute;rio!</p>'));
    }
} else {
    header('Location: adicionar_usuario.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="errorMsg">'.$mensagem.'</p>'));
}
mysql_close($conexao);

?>
