<?php
    
require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

// PEGANDO VALORES
$email_notificacao  = $_POST['email_notificacao'];    
$nome_site          = $_POST['nome_site'];    


$fragErro = true; // FRAG DE ERRO
$mensagem = ""; // ARMAZENA A MENSAGEM


// VALIDACOES
if (!empty($email_notificacao)){
    if (!validaEmail($email_notificacao)){
        $fragErro = false;
        $mensagem = "O e-mail para notifica&ccedil;&otilde;es de coment&aacute;rios n&atilde;o &eacute; v&aacute;lido!";
    }
}


// TRATANDO OS DADOS PARA A INSERCAO
$nome_site = htmlentities($nome_site, ENT_QUOTES, "UTF-8");

if ($fragErro) {
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $update = mysql_query("UPDATE configuracoes SET 
                    email_notificacao='".$email_notificacao."',
                    nome_site='".$nome_site."'
                ");
        if ($update) {
            header("Location: configuracoes.php");
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
