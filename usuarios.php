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
        <link rel="stylesheet" type="text/css" href="css/tw-modal.css" />

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/tw-ui-lib.js"></script>
        <script type="text/javascript" language="javascript">
            eval('var pagina = <?php echo (isset($_GET['pag'])?$_GET['pag']:1); ?>;');
            <?php 
                if (isset($_GET['busca'])){
                    print "eval('var busca = \"".$_GET['busca']."\"');";
                } else {
                    print "eval('var busca = \"\"');";
                }
            ?>
            $(document).ready(function (){
                $('.open-conf-user').click(function (){
                    var elem = $(this);
                    var text =  '<p>Alterar status do usu&aacute;rio</p>'+
                                '<form action="muda_status_usuario.php" name="formStatusUser" method="post">'+
                                '   <input type="hidden" value="' + $(this).attr('href').replace(/#/g, '') + '" name="id" />'+
                                '   <input type="hidden" value="'+pagina+'" name="page" />'+
                                '   <input type="hidden" value="'+busca+'" name="busca" />'+
                                '   <select name="status" class="combo-box confirm-muda-status">'+
                                '       <option value="1">Ativo</option>'+
                                '       <option value="0">Bloqueado</option>'+
                                '   </select>'+
                                '</form><br />'+
                                '<p>Remover este usu&aacute;rio</p>'+
                                '<form action="remove_usuario.php" name="formRemoveUser" method="post">'+
                                '   <input type="hidden" value="' + $(this).attr('href').replace(/#/g, '') + '" name="id" />'+
                                '   <input type="hidden" value="'+pagina+'" name="page" />'+
                                '   <input type="hidden" value="'+busca+'" name="busca" />'+
                                '</form>'+
                                '<input type="button" class="input-button confirm-remover-usuario" value="Remover usu&aacute;rio" />';

                    criaModal({
                        conteudo: text,
                        width: 350,
                        height: 200
                    }, function (){
                        $('.confirm-remover-usuario').click(function (){
                            if (confirm("Deseja remover este usu\u00e1rio?"))
                                document.formRemoveUser.submit();
                        });

                        $('.confirm-muda-status').val(elem.attr('id').replace(/status/g, '')).change(function (){
                            document.formStatusUser.submit();
                        });
                    });
                });
                $('#item-menu-usuarios').addClass('tw-ui-atual');
                $('.tw-ui-menu-principal .3').addClass('active-menu');
            });
        </script> 
    </head>
    <body>
        <?php 
        printCabecalho('Consulta de usuários');
        printMenu();
        ?>
        <div class="tw-ui-content">
            <?php mountMenuModUsuarios(); ?>
            <div class="tw-ui-content-mod">
                <div class="tw-ui-mensagem"><?php print (isset($_GET['msg'])?$_GET['msg']:'');?></div>
                <div class="tw-ui-conteiner-usuarios">
                    <?php 
                        $pag = (isset($_GET['pag'])?$_GET['pag']:1); // Numero da pagina que esta sendo exibida
                        $pag = filter_var($pag, FILTER_VALIDATE_INT); // Valida o numero passado como parametro

                        $pagina = 'usuarios.php'; // pagina que sera chamada
                        $paginacao = ''; // Paginacao

                        $inicio = 0; // inicio do intervalo da busca
                        $limite = 10; // quantidade que sera exibida na tela

                        if ($pag!='') {
                            $inicio = ($pag - 1) * $limite;
                        } 

                        if (isset($_GET['busca'])){
                            $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios WHERE 
                                nome like '%".$_GET['busca']."%' or email like '%".$_GET['busca']."%'");
                            $total = mysql_fetch_array($busca_total);
                            $total = $total['total'];
                            //$busca = mysql_query("SELECT * FROM usuarios LIMIT $inicio, $limite");
                            //$total
                            $busca = mysql_query("SELECT * FROM usuarios WHERE 
                                nome like '%".$_GET['busca']."%' or email like '%".$_GET['busca']."%' or status like '%".$_GET['busca']."%'
                                ORDER BY nome LIMIT $inicio, $limite ");
                        } else {
                            $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios");
                            $total = mysql_fetch_array($busca_total);
                            $total = $total['total'];
                            $busca = mysql_query("SELECT * FROM usuarios ORDER BY nome LIMIT $inicio, $limite");
                        }

                        $linhasResult = mysql_num_rows($busca);
                        if ($linhasResult>0) {
                            $table = '<table width="100%" class="tw-ui-listagem"><tbody>';
//                            $table .= '<thead><tr><th>Nome</th><th>E-mail</th><th colspan="2">Status</th></tr></thead><tbody>';
                            while ($texto = mysql_fetch_array($busca)) {
                                extract($texto);
                                $table .= '<tr>
                                                <td width="40%">'.$nome.'</td>
                                                <td width="50%">'.$email.'</td>
                                                <td width="10%">'.($status==0?'Bloqueado':'Ativo').'</td>
                                                <td width="32" class="conf-usuario"><a href="#'.$id.'" id="status'.$status.'" class="open-conf-user">
                                                    <img src="imagens/config.png" class="tw-ui-img" /></a>
                                                </td>
                                            </tr>';
                            }
//                            $table .= '</tbody><tfoot><tr><td>Nome</td><td>E-mail</td><td colspan="2">Status</td></tr></tfoot></table>';
                            $table .= '</tbody></table>';

                            $prox = $pag + 1;
                            $ant = $pag - 1;
                            $ultima_pag = ceil($total / $limite);
                            $penultima = $ultima_pag - 1;	
                            $adjacentes = 2;
                            
                            
                            if ($pag>1)
                                $paginacao = '<a href="'.$pagina.'?pag='.$ant.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">&#9666;</a>';
                            else
                                $paginacao = '<a href="#" disabled >&#9666;</a>';
                                
                            if ($prox <= $ultima_pag && $ultima_pag > 2) 
                                $paginacao .= '<a href="'.$pagina.'?pag='.$prox.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">&#9656;</a>';
                            else
                                $paginacao .= '<a href="#" disabled>&#9656;</a>';

                            echo '<div class="paginacao"><b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
                            echo $table;
                            echo '<div class="paginacao"><b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
                        } else {
                            echo "Nenhum resultado foi encontrado!";
                        }
                            
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
