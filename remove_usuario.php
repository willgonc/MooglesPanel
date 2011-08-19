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

echo ($flag == 1?'Todos os usu&aacute;rios foram removidos!': 'Erro ao remover o usu&aacute;rio!'); 

mysql_close($conexao);

?>

