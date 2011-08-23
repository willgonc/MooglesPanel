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
        
        <script type="text/javascript" language="javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-ui-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                //carregaRichText();
                $('.tw-ui-menu-principal .2').addClass('active-menu');
            });
        </script>
    </head>
    <body>
        <?php 
            printCabecalho('Adicionar post');
        print '<div class="tw-ui-mensagem">'.(isset($_GET['msg'])?$_GET['msg']:'').'</div>';
        ?>
        <div class="tw-ui-content">
            <?php printMenu(); ?>
            <div class="tw-ui-content-mod">
                <?php mountMenuModPosts(); ?>
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

                        CKEDITOR.replace( 'texto',
                            {
                                    fullPage : true,
                                extraPlugins : 'docprops',
                                filebrowserBrowseUrl : '/browser/browse/type/all',
                                filebrowserUploadUrl : '/browser/upload/type/all',
                                filebrowserImageBrowseUrl : '/browser/browse/type/image',
                                filebrowserImageUploadUrl : '/browser/upload/type/image',
                                filebrowserWindowWidth  : 800,
                                filebrowserWindowHeight : 500
                            });

                    //]]>
                    </script>
                </form>
            </div>
        </div>
    </body>
</html>


