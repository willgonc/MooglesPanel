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
                Usu&aacute;rios
            </h2>
            <div class="tw-ui-menu-modulo">
                <ul>
                    <li><a href="usuarios.php">Mostrar todos</a></li>
                    <li><a href="adicionar_usuario.php">Adicionar novo</a></li>
                </ul>
            </div>
        </div>
        <div class="tw-ui-content">
            <form action="insert_usuario.php" method="post">
                <table class="tw-ui-formulario">
                    <tbody>
                        <tr>
                            <td>Nome</td>
                            <td><input type="text" class="input-text" size="30" name="nome" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td><input type="text" class="input-text" size="30" name="email" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Senha</td>
                            <td><input type="password" class="input-text" size="30" name="senha" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Confirmar senha</td>
                            <td><input type="password" class="input-text" size="30" name="confirm_senha" value="<?php print ''; ?>" /></td>
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


