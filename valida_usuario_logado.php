<?php

/*
 *      Arquivo: conecta.php
 *      Descrição: Arquivo verifica se o usuário está logado
 *      Autor: Markus Vinicius da Silva Lima
 */

$data       = '';
$flag       = false;
$sql        = '';
$result     = '';
$numLinhas  = 0;
$pagina     = end(explode("/", $_SERVER['PHP_SELF']));

session_start();

if (isset($_SESSION['data']))
{ 
    $data = $_SESSION['data'];
    try{
        $sql = 'SELECT * FROM usuarios WHERE email="'.$data['email'].'" 
                    and senha="'.$data['senha'].'" and status=1';
        
        // consulta na base os dados
        $result = mysql_query($sql);

        if ($result) {
            $numLinhas = mysql_num_rows($result);

            if ($numLinhas == 1)
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

