<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib_ui.php"; 

// pegando a pagina corrente            
$arr = explode('/', $_SERVER['SCRIPT_NAME']);
$pagina = $arr[count($arr)-1];

$paginacao = ''; // Paginacao
$inicio = 0; // inicio do intervalo da busca
$limite = 25;// quantidade que sera exibida na tela

// Numero da pagina que esta sendo exibida
if (isset($_GET['pag']))
    $pag = $_GET['pag'];
else 
    $pag = 1; 

// Valida o numero passado como parametro
$pag = filter_var($pag, FILTER_VALIDATE_INT); 

if ($pag!='')
    $inicio = ($pag - 1) * $limite;

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
} else {
    $busca_total = mysql_query("SELECT COUNT(*) as total FROM usuarios");
    $total = mysql_fetch_array($busca_total);
    $total = $total['total'];
    $busca = mysql_query("SELECT * FROM usuarios ORDER BY nome LIMIT $inicio, $limite");
}

$linhasResult = mysql_num_rows($busca);
if ($linhasResult > 0) {
    
    $table = '<table width="100%" class="tw-ui-listagem">
            <thead>
                <tr>
                    <th></th>
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
        $paginacao = '<a class="prev-paginacao" href="'.$pagina.'?pag='.$ant.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowleft.png" /></a>';
    else
        $paginacao = '<a href="#" disabled class="prev-paginacao" ><img src="imagens/arrowleftdisabled.png" /></a>';
        
    if ($prox <= $ultima_pag && $ultima_pag >= 2) 
        $paginacao .= '<a class="next-paginacao" href="'.$pagina.'?pag='.$prox.(isset($_GET['busca'])?'&busca='.$_GET['busca']:'').(isset($_GET['limit'])?'&limit='.$_GET['limit']:'').'"><img src="imagens/arrowright.png" /></a>';
    else
        $paginacao .= '<a href="#" disabled class="next-paginacao"><img src="imagens/arrowrightdisabled.png" /></a>';
} else {
    $paginacao = '<a href="#" disabled class="prev-paginacao" ><img src="imagens/arrowleftdisabled.png" /></a><a href="#" disabled class="next-paginacao"><img src="imagens/arrowrightdisabled.png" /></a>';
    $table = '<table width="100%" class="tw-ui-listagem">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th colspan="2">Status</th>
                </tr>
            </thead>
        <tbody>
            <tr>
                <td width="25px" align="center" colspan="4">
                    Nenhum resultado foi encontrado!
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Nome</td>
                <td>E-mail</td>
                <td colspan="2">Status</td>
            </tr>
        </tfoot>
    </table>';
}
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
        <script type="text/javascript" language="javascript" src="js/tw-lib.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function (){
                initListUsuarios();
                initMenu();
            });
        </script> 
    </head>
    <body>
        <div class="tw-ui-geral">
            <?php 
                printMenuPrincipal();
                printCabecalho('Usuários');
                printMsg();
            ?>
            <div class="tw-ui-content">
                <div class="tw-ui-content-mod">
                    <div class="tw-ui-menu-mod">
                        <a href="#" class="first-item"><input type="checkbox" id="checkAll"></a>
                        <a href="#" id="ativar">Ativar</a>
                        <a href="#" id="bloquear">Bloquear</a>
                        <a href="#" id="deletar" class="last-item">Deletar</a>
                        <?php print returnFormSearch('users.php', 'get', '', 40); ?>
                        <div class="paginacao"><b><?php print ($inicio+1) ?></b> a <b> <?php print ($inicio+$linhasResult) ?></b> de <b><?php print $total ?></b><?php print $paginacao ?></div>
                    </div>
                    <div class="tw-ui-conteiner-usuarios">
                        <?php
                            echo $table;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
