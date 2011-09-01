<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php"; 

$resultado = mysql_query("SELECT * FROM config");

if ($resultado) {
    if (mysql_num_rows($resultado) == 1) {
        $email      = mysql_result($resultado, 0, "email");
        $descricao  = mysql_result($resultado, 0, "descricao");
        $titulo     = mysql_result($resultado, 0, "titulo");
    } else {
        $email_notificacao = '';
        $titulo = '';
    }
} else {
    print "Erro ao pegar as configura&ccedil;&otilde;es;es Erro: ".mysql_error();
    exit;
}

mysql_close($conexao);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="shortcut icon" href="imagens/favicon.ico"/>

        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                $('.tw-ui-menu-principal .4').addClass('active-menu');
            });
        </script>
    </head>
    <body>
        <div class="tw-ui-geral">
            <?php printMenuPrincipal();?>

            <?php 
                printCabecalho('Configurações'); 
                print '<div class="tw-ui-mensagem">'.(isset($_GET['msg'])?$_GET['msg']:'').'</div>';
            ?>
                <div class="tw-ui-content">
                    <div class="tw-ui-content-mod">
                        <form action="save_config.php" method="post">
                            <table class="tw-ui-formulario">
                                <tbody>
                                    <tr>
                                        <td>T&iacute;tulo do site</td>
                                        <td><input type="text" class="input-text" name="titulo" size="40" value="<?php print $titulo; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Descri&ccedil;&atilde;o sobre o site</td>
                                        <td><input type="text" class="input-text" name="descricao" size="40" value="<?php print $descricao; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>E-mail para notifica&ccedil;&otilde;es</td>
                                        <td><input type="text" class="input-text" name="email" size="40" value="<?php print $email; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" class="input-submit" value="Salvar" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
    </body>
</html>
