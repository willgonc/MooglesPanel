<?php
    
require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

// PEGANDO VALORES
$email_notificacao = $_POST['email_notificacao'];    

$fragErro = true; // FRAG DE ERRO
$mensagem = ""; // ARMAZENA A MENSAGEM


if (!validaEmail($email_notificacao)){
    $fragErro = false;
    $mensagem = "O e-mail para notifica&ccedil;&otilde;es de coment&aacute;rios n&atilde;o &eacute; v&aacute;lido!";
}

if ($fragErro) {
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $update = mysql_query("UPDATE configuracoes SET email_notificacao='".$email_notificacao."'");
        if ($update) {
            print "atualizado";
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
