<?php

require_once '../../Core.php';

Class Control extends Core {
    public function __construct() { 
		parent::execute_action();
	}
}

new Control();

?>
