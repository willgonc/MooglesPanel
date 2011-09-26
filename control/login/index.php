<?php

Class Index {
    public $array_files_js;
    public $load_fn_js;
    public $content;

    public function __construct($view) {
        $this->array_files_js 	= Array("jquery.js","tw-lib.js");
        $this->load_fn_js 		= "initLogin()";
        $this->content = $view;

        require_once "layout_login.php";
    }
}

?>
