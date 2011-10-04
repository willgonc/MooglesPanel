<?php 

require_once "LibInterface.php";
$libInterface = new LibIterface();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Perfil - Painel controle</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

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
            <?php echo $libInterface->getHtmlCabecalho('Configurações'); ?>
            <?php echo $libInterface->getMessage(); ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <form action="SaveConfiguration.php" method="post">
                        <table class="tw-ui-formulario">
                            <tbody>
                                <tr>
                                    <td>T&iacute;tulo do site</td>
                                    <td><input type="text" class="input-text" name="titulo" size="30" value="<?php print $titulo; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Descri&ccedil;&atilde;o sobre o site</td>
                                    <td><input type="text" class="input-text" name="descricao" size="30" value="<?php print $descricao; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>E-mail para notifica&ccedil;&otilde;es</td>
                                    <td><input type="text" class="input-text" name="email" size="30" value="<?php print $email; ?>" /></td>
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


