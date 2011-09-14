<?php

require_once "lib_db.php";
require_once "lib.php";

$link = openConnect();

loggedUser("login.php", "summary.php");

/** Definindo variáveis do layout */
$array_files_js 	= Array("jquery.js","tw-lib.js");
$load_fn_js 		= "initLogin()";
$content			= "template_login.php";

require_once "layout.php";

closeConnect($link);

?>
