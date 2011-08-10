<?php
require_once "connect_db.php";


/*
 *   Pegando valores
 */
$id         = $_POST['id'];
$page       = $_POST['page'];
$status     = $_POST['status'];

if($status == 1 || $status == 0)
{
    try{
        $update = mysql_query("UPDATE usuarios SET status='".$status."' WHERE id=".$id);
        if ($update){
            header("Location: usuarios.php?pag=".$page."&msg=".urlencode('<p class="okMsg">O status do usur&aacute;rio foi altertado!</p>'));
        } else {
            header("Location: usuarios.php?pag=".$page."&msg=".urlencode('<p class="errorMsg">Erro ao alterar o status do usu&aacute;rio!</p>'));
        }
    } catch( Exception $e ){
        header("Location: usuarios.php?pag=".$page."&msg=".urlencode('<p class="errorMsg">Erro ao alterar o status do usu&aacute;rio!</p>'));
    }
}
else
{
    header("Location: usuarios.php?pag=".$page."&msg=".urlencode('<p class="errorMsg">Erro ao alterar o status do usu&aacute;rio!</p>'));
}

mysql_close($conexao);
?>


