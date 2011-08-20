<?php

require_once "connect_db.php";
require_once "logged.php";
require_once "lib.php";

$usuarios = $_POST['usuarios'];
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
    if (count($usuarios) == 1)
        $msg = '<p class="okMsg">O usu&aacute;rio foi removido!</p>';
    else
        $msg = '<p class="okMsg">Todos os usu&aacute;rios foram removidos!</p>';
} else {
    $erro = false;
    if (count($usuarios) == 1)
        $msg = '<p class="errorMsg">Erro ao remover o usu&aacute;rio!</p>'; 
    else
        $msg = '<p class="errorMsg">Erro ao remover os usu&aacute;rios!</p>'; 
}

echo "{erro: ".$erro.", msg: '$msg'}";

mysql_close($conexao);

?>

