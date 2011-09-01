<?php
    
require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

// PEGANDO VALORES
$email      = $_POST['email'];
$titulo     = $_POST['titulo'];    
$descricao  = $_POST['descricao'];    


$fragErro = true; // FRAG DE ERRO
$msg = ""; // ARMAZENA A MENSAGEM


// VALIDACOES
if (!empty($email)){
    if (!validaEmail($email)){
        $fragErro = false;
        $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
    }
}

if ($fragErro) {
    // TRATANDO OS DADOS PARA O UPDATE 
    $titulo = htmlentities($titulo, ENT_QUOTES, "UTF-8");
    $descricao = htmlentities($descricao, ENT_QUOTES, "UTF-8");
    try {
        // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
        $update = mysql_query("UPDATE config SET 
                    email='".$email."',
                    descricao='".$descricao."',
                    titulo='".$titulo."'
                ");

        if ($update){
            $flagErro = true;
            if ($msg == '')
                $msg='As configura&ccedil;&otilde;es foram atualizadas com sucesso!';
        } else {
            $flagErro = false;
            if ($msg == '')
                $msg='N&atilde;o foi poss&iacute;vel atualizar as configura&ccedil;&otilde;es!';
        }

    } catch ( Exception $e ){
        $flagErro = false;
        if ($msg == '')
            $msg='N&atilde;o foi poss&iacute;vel atualizar as configura&ccedil;&otilde;es!';
    }
} 

if ($flagErro == false)
    header("Location: config.php?status=0&msg=".urlencode($msg));
else
    header("Location: config.php?status=1&msg=".urlencode($msg));

mysql_close($conexao);
    
?>
