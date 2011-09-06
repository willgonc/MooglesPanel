<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$id             = $_POST['id'];
$nome           = $_POST['nome'];
$email          = $_POST['email'];
$senha          = $_POST['senha'];
$confirm_senha  = $_POST['confirm_senha'];

$flagErro = 1; // FRAG DE ERRO
$msg = ""; // ARMAZENA A MENSAGEM

if (!strRequire($nome) || !strRequire($email)){
    $flagErro = 0;
    $msg = "Preencha todos os campos obrigat&oacute;rios!";
}

if (!validaEmail($email)){
    $flagErro = 0;
    if ($msg == '')
        $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
}

$nome = htmlentities($nome, ENT_QUOTES, "UTF-8");

if (strRequire($senha) || strRequire($confirm_senha)){
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
    $senha = sha1($senha);
    
    if ($flagErro)
        $sql = "UPDATE usuarios SET nome='".$nome."', email='".$email."', senha='".$senha."' WHERE id=".$id;
} else {
    if ($flagErro)
        $sql = "UPDATE usuarios SET nome='".$nome."', email='".$email."' WHERE id=".$id;
}

if ($flagErro) {
    //$senha = addslashes($senha); // colocando barra invertida em determinados caracteres
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $update = mysql_query($sql);
        
        if ($update) {
            $ant_senha = $_SESSION['data']['senha'];

            session_destroy();
            session_start();

            if (strRequire($senha) || strRequire($confirm_senha)){
                $_SESSION['data'] = Array('email' => $email, 'senha' => $senha, 'nome' => $nome);
            } else {
                $_SESSION['data'] = Array('email' => $email, 'senha' => $ant_senha, 'nome' => $nome);
            }

            $flagErro = 1;
            if ($msg == '')
                $msg = "Seu perfil foi atualizado!";
        } else {
            $flagErro = 0;
            if ($msg == '')
                $msg = "Erro ao atualizar o perfil!";
        }
    } catch ( Exception $e ){
        $flagErro = 0;
        if ($msg == '')
            $msg = "Erro ao atualizar o perfil!";
    }
}

if ($flagErro == 0)
    header("Location: perfil.php?status=0&msg=".urlencode($msg));
elseif ($flagErro == 1)
    header("Location: perfil.php?status=1&msg=".urlencode($msg));

mysql_close($conexao);

?>

