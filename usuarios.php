<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/tw-ui-painel.css" />
    </head>
    <body>
        <?php require_once "menu.php"; ?>
        <div class="tw-ui-bar-page">
            <h2 class="tw-ui-name-page">
                Configura&ccedil;&otilde;es
            </h2>
            <div class="tw-ui-menu-modulo">
                <ul>
                    <li><a href="#">Mostrar todos</a></li>
                    <li><a href="#">Adicionar novo</a></li>
                    <li><a href="#">Seu perfil</a></li>
                    <li>
                        <form action="buscar_usuarios">
                            <input type="text" name="str_busca" />
                            <input type="submit" value="Buscar" />
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tw-ui-content">
            <div class="tw-ui-conteiner-usuarios">
                
            </div>
            <form action="insert_usuario.php" method="post">
                <table>
                    <tbody>
                        <tr>
                            <td>Nome</td>
                            <td><input type="text" name="nome" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td><input type="text" name="email" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Senha</td>
                            <td><input type="text" name="senha" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Confirmar senha</td>
                            <td><input type="text" name="confirm_senha" value="<?php print ''; ?>" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Salvar" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>
