<?php

$result = executeQuery("SELECT * FROM usuarios WHERE email='".$_SESSION['data']['email']."'");
$arr = fetchResults($result);
$id_user = $arr['id'];
$data = $_SESSION['data'];

require_once "lib_ui.php"; 
printCabecalho('Seu perfil');
printMsg();

?>
<div class="tw-ui-content">
    <div class="tw-ui-content-mod">
        <form action="save_perfil.php" method="post">
            <table class="tw-ui-formulario">
                <tbody>
                    <tr>
                        <td>Nome *</td>
                        <td>
                            <input type="text" class="input-text" size="30" name="nome" value="<?php print $data['nome']; ?>" />
                            <input type="hidden" name="id" value="<?php print $id_user; ?>" />
                        </td>
                        <td rowspan="6" valign="top">
                            <div class="tw-ui-dicas">
                                <p>( * ) Esses campos s&atilde;o obrigat&oacute;rios.</p>
                                <p><b>E-mail:</b> deve ser utilizado um e-mail válido.</p>
                                <p><b>Senha:</b> a senha deve ter no m&iacute;nimo 6 caracteres.</p>
                                <p style="color: red">Para alterar a senha preencha o campo senha e confirme novamente a senha. Se caso n&atilde;o queira alterar deixer em branco.</p>
                                <p><b>Escolha uma senha forte, coloque caracteres mai&uacute;sculos, min&uacute;sculos, espaços e outros caracteres como * + - # $ @ e outros.</b></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail *</td>
                        <td><input type="text" class="input-text" size="30" name="email" value="<?php print $data['email']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Senha</td>
                        <td><input type="password" class="input-text" size="30" name="senha" /></td>
                    </tr>
                    <tr>
                        <td>Confirmar senha</td>
                        <td><input type="password" class="input-text" size="30" name="confirm_senha"/></td>
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
