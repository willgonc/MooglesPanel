<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$usuarios   = $_POST['usuarios'];
$stat     = $_POST['estado'];
$pag        = $_POST['pag'];
$busca      = $_POST['busca'];

$flag = 1;

for ($i = 0; $i < count($usuarios); $i++){
    if($stat == 1 || $stat == 0)
    {
        try{
            $update = mysql_query("UPDATE usuarios SET status=".$stat." WHERE id=".$usuarios[$i]);
            if (!$update){
                $flag = 0;
            }
        } catch( Exception $e ){
            $flag = 0;
        }
    } else {
        $flag = 0;
    }
    
    if ($flag == 0)
        break;
}

if ($flag == 1){
    $erro = true;
    if (count($usuarios) == 1){
        $msg = 'O usuario foi alterado!';
        $status = 1;
    } else {
        $msg = 'Todos os usuarios foram alterados!';
        $status = 1;
    }
} else {
    $erro = false;
    if (count($usuarios) == 1){
        $msg = 'Erro ao alterar o usu&aacute;rio!'; 
        $status = 0;
    } else {
        $msg = 'Erro ao alterar os usu&aacute;rios!'; 
        $status = 0;
    }
}

echo 'users.php?pag='.$pag.'&busca='.$busca.'&msg='.urlencode($msg).'&status='.$status;

mysql_close($conexao);
?>


