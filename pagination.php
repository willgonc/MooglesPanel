<?php

function paginacao($pagina, $quant, $busca, $tabela){
    if (isset($_GET['pag'])
        $pag = $_GET['pag'];
    else
        $pag = 1;
    
    $pag = filter_var($pag, FILTER_VALIDATE_INT); // Valida o numero passado como parametro

    //$pagina = 'usuarios.php'; // pagina que sera chamada
    $paginacao = ''; // Paginacao

    $inicio = 0; // inicio do intervalo da busca
    $limite = $quant; // quantidade que sera exibida na tela

    if ($pag != '')
        $inicio = ($pag - 1) * $limite;
    
    
    if (isset($busca)){
        $busca_total = mysql_query("SELECT COUNT(*) as total FROM $tabela WHERE 
            nome like '%$busca%' or email like '%$_GET['busca']%'");

        $total = mysql_fetch_array($busca_total);
        $total = $total['total'];

        $busca = mysql_query("SELECT * FROM $tabela WHERE 
            nome like '%$_GET['busca']%' or email like '%$_GET['busca']%' or status like '%$_GET['busca']%'
            ORDER BY nome LIMIT $inicio, $limite ");
    } else {
        $busca_total = mysql_query("SELECT COUNT(*) as total FROM $tabela");
        $total = mysql_fetch_array($busca_total);
        $total = $total['total'];
        $busca = mysql_query("SELECT * FROM $tabela ORDER BY nome LIMIT $inicio, $limite");
    }
}

                        /*$pag = (isset($_GET['pag'])?$_GET['pag']:1); // Numero da pagina que esta sendo exibida
                        $pag = filter_var($pag, FILTER_VALIDATE_INT); // Valida o numero passado como parametro

                        $pagina = 'usuarios.php'; // pagina que sera chamada
                        $paginacao = ''; // Paginacao

                        $inicio = 0; // inicio do intervalo da busca
                        $limite = 10; // quantidade que sera exibida na tela

                        if ($pag!='') {
                            $inicio = ($pag - 1) * $limite;
                        } */

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
