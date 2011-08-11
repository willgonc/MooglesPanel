<?php

function montaPaginacao($pagina, $quantExibicao, $tabela){
    //$pagina = 'usuarios.php'; // pagina que sera chamada
    
    $inicio = 0; // inicio do intervalo da busca
    $limite = ($quantExibicao?$quantExibicao:10); // Quantidade de resultado exibidos na tela, seu valor padrão é 10
    $pag = 1; // Numero da pagina que esta sendo exibida
    $paginacao = ''; // Paginacao

    if (isset($_GET['pag']))
        $pag = $_GET['pag'];
    
    // Valida o numero passado como parametro
    $pag = filter_var($pag, FILTER_VALIDATE_INT); 

    // pega o valor inicial de acordo com o numero da pagina
    $inicio = ($pag - 1) * $limite;

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
        $table = '<table width="100%" class="tw-ui-listagem">';
        $table .= '<thead><tr><th>Nome</th><th>E-mail</th><th colspan="2">Status</th></tr></thead><tbody>';
        while ($texto = mysql_fetch_array($busca)) {
            extract($texto);
            $table .= '<tr>
                            <td width="45%">'.$nome.'</td>
                            <td width="45%">'.$email.'</td>
                            <td width="10%">'.($status==0?'Bloqueado':'Ativo').'</td>
                            <td width="32" class="conf-usuario"><a href="#'.$id.'" id="status'.$status.'" class="open-conf-user">
                                <img src="imagens/config.png" class="tw-ui-img" /></a>
                            </td>
                        </tr>';
        }
        $table .= '</tbody><tfoot><tr><td>Nome</td><td>E-mail</td><td colspan="2">Status</td></tr></tfoot></table>';

        $prox = $pag + 1;
        $ant = $pag - 1;
        $ultima_pag = ceil($total / $limite);
        $penultima = $ultima_pag - 1;	
        $adjacentes = 2;
        
        
        if ($pag>1) {
            $paginacao = '<a href="'.$pagina.'?pag='.$ant.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">&laquo; Anterior</a>';
        }
            
            
        if ($ultima_pag <= 5) {
            for ($i=1; $i< $ultima_pag+1; $i++) {
                if ($i == $pag) {
                    $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                } else {
                    $paginacao .= '<a href="'.$pagina.'?pag='.$i.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$i.'</a>';	
                }
            }
        } 

        if ($ultima_pag > 5) {
            if ($pag < 1 + (2 * $adjacentes)) {
                for ($i=1; $i< 2 + (2 * $adjacentes); $i++) {
                    if ($i == $pag) {
                        $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                    } else {
                        $paginacao .= '<a href="'.$pagina.'?pag='.$i.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$i.'</a>';	
                    }
                }
                $paginacao .= '...';
                $paginacao .= '<a href="'.$pagina.'?pag='.$penultima.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$penultima.'</a>';
                $paginacao .= '<a href="'.$pagina.'?pag='.$ultima_pag.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$ultima_pag.'</a>';
            } elseif($pag > (2 * $adjacentes) && $pag < $ultima_pag - 3) {
                $paginacao .= '<a href="'.$pagina.'?pag=1'.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">1</a>';				
                $paginacao .= '<a href="'.$pagina.'?pag=1'.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">2</a> ... ';	
                for ($i = $pag-$adjacentes; $i<= $pag + $adjacentes; $i++)
                {
                    if ($i == $pag)
                    {
                        $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                    } else {
                        $paginacao .= '<a href="'.$pagina.'?pag='.$i.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$i.'</a>';	
                    }
                }
                $paginacao .= '...';
                $paginacao .= '<a href="'.$pagina.'?pag='.$penultima.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$penultima.'</a>';
                $paginacao .= '<a href="'.$pagina.'?pag='.$ultima_pag.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$ultima_pag.'</a>';
            } else {
                $paginacao .= '<a href="'.$pagina.'?pag=1'.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">1</a>';				
                $paginacao .= '<a href="'.$pagina.'?pag=1'.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">2</a> ... ';	
                for ($i = $ultima_pag - (4 + (2 * $adjacentes)); $i <= $ultima_pag; $i++) {
                    if ($i == $pag) {
                        $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                    } else {
                        $paginacao .= '<a href="'.$pagina.'?pag='.$i.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">'.$i.'</a>';	
                    }
                }
            }
        }
        if ($prox <= $ultima_pag && $ultima_pag > 2) {
            $paginacao .= '<a href="'.$pagina.'?pag='.$prox.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').'">Pr&oacute;ximo &raquo;</a>';
        }
        echo '<div class="paginacao"><b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
        echo $table;
        echo '<div class="paginacao"><b>'.($inicio+1).'</b> a <b>'.($inicio+$linhasResult).'</b> de <b>'.$total.'</b>'.$paginacao.'</div>';
    } else {
        echo "Nenhum resultado foi encontrado!";
    }
}        
?>
