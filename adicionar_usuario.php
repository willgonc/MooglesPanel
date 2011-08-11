<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />
        
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                $('#item-menu-usuarios').addClass('tw-ui-atual');
            });
        </script>
    </head>
    <body>
        <div class="geral">
            <?php require_once "menu.php"; ?>
            <div class="tw-ui-bar-page">
                <h2 class="tw-ui-name-page">
                    Adicionar novo usu&aacute;rio
                </h2>
            </div>
            <div class="tw-ui-content">
                <div class="tw-ui-menu-modulo">
                    <ul>
                        <li><a href="usuarios.php">Mostrar todos</a></li>
                        <li><a href="adicionar_usuario.php">Adicionar novo</a></li>
                        <li><a href="perfil.php">Seu perfil</a></li>
                    </ul>
                </div>
                <form action="insert_usuario.php" method="post">
                    <table class="tw-ui-formulario">
                        <tbody>
                            <tr>
                                <td>Nome *</td>
                                <td><input type="text" class="input-text" size="30" name="nome" value="<?php print ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td>E-mail *</td>
                                <td><input type="text" class="input-text" size="30" name="email" value="<?php print ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Senha *</td>
                                <td><input type="password" class="input-text" size="30" name="senha" value="<?php print ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Confirmar senha *</td>
                                <td><input type="password" class="input-text" size="30" name="confirm_senha" value="<?php print ''; ?>" /></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>( * ) Esses campos s&atilde;o obrigat&oacute;rios</td>
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
    </body>
</html>

