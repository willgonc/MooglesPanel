<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="shortcut icon" href="imagens/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script> 
        <?php echo '<script type="text/javascript" language="javascript" src="js/'.$fileJs.'"></script>'; ?>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                <?php echo $initFunctionJs; ?>
                //initLogin()
            });
        </script>
    </head>
    <body>
        <div class="geral">
            <?php include $content; ?>
        </div>
    </body>
</html>

