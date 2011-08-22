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
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                //initListUsuarios();
                $('.tw-ui-menu-principal .2').addClass('active-menu');
            });
        </script> 
    </head>
    <body>
        <?php 
        printCabecalho('Posts');
        print '<div class="tw-ui-mensagem">'.(isset($_GET['msg'])?$_GET['msg']:'').'</div>';
        ?>
        <div class="tw-ui-content">
            <?php printMenu(); ?>
            <div class="tw-ui-content-mod">
                <?php mountMenuModPosts(); ?>
                <div class="tw-ui-conteiner-usuarios">
                </div>
            </div>
        </div>
    </body>
</html>

