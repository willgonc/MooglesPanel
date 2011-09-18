<?php
require_once "lib_ui.php"; 

$result = executeQuery("SELECT * FROM config");
$arr = fetchResults($result);

$email      =  $arr["email"];
$descricao  =  $arr["descricao"];
$titulo     =  $arr["titulo"];

printCabecalho('Configurações');
printMsg();
?>
<div class="tw-ui-content">
    <div class="tw-ui-content-mod">
        <form action="save_config.php" method="post">
            <table class="tw-ui-formulario">
                <tbody>
                    <tr>
                        <td>T&iacute;tulo do site</td>
                        <td><input type="text" class="input-text" name="titulo" size="40" value="<?php print $titulo; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Descri&ccedil;&atilde;o sobre o site</td>
                        <td><input type="text" class="input-text" name="descricao" size="40" value="<?php print $descricao; ?>" /></td>
                    </tr>
                    <tr>
                        <td>E-mail para notifica&ccedil;&otilde;es</td>
                        <td><input type="text" class="input-text" name="email" size="40" value="<?php print $email; ?>" /></td>
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
