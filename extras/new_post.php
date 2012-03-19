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
        <script type="text/javascript" language="javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" language="javascript" src="ckfinder/ckfinder.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-ui-lib.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initMenu();
            });
        </script>
    </head>
    <body>
        <div class="tw-ui-geral">
            <?php 
                printMenuPrincipal();
                printCabecalho('Adicionar novo post');
                printMsg();
            ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <form action="insert_post.php" method="post">
                        <table class="tw-ui-formulario">
                            <tbody>
                                <tr>
                                    <td>T&iacute;tulo *</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="input-text" size="100" name="titulo" /></td>
                                </tr>
                                <tr>
                                    <td><textarea id="texto" name="texto"></textarea></td>
                                </tr> 
                                <tr>
                                    <td><input type="submit" class="input-submit" value="Salvar" /></td>
                                </tr>
                            </tbody>
                        </table>
                        <script type="text/javascript">
                        //<![CDATA[

                            CKEDITOR.replace( 'texto', {
                                    filebrowserBrowseUrl : 'ckfinder/ckfinder.html', 
                                    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images', 
                                    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash', 
                                    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', 
                                    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images', 
                                    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash' 
                                });

                        //]]>
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


