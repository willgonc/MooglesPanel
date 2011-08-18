<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php"; 
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
                $('.tw-ui-menu-principal .1').addClass('active-menu');
            });
        </script>
    </head>
    <body>
        <?php 
        printCabecalho('Resumo');
        printMenu();
        ?>
        <div class="tw-ui-content">
            <?php mountMenuModResumo(); ?>
            <div class="tw-ui-content-mod"></div>
        </div>
    </body>
</html>
<?php mysql_close($conexao); ?>
