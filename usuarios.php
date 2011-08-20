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
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initListUsuarios();
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
                                nome like '%".$_GET['busca']."%' or 
                                email like '%".$_GET['busca']."%' or 
                                status like '%".$_GET['busca']."%'
                                ORDER BY nome LIMIT $inicio, $limite ");
                            
                            //$total = mysql_num_rows($busca);


                            //$busca = mysql_query("SELECT * FROM usuarios WHERE 
                            //    nome like '%".$_GET['busca']."%' or email like '%".$_GET['busca']."%' or status like '%".$_GET['busca']."%'
                            //    ORDER BY nome LIMIT $inicio, $limite ");
                        } else {
                            $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios");
                            $total = mysql_fetch_array($busca_total);
                            $total = $total['total'];
                            //$busca = mysql_query("SELECT * FROM usuarios ORDER BY nome LIMIT $inicio, $limite");
                            $busca = mysql_query("SELECT * FROM usuarios ORDER BY nome LIMIT $inicio, $limite");
                        }

                        $linhasResult = mysql_num_rows($busca);
                        if ($linhasResult > 0) {
                            
                            $table = '<table width="100%" class="tw-ui-listagem">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th colspan="2">Status</th>
                                        </tr>
                                    </thead>
                                <tbody>';
                            while ($texto = mysql_fetch_array($busca)) {
                                extract($texto);

                                $table .= '<tr>
                                    <td width="25px">
                                        '.($email == $_SESSION['data']['email']?'':'<input type="checkbox" class="checkboxListagem" value="'.$id.'">').'
                                    </td>
                                    <td width="40%">'.$nome.'</td>
                                    <td width="50%">'.$email.'</td>
                                    <td width="10%">'.($status==0?'<span style="color: red">Bloqueado':'<span style="color: green">Ativo').'</span></td>
                                    <!--td width="32" class="conf-usuario"><a href="#'.$id.'" id="status'.$status.'" class="open-conf-user">
                                        <img src="imagens/config.png" class="tw-ui-img" /></a>
                                    </td-->
                                </tr>';
                            }
                            $table .= '</tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>Nome</td>
                                        <td>E-mail</td>
                                        <td colspan="2">Status</td>
                                    </tr>
                                </tfoot>
                            </table>';

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
                            echo '<div class="paginacao">
                            
                            <b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
                        } else {
                            echo "Nenhum resultado foi encontrado!";
                        }
                            
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
