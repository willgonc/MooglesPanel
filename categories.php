<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php";
mysql_close($conexao);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="shortcut icon" href="imagens/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/tw-style.css" />
        
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-ui-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initMenu();
                initCategories();
            });
        </script>
    </head>
    <body>
        <div class="tw-ui-geral">
            <?php 
                printMenuPrincipal();
                printCabecalho('Categorias');
                printMsg();
            ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <div class="tw-ui-menu-mod">
                        <a href="#" class="first-item"><input type="checkbox" id="checkAll"></a>
                        <a href="#" id="editar">Editar</a>
                        <a href="#" id="deletar" class="last-item">Deletar</a>
                        <a href="#" id="adicionar" class="unico-item" >Adicionar categoria</a>
                        <?php print returnFormSearch('categories.php', 'get', '', 40); ?>
                        <div class="paginacao"><b><?php print ($inicio+1) ?></b> a <b> <?php print ($inicio+$linhasResult) ?></b> de <b><?php print $total ?></b><?php print $paginacao ?></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
