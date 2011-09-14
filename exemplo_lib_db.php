<?php

include "lib_db.php";

$link = openConnectDB();

$result = executeQuery("SELECT * FROM usuarios");

$arr = Array();
while ($row = fetchResults($result)){
    print $row['nome'];
}

closeConnect($link);

?>
