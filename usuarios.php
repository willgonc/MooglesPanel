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
                $('#okAcoesListagem').click(function (){
                    var valor = $('#acoesListagem').val();
                    var check = $('.checkboxListagem:checked');
                    var arrData = [];

                    for (var i = 0; i < check.length; i++)
                        arrData[i] = check.eq(i).val();

                    if (valor == 'del'){
                        $.post(
                            'remove_usuario.php',
                            {usuarios: arrData},
                            function (d){
                                if (d)
                                    window.location = 'usuarios.php?msg=<p class="okMsg">'+d+'</p>';
                                else
                                    alert('erro');
                            }
                        );
                    } else if (valor == 0) {
                        $.post(
                            'status_usuario.php',
                            {usuarios: arrData, estado: 0},
                            function (d){
                                if (d)
                                    window.location = 'usuarios.php?msg=<p class="okMsg">'+d+'</p>';
                                else
                                    alert('erro');
                            }
                        );
                    } else if (valor == 1){
                        $.post(
                            'status_usuario.php',
                            {usuarios: arrData, estado: 1},
                            function (d){
                                if (d)
                                    window.location = 'usuarios.php?msg=<p class="okMsg">'+d+'</p>';
                                else
                                    alert('erro');
                            }
                        );
                    }
                });

                $('#checkAll').click(function (){
                    if(this.checked == true){
                        $(".checkboxListagem").each(function() { 
                            this.checked = true; 
                        }).parent().parent().css({
                            'background':'rgb(230,230,230)'    
                        });
                    } else {
                        $(".checkboxListagem").each(function() { 
                            this.checked = false; 
                        }).parent().parent().css({
                            'background':'rgb(255,255,255)'    
                        });
                    }
                });
                
                $(".checkboxListagem").click(function() { 
                    if(this.checked == true){
                        $(this).parent().parent().css({
                            'background':'rgb(230,230,230)'    
                        });
                    } else {
                        $(this).parent().parent().css({
                            'background':'rgb(255,255,255)'    
                        });
                    }
                });

                $('.tw-ui-menu-principal .3').addClass('active-menu');
            });
        </script> 
    </head>
    <body>
        <?php 
        printCabecalho('Consulta de usuários');
        print '<div class="tw-ui-mensagem">'.(isset($_GET['msg'])?$_GET['msg']:'').'</div>';
        ?>
        <div class="tw-ui-content">
            <?php printMenu(); ?>
            <div class="tw-ui-content-mod">
                <?php mountMenuModUsuarios(); ?>
                <div class="tw-ui-conteiner-usuarios">
                    <?php 
                    
                        // Numero da pagina que esta sendo exibida
                        if (isset($_GET['pag']))
                            $pag = $_GET['pag'];
                        else 
                            $pag = 1; 

                        // Valida o numero passado como parametro
                        $pag = filter_var($pag, FILTER_VALIDATE_INT); 

                        $pagina = 'usuarios.php'; // pagina que sera chamada
                        $paginacao = ''; // Paginacao

                        $inicio = 0; // inicio do intervalo da busca
                       
                        // quantidade que sera exibida na tela
                        $limite = 25;


                        if ($pag!='') {
                            $inicio = ($pag - 1) * $limite;
                        } 

                        if (isset($_GET['busca'])){
                            $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios WHERE 
                                nome like '%".$_GET['busca']."%' or email like '%".$_GET['busca']."%'");
                            $total = mysql_fetch_array($busca_total);
                            $total = $total['total'];
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
                            $table .= '<thead><tr><th><input type="checkbox" id="checkAll"></th><th>Nome</th><th>E-mail</th><th colspan="2">Status</th></tr></thead><tbody>';
                            while ($texto = mysql_fetch_array($busca)) {
                                extract($texto);
                                $table .= '<tr>
                                                <td width="25px"><input type="checkbox" class="checkboxListagem" value="'.$id.'"></td>
                                                <td width="40%">'.$nome.'</td>
                                                <td width="50%">'.$email.'</td>
                                                <td width="10%">'.($status==0?'<span style="color: red">Bloqueado</span>':'<span style="color: green">Ativo</span>').'</td>
                                                <!--td width="32" class="conf-usuario"><a href="#'.$id.'" id="status'.$status.'" class="open-conf-user">
                                                    <img src="imagens/config.png" class="tw-ui-img" /></a>
                                                </td-->
                                            </tr>';
                            }
                            $table .= '</tbody><tfoot><tr><td></td><td>Nome</td><td>E-mail</td><td colspan="2">Status</td></tr></tfoot></table>';

                            $prox = $pag + 1;
                            $ant = $pag - 1;
                            $ultima_pag = ceil($total / $limite);
                            $penultima = $ultima_pag - 1;	
                            $adjacentes = 2;
                            
                           
                            if ($pag>1)
                                $paginacao = '<a href="'.$pagina.'?pag='.$ant.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowleft.png" /></a>';
                            else
                                $paginacao = '<a href="#" disabled ><img src="imagens/arrowleftdisabled.png" /></a>';
                                
                            if ($prox <= $ultima_pag && $ultima_pag >= 2) 
                                $paginacao .= '<a href="'.$pagina.'?pag='.$prox.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowright.png" /></a>';
                            else
                                $paginacao .= '<a href="#" disabled><img src="imagens/arrowrightdisabled.png" /></a>';

                            echo '<div class="paginacao">
                                    <span>A&ccedil;&otilde;es 
                                    <select id="acoesListagem" class="combo-box">
                                        <option> ---- </option>
                                        <option value="1">Ativar</option>
                                        <option value="0">Bloquear</option>
                                        <option value="del">Deletar</option>
                                    </select>
                                    <input type="button" id="okAcoesListagem" class="input-button" value="Executar" />
                                    </span>
                            <b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
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
