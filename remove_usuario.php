<?php

require_once "connect_db.php";

$id = $_POST['id'];
$page = $_POST['page'];
$busca = $_POST['busca'];

try{
    $r = mysql_query('DELETE FROM usuarios WHERE id='.$id);
    if ($r)
        header('Location: usuarios.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="okMsg">O usu&aacute;rio foi deletado!</p>'));
    else 
        header('Location: usuarios.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="errorMsg">Erro ao deletar o usu&aacute;rio!</p>'));
} catch (Exception $e){
    header('Location: usuarios.php?pag='.$page.'&busca='.$busca.'&msg='.urlencode('<p class="errorMsg">Erro ao deletar o usu&aacute;rio!</p>'));
}
mysql_close($conexao);
?>

