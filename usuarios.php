<?php
    require_once "connect_db.php";
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
            $(document).ready(function (){
                $('.open-conf-user').click(function (){
                    criaModal({
                        conteudo: '<form action="remove_usuario.php" method="post">'+
                                 '<input type="hidden" value="' + 
                                 $(this).attr('href').replace(/#/g, '') + 
                                 '" name="id" /><input type="submit" class="input-submit" value="Remover usu&aacute;rio" />',
                        width: 450,
                        height: 250
                    });
                });
            });
        </script> 
    </head>
    <body>
        <div class="geral">
            <?php require_once "menu.php"; ?>
            <div class="tw-ui-bar-page">
                <h2 class="tw-ui-name-page">
                    Usu&aacute;rios
                </h2>
                <div class="tw-ui-menu-modulo">
                    <ul>
                        <li><a href="adicionar_usuario.php">Adicionar novo</a></li>
                        <li><a href="perfil.php">Seu perfil</a></li>
                    </ul>
                </div>
                <div class="tw-ui-busca">
                    <form action="buscar_usuarios">
                        <input type="text" class="input-text" size="30" name="str_busca" />
                        <input type="submit" class="input-submit" value="Buscar" />
                    </form>
                </div>
            </div>
            <div class="tw-ui-content">
                <div class="tw-ui-conteiner-usuarios">
                    <?php
                        $pag = (isset($_GET['pag'])?$_GET['pag']:1); // Numero da pagina que esta sendo exibida
                        $pag = filter_var($pag, FILTER_VALIDATE_INT); // Valida o numero passado como parametro

                        $pagina = 'usuarios.php'; // pagina que sera chamada
                        $paginacao = ''; // Paginacao

                        $inicio = 0; // inicio do intervalo da busca
                        $limite = 25; // quantidade que sera exibida na tela

                        if ($pag!='') {
                            $inicio = ($pag - 1) * $limite;
                        } 

                        $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios");
                        $total = mysql_fetch_array($busca_total);
                        $total = $total['total'];

                        $busca = mysql_query("SELECT * FROM usuarios LIMIT $inicio, $limite");

                        if (mysql_num_rows($busca)>0) {
                            $table = '<table width="100%" class="tw-ui-listagem">';
                            $table .= '<thead><tr><th>Nome</th><th>E-mail</th><th>Tipo</th><th colspan="2">Status</th></tr></thead><tbody>';
                            while ($texto = mysql_fetch_array($busca)) {
                                extract($texto);
                                
                                $table .= '<tr>
                                                <td width="40%">'.$nome.'</td>
                                                <td width="40%">'.$email.'</td>
                                                <td width="10%">'.$tipo.'</td>
                                                <td width="10%">'.$status.'</td>
                                                <td width="32" class="conf-usuario"><a href="#'.$id.'" class="open-conf-user"><img src="imagens/config.png" /></a></td>
                                            </tr>';
                            }
                            $table .= '</tbody><tfoot><tr><td>Nome</td><td>E-mail</td><td>Tipo</td><td colspan="2">Status</td></tr></tfoot></table>';

                            $prox = $pag + 1;
                            $ant = $pag - 1;
                            $ultima_pag = ceil($total / $limite);
                            $penultima = $ultima_pag - 1;	
                            $adjacentes = 2;
                            
                            
                            if ($pag>1) {
                                $paginacao = '<a href="'.$pagina.'?pag='.$ant.'">&laquo; Anterior</a>';
                            }
                                
                                
                            if ($ultima_pag <= 5) {
                                for ($i=1; $i< $ultima_pag+1; $i++) {
                                    if ($i == $pag) {
                                        $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                                    } else {
                                        $paginacao .= '<a href="'.$pagina.'?pag='.$i.'">'.$i.'</a>';	
                                    }
                                }
                            } 

                            if ($ultima_pag > 5) {
                                if ($pag < 1 + (2 * $adjacentes)) {
                                    for ($i=1; $i< 2 + (2 * $adjacentes); $i++) {
                                        if ($i == $pag) {
                                            $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                                        } else {
                                            $paginacao .= '<a href="'.$pagina.'?pag='.$i.'">'.$i.'</a>';	
                                        }
                                    }
                                    $paginacao .= '...';
                                    $paginacao .= '<a href="'.$pagina.'?pag='.$penultima.'">'.$penultima.'</a>';
                                    $paginacao .= '<a href="'.$pagina.'?pag='.$ultima_pag.'">'.$ultima_pag.'</a>';
                                } elseif($pag > (2 * $adjacentes) && $pag < $ultima_pag - 3) {
                                    $paginacao .= '<a href="'.$pagina.'?pag=1">1</a>';				
                                    $paginacao .= '<a href="'.$pagina.'?pag=1">2</a> ... ';	
                                    for ($i = $pag-$adjacentes; $i<= $pag + $adjacentes; $i++)
                                    {
                                        if ($i == $pag)
                                        {
                                            $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                                        } else {
                                            $paginacao .= '<a href="'.$pagina.'?pag='.$i.'">'.$i.'</a>';	
                                        }
                                    }
                                    $paginacao .= '...';
                                    $paginacao .= '<a href="'.$pagina.'?pag='.$penultima.'">'.$penultima.'</a>';
                                    $paginacao .= '<a href="'.$pagina.'?pag='.$ultima_pag.'">'.$ultima_pag.'</a>';
                                } else {
                                    $paginacao .= '<a href="'.$pagina.'?pag=1">1</a>';				
                                    $paginacao .= '<a href="'.$pagina.'?pag=1">2</a> ... ';	
                                    for ($i = $ultima_pag - (4 + (2 * $adjacentes)); $i <= $ultima_pag; $i++) {
                                        if ($i == $pag) {
                                            $paginacao .= '<a class="atual" href="#">'.$i.'</a>';				
                                        } else {
                                            $paginacao .= '<a href="'.$pagina.'?pag='.$i.'">'.$i.'</a>';	
                                        }
                                    }
                                }
                            }
                            if ($prox <= $ultima_pag && $ultima_pag > 2) {
                                    $paginacao .= '<a href="'.$pagina.'?pag='.$prox.'">Pr&oacute;ximo &raquo;</a>';
                            }
                            echo '<div class="paginacao">'.$paginacao.'</div>';
                            echo $table;
                            echo '<div class="paginacao">'.$paginacao.'</div>';
                        } else {
                            echo "Nenhum resultado foi encontrado!";
                        }
                            
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
