<?php
require_once "connect_db.php";
require_once "lib.php";
session_start();


$id             = $_POST['id'];
$nome           = $_POST['nome'];
$email          = $_POST['email'];
$senha          = $_POST['senha'];
$confirm_senha  = $_POST['confirm_senha'];

$fragErro = true; // FRAG DE ERRO
$mensagem = ""; // ARMAZENA A MENSAGEM

if (!strRequire($nome) || !strRequire($email)){
    $fragErro = false;
    $mensagem = "Preencha todos os campos obrigat&oacute;rios!";
}

if (!validaEmail($email)){
    $fragErro = false;
    if (strlen($mensagem) == 0)
        $mensagem = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
}

$nome = htmlentities($nome, ENT_QUOTES, "UTF-8");

if (strRequire($senha) || strRequire($confirm_senha)){
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
    $senha = sha1($senha);
    
    if ($fragErro)
        $sql = "UPDATE usuarios SET nome='".$nome."', email='".$email."', senha='".$senha."' WHERE id=".$id;
} else {
    if ($fragErro)
        $sql = "UPDATE usuarios SET nome='".$nome."', email='".$email."' WHERE id=".$id;
}

if ($fragErro) {
    //$senha = addslashes($senha); // colocando barra invertida em determinados caracteres
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $update = mysql_query($sql);
        
        if ($update) {
            if (strRequire($senha) || strRequire($confirm_senha)){
                session_destroy();
                session_start();
                $_SESSION['data'] = Array('email' => $email, 'senha' => $senha);
            } else {
                $_SESSION['data']['email'] = $email;
            }
            
            if (strlen($mensagem) == 0)
                $mensagem = "Seu perfil foi atualizado!";
        } else {
            $fragErro = false;
            if (strlen($mensagem) == 0)
                $mensagem = "Erro ao atualizar o perfil!";
        }
    } catch ( Exception $e ){
        $fragErro = false;
        if (strlen($mensagem) == 0)
            $mensagem = "Erro ao atualizar o perfil!";
    }
}

if ($flagErro == false)
    header("Location: perfil.php?status=0&msg=".urlencode($msg));
else
    header("Location: perfil.php?status=1&msg=".urlencode($msg));

mysql_close($conexao);

?>

