<?php

require_once "connect_db.php";
require_once "lib.php";

$usuarios   = $_POST['usuarios'];
$pag        = $_POST['pag'];
$busca      = $_POST['busca'];

$flag = 1;

for ($i = 0; $i < count($usuarios); $i++){
    try{
        $r = mysql_query('DELETE FROM usuarios WHERE id='.$usuarios[$i]);
        if (!$r)
            $flag = 0;
    } catch (Exception $e){
        $flag = 0;
    }

    if ($flag == 0)
        break;
}
if ($flag == 1){
    $erro = true;
    if (count($usuarios) == 1){
        $msg    = 'O usu&aacute;rio foi removido!';
        $status = 1;
    } else {
        $msg    = 'Todos os usu&aacute;rios foram removidos!';
        $status = 1;
    }
} else {
    $erro = false;
    if (count($usuarios) == 1){
        $msg    = 'Erro ao remover o usu&aacute;rio!'; 
        $status = 0;
    } else {
        $msg    = 'Erro ao remover os usu&aacute;rios!'; 
        $status = 0;
    }
}

echo 'users.php?pag='.$pag.'&busca='.$busca.'&msg='.urlencode($msg).'&status='.$status;

mysql_close($conexao);

?>

