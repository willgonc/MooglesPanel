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

if ($flag == 1){
    $erro = true;
    $msg = '<p class="okMsg">Todos os usuarios foram alterados!</p>';
} else {
    $erro = false;
    $msg = '<p class="errorMsg">Erro ao alterar o usu&aacute;rio!</p>'; 
}

echo "{erro: ".$erro.", msg: '$msg'}";

mysql_close($conexao);
?>


