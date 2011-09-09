<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php";
try {
    $result = mysql_query("SELECT * FROM usuarios WHERE email='".$_SESSION['data']['email']."'");
    if ($result){
        $id_user = mysql_result($result, 0, 'id');
    }
} catch (Exception $e) {

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
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initMenu();
            });
        </script>
    </head>
    <body>
        <div class="tw-ui-geral">
            <?php 
                printMenuPrincipal();
                printCabecalho('Seu perfil');
                printMsg();
            ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <form action="save_perfil.php" method="post">
                        <table class="tw-ui-formulario">
                            <tbody>
                                <tr>
                                    <td>Nome *</td>
                                    <td>
                                        <input type="text" class="input-text" size="30" name="nome" value="<?php print $data['nome']; ?>" />
                                        <input type="hidden" name="id" value="<?php print $id_user; ?>" />
                                    </td>
                                    <td rowspan="6" valign="top">
                                        <div class="tw-ui-dicas">
                                            <p>( * ) Esses campos s&atilde;o obrigat&oacute;rios.</p>
                                            <p><b>E-mail:</b> deve ser utilizado um e-mail válido.</p>
                                            <p><b>Senha:</b> a senha deve ter no m&iacute;nimo 6 caracteres.</p>
                                            <p style="color: red">Para alterar a senha preencha o campo senha e confirme novamente a senha. Se caso n&atilde;o queira alterar deixer em branco.</p>
                                            <p><b>Escolha uma senha forte, coloque caracteres mai&uacute;sculos, min&uacute;sculos, espaços e outros caracteres como * + - # $ @ e outros.</b></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>E-mail *</td>
                                    <td><input type="text" class="input-text" size="30" name="email" value="<?php print $data['email']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Senha</td>
                                    <td><input type="password" class="input-text" size="30" name="senha" /></td>
                                </tr>
                                <tr>
                                    <td>Confirmar senha</td>
                                    <td><input type="password" class="input-text" size="30" name="confirm_senha"/></td>
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


