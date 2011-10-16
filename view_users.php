<?php 

require_once "LibInterface.php";
require_once "Pagination.php";

$libInterface = new LibIterface();

$pagination = new Pagination();
$pagination->configure(
    Array(
        'tabela' => 'usuarios',
        'quant' => 10,
        'colunas' => Array('nome', 'email', 'status'),
        'tituloColunas' => Array('Nome', 'E-mail', 'Status'),
        'colSize' => Array('40%', '40%', '20%'),
        'checkbox' => true,
        'colunasBusca' => Array('nome', 'email')
        )
    );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Adicionar usu&aacute;rio - Painel controle</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
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
            <?php echo $libInterface->getHtmlCabecalho('Perfil'); ?>
            <?php echo $libInterface->getMessage(); ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <div class="tw-ui-menu-mod">
                        <a href="#" class="first-item"><input type="checkbox" id="checkAll"></a>
                        <a href="#" id="ativar">Ativar</a>
                        <a href="#" id="bloquear">Bloquear</a>
                        <a href="#" id="deletar" class="last-item">Deletar</a>
                        <?php print $libInterface->getHtmlFormSearch('users.php', 'get', '', 40); ?>
                        <?php print $pagination->getHtmlPagination(); ?>
                    </div>
                    <div class="tw-ui-conteiner-usuarios">
                        <?php echo $pagination->getHtmlTable(); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

