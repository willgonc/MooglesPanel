<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php"; 
require_once "lib_db.php"; 

$data = getUsuarioLogado();

if (!$data)
    print "teste";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                $('.tw-ui-menu-principal .3').addClass('active-menu');
            });
        </script>
    </head>
    <body>
        <?php 
            printCabecalho('Seu perfil');
        print '<div class="tw-ui-mensagem">'.(isset($_GET['msg'])?$_GET['msg']:'').'</div>';
        ?>
        <div class="tw-ui-content">
            <?php printMenu(); ?>
            <div class="tw-ui-content-mod">
                <?php mountMenuModUsuarios(); ?>
                <form action="insert_usuario.php" method="post">
                    <table class="tw-ui-formulario">
                        <tbody>
                            <tr>
                                <td>Nome *</td>
                                <td>
                                    <input type="text" class="input-text" size="30" name="nome" value="<?php print $data['nome']; ?>" />
                                    <input type="hidden" name="id" value="<?php print ''; ?>" />
                                </td>
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


