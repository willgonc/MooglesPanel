<?php

/**
 *	Aqui fica as configurações de conexão com SGBD
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

Class Config 
{
    private $user;
    private $pass;
    private $host;
    private $dataBase;

    public function __construct()
    {
        $this->setUser("root");
        $this->setPass("123456");
        $this->setHost("localhost");
        $this->setDatabase("tudosobreweb");
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }
    
    public function getHost()
    {
        return $this->host;
    }

    public function getDataBase()
    {
        return $this->dataBase;
    }

    private function setUser($user)
    {
        $this->user = $user;
    }

    private function setPass($pass)
    {
        $this->pass = $pass;
    }

    private function setHost($host)
    {
        $this->host = $host;
    }

    private function setDatabase($dataBase)
    {
        $this->dataBase = $dataBase;
    }
}

?>
