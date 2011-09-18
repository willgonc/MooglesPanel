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
 *	@global array $array_files_js Array com o nome dos arquivos javascripts
 *		que serão carregados e que devem estar no diretório js
 *	@global string $load_fn_js Nome de uma função javascript que será 
 *		executada no onLoad 
 *	@global string $content Nome do arquivo de template da pagina, este
 *		arquivo será o conteudo da página
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
            <div class="tw-ui-menu-principal">
                <img src="imagens/tw.png" />
                <div class="item-menu"><a href="summary.php">Resumo</a></div>
                <div class="item-menu">
                    <a href="posts.php">Posts</a>
                    <div class="submenu tw-ui-submenu">
                        <p><a href="posts.php">Todos os posts</a></p>
                        <p><a href="new_post.php">Adicionar post</a></p>
                        <p><a href="categories.php">Categorias</a></p>
                    </div>
                </div>
                <div class="item-menu">
                    <a href="#">Usu&aacute;rios</a>
                    <div class="submenu tw-ui-submenu">
                        <p><a href="users.php">Todos os usu&aacute;rios</a></p>
                        <p><a href="new_user.php">Adicionar usu&aacute;rio</a></p>
                    </div>
                </div>
                <div class="item-menu"><a href="configuration.php">Configura&ccedil;&otilde;es</a></div>
                <div class="item-menu">
                    <a href="#">Ajuda</a>
                    <div class="submenu tw-ui-submenu">
                        <p><a href="manual.php">Manual</a></p>
                        <p><a href="about.php">Sobre</a></p>
                    </div>
                </div>
                <div class="tw-ui-user-logged item-menu">
                    <a href="#"><?php echo $_SESSION['data']['nome']; ?></a>
                    <div class="submenu-right submenu">
                        <p><a href="perfil.php">Perfil</a></p>
                        <p><a href="logout.php">Sair</a></p>
                    </div>
                </div>
            </div>
            <?php include $content; ?>
        </div>
    </body>
</html>

