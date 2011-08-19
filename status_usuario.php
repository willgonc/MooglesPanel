<?php
require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$usuarios = $_POST['usuarios'];
$status = $_POST['estado'];
$flag = 1;


for ($i = 0; $i < count($usuarios); $i++){
    if($status == 1 || $status == 0)
    {
        try{
            $update = mysql_query("UPDATE usuarios SET status=".$status." WHERE id=".$usuarios[$i]);
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

echo ($flag == 1?'Todos os usuarios foram alterados!'.$status: 'Erro ao alterar o usu&aacute;rio!'); 

mysql_close($conexao);
?>


