<?php

require_once "DataBase.php";
require_once "Logged.php";

$dataBase = new DataBase();
$logged = new Logged($dataBase);

$dataBase->closeConnect();

require_once "view_summary.php";

?>
