<?php

require_once "connect_db.php";

$resultado = mysql_query("SELECT * FROM configuracoes");

if ($resultado) {
    if (mysql_num_rows($resultado) == 1) {
        $email_notificacao = mysql_result($resultado, 0, "email_notificacao");
        $nome_site = mysql_result($resultado, 0, "nome_site");
    } else {
        $email_notificacao = '';
    }
} else {
    print "Erro ao pegar as configura&ccedil;&otilde;es;es Erro: ".mysql_error();
    exit;
}

mysql_close($conexao);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />
    </head>
    <body>
        <?php require_once "menu.php"; ?>
        <div class="tw-ui-bar-page">
            <h2 class="tw-ui-name-page">
                Configura&ccedil;&otilde;es
            </h2>
        </div>
        <div class="tw-ui-content">
            <form action="insert_configuracoes.php" method="post">
                <table class="tw-ui-formulario">
                    <tbody>
                        <tr>
                            <td>Nome do site</td>
                            <td><input type="text" class="input-text" name="nome_site" size="30" value="<?php print $nome_site; ?>" /></td>
                        </tr>
                        <tr>
                            <td>E-mail para notifica&ccedil;&otilde;es</td>
                            <td><input type="text" class="input-text" name="email_notificacao" size="30" value="<?php print $email_notificacao; ?>" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="input-submit" value="Salvar" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>
