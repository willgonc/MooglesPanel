<?php 

require_once "LibInterface.php";
$libInterface = new LibIterface();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Resumo - Painel controle</title>
		
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
            <?php echo $libInterface->getHtmlCabecalho('Resumo'); ?>
            <div class="tw-ui-content-mod">
            </div>
        </div>
    </body>
</html>


