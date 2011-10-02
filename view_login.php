<?php 

require_once "LibInterface.php";
$libInterface = new LibIterface();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Login - Painel controle</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <div class="geral">
            <form action="Logging.php" method="post">
                <table class="tw-ui-formulario-login">
                    <tbody>
                        <tr>
                            <td><h2>Login</h2></td>
                        </tr>
                        <tr>
                            <td><?php echo $libInterface->getMessage(); ?></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                        </tr>
                        <tr>
                            <td><input type="text" class="input-text" size="30" name="email" /></td>
                        </tr>
                        <tr>
                            <td>Senha</td>
                        </tr>
                        <tr>
                            <td><input type="password" class="input-text" size="30" name="senha" /></td>
                        </tr>
                        <tr>
                            <td id="msgRespota"></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" id="btn-submit-login" class="input-button" value="Entrar" />
                                <img src="./imagens/load.gif" class="load" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>

