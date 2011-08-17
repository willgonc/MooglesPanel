<?php

require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];
$flag = false;
$msg = '';
$result = '';

if (!strRequire($email) || !strRequire($senha)) {
    $flag = false;
} else {
    try{
        $result = mysql_query('SELECT * FROM usuarios WHERE email="'.$email.'" and senha="'.sha1($senha).'" and status=1' );
        
        if ($result) {
            if ( mysql_num_rows($result) == 1 )
                $flag = true;
            else
                $flag = false;
        } else {
            $flag = false;
        }
    } catch (Exception $e){
        $flag = false;
    }
}
if ($flag) {
    $_SESSION['data'] = Array('email' => $email, 'senha' => sha1($senha));
    echo true;
} else {
    session_destroy();
    echo false;
}

mysql_close($conexao);

?>
