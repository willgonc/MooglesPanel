<?php

$data       = '';
$flag       = false;
$sql        = '';
$result     = '';
$pagina     = end(explode("/", $_SERVER['PHP_SELF']));

session_start();

if (isset($_SESSION['data'])) { 
    $data = $_SESSION['data'];

    try{
        $sql = 'SELECT * FROM usuarios WHERE email="'.$data['email'].'" 
                    and senha="'.$data['senha'].'" and status=1';
        
        // consulta na base os dados
        $result = mysql_query($sql);

        if ($result) {
            if (mysql_num_rows($result) == 1)
                $flag = true;
            else
                $flag = false;
        } else { 
            $flag = false;
        }
    } catch (Exception $e){
        $flag = false;
    }
} else {
    $flag = false;
}
if (!$flag && $pagina != "login.php")
    header('Location: login.php');
else if ($flag && $pagina == "login.php")
    header('Location: resumo.php');
