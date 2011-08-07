<?php

$usuario    = "root";
$senha      = "123456";
$host       = "localhost";
$db         = "tudosobreweb";

// ABRE A CONXAO COM O BANCO
$conexao = mysql_connect($host, $usuario, $senha);

// CRIA A BASE SE ELA NAO EXISTIR
mysql_query("CREATE DATABASE IF NOT EXISTS ".$db);

// SELECIONA O BASE
mysql_select_db($db);

?>
