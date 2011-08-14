<?php

require_once "connect_db.php";
require_once "libs_php/libvalidacoes.php";

session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

$flag = false;
$msg = '';
$result = '';

if (strRequire($email) == false || strRequire($senha) == false) {
    $flag = false;
    if (strRequire($msg) == false)
        $msg = 'Preencha todos os campos!';
} else {
    try{
        $result = mysql_query('SELECT * FROM usuarios WHERE email="'.$email.'" and senha="'.sha1($senha).'" and status=1' );
        
        if ($result) {
            if ( mysql_num_rows($result) == 1 ) {
                $flag = true;
            } else {
                $flag = false;
                if (strRequire($msg) == false)
                    $msg = 'Usu&aacute;rio ou senha incorretos!';
            }
        } else {
            $flag = false;
            if (strRequire($msg) == false)
                $msg = 'Usu&aacute;rio ou senha incorretos!';
        }
    } catch (Exception $e){
        $flag = false;
        if (strRequire($msg) == false)
            $msg = 'Usu&aacute;rio ou senha incorretos!';
    }
}

if ($flag) {
    $_SESSION['data'] = Array('email' => $email, 'senha' => sha1($senha));
    header('Location: resumo.php');
} else {
    session_destroy();
    header('Location: login.php?msg='.urlencode($msg));
}

mysql_close($conexao);

?>
