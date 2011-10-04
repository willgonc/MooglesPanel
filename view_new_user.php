<?php 

require_once "LibInterface.php";
$libInterface = new LibIterface();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Adicionar usu&aacute;rio - Painel controle</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/dropdown.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                dropdown();
            });
        </script>
    </head>
    <body>
        <div class="geral">
            <?php echo $libInterface->getHtmlMenuPrincipal(); ?>
            <?php echo $libInterface->getHtmlCabecalho('Perfil'); ?>
            <?php echo $libInterface->getMessage(); ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <form action="SaveNewUser.php" method="post">
                        <table class="tw-ui-formulario">
                            <tbody>
                                <tr>
                                    <td>Nome *</td>
                                    <td><input type="text" class="input-text" size="30" name="nome" /></td>
                                    <td rowspan="5" valign="top">
                                        <div class="tw-ui-dicas">
                                            <p>( * ) Esses campos s&atilde;o obrigat&oacute;rios.</p>
                                            <p><b>E-mail:</b> deve ser utilizado um e-mail válido.</p>
                                            <p><b>Senha:</b> a senha deve ter no m&iacute;nimo 6 caracteres.</p>
                                            <p><b>Escolha uma senha forte, coloque caracteres mai&uacute;sculos, min&uacute;sculos, espaços e outros caracteres como * + - # $ @ e outros.</b></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>E-mail *</td>
                                    <td><input type="text" class="input-text" size="30" name="email"  /></td>
                                </tr>
                                <tr>
                                    <td>Senha *</td>
                                    <td><input type="password" class="input-text" size="30" name="senha" /></td>
                                </tr>
                                <tr>
                                    <td>Confirmar senha *</td>
                                    <td><input type="password" class="input-text" size="30" name="confirm_senha" /></td>
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
