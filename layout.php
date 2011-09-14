<?php 

/**
 *	Arquivo de layout default das páginas
 *	
 *	@author markus vinicius da silva lima <markusslima@gmail.com>
 *	@copyright copyright © 2011, markus vinicius da silva lima.
 *
 *	As variáveis documentadas abaixo não são parametros de função apenas
 *	variáveis globais usadas pelo layout para receber as informações 
 *	da página que será exibida
 *
 *	@param array $array_files_js Array com o nome dos arquivos javascripts
 *		que serão carregados e que devem estar no diretório js
 *	@param string $load_fn_js Nome de uma função javascript que será 
 *		executada no onLoad 
 *	@param string $content Nome do arquivo de template da pagina, este
 *		arquivo será o conteudo da página
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="shortcut icon" href="imagens/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<?php
			for ($i = 0; $i < count($array_files_js); $i++)
				print '<script type="text/javascript" language="javascript" src="js/'.$array_files_js[$i].'"></script>';
		?>
    </head>
    <body onLoad="<?php echo $load_fn_js; ?>">
        <div class="geral">
            <?php include $content; ?>
        </div>
    </body>
</html>

