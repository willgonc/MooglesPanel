<?php
require_once "connect_db.php";
require_once "logged.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script> 
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initLogin();
            });
        </script>
    </head>
    <body>
        <div class="geral">
            <form action="logging.php" method="post">
                <table class="tw-ui-formulario-login">
                    <tbody>
                        <tr>
                            <td id="msgRespota"></td>
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
                            <td>
                                <input type="button" id="btn-submit-login" class="input-button" value="Entrar" />
                                <img src="./imagens/load.gif" class="load" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>

<?php mysql_close($conexao); ?>