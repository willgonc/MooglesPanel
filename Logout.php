<?php

Class Logout
{
    public function __construct()
    {
        session_start();
        session_destroy();
        header('Location: login.php');
    }
}

new Logout();

?>
