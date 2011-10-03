<?php 

require_once "LibInterface.php";
$libInterface = new LibIterface();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <title>Sobre - Painel controle</title>
		
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
            <?php echo $libInterface->getHtmlCabecalho('Sobre'); ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <p><b>Lundium urna natoque urna! In est! Integer? </b>Sit quis nascetur habitasse ultrices, aenean augue porttitor porta rhoncus sit ultricies habitasse habitasse nunc pulvinar amet. Turpis, nunc. Augue ac, penatibus vel! Risus turpis. A mauris sed? Eros augue non sit dolor pulvinar platea, in ultricies. </p>
                    <p>Placerat dapibus sociis amet montes massa, urna amet dis, duis a! Augue mus tincidunt! Ac cras amet turpis turpis urna elementum penatibus mattis? Scelerisque urna, a turpis et ultricies natoque vut vut quis? Mid! Sagittis ultrices, platea sit! Quis in penatibus lectus amet mattis purus eros urna scelerisque, scelerisque cras? Augue augue mid enim! Dis ac, pellentesque, enim enim odio non mauris, ac? Diam porttitor egestas.</p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </body>
</html>


