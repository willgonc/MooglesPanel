<?php

require_once "DataBase.php";
require_once "Logged.php";

$dataBase = new DataBase();
$logged = new Logged($dataBase);

$result = $dataBase->executeQuery("SELECT * FROM config");

while ($row = $dataBase->fetchResults($result)){
    $email = $row["email"];
    $descricao = $row["descricao"];
    $titulo = $row["titulo"];
}

$dataBase->closeConnect();

require_once "view_configuration.php";

?>
