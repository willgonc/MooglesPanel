<?php

require_once "Config.php";
require_once "DataBase.php";


$dataBase = new DataBase();
echo $dataBase->getUser();
/*require_once "logged.php";

$logged = new Logged();
//$logged->validateUser($dataBase->getLink());

closeConnect($dataBase->getLink());
*/
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
            <table class="tw-ui-formulario-login">
                <tbody>
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
                            <input type="button" id="btn-submit-login" class="input-button" value="Entrar" />
                            <img src="./imagens/load.gif" class="load" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
