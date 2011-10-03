<?php
/**
 *	Classe responsável pelas configurações de conexão com o banco de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class Config 
{
    /**
     *  Atributo que guarda o nome do usuário do banco de dados
     *  @access private
     *  @name $user
     */
    private $user;

    /**
     *  Atributo que guarda a senha do usuário do banco de dados
     *  @access private
     *  @name $pass
     */
    private $pass;

    /**
     *  Atributo que guarda o nome do host do banco de dados
     *  @access private
     *  @name $host
     */
    private $host;

    /**
     *  Atributo que guarda o nome da base de dados
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
        /** setando os valores das configurações */
        $this->setUser("root");
        $this->setPass("123456");
        $this->setHost("localhost");
        $this->setDatabase("tudosobreweb");
    }

    /**
     *  Método que retorna o atributo nome do usuário
     *  @access public
     *  @name getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *  Método que retorna o atributo senha do usuário
     *  @access public
     *  @name getPass()
     */
    public function getPass()
    {
        return $this->pass;
    }
    
    /**
     *  Método que retorna o atributo host do banco de dados
     *  @access public
     *  @name getHost()
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     *  Método que retorna o atributo nome da base de dados
     *  @access public
     *  @name getDataBase()
     */
    public function getDataBase()
    {
        return $this->dataBase;
    }

    /**
     *  Método para adicionar o nome do usuário
     *  @access private
     *  @name setUser()
     */
    private function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *  Método para adicionar a senha do usuário
     *  @access private
         *  @name setPass()
     */
    private function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     *  Método para adicionar o host do banco de dados
     *  @access private
     *  @name setHost()
     */
    private function setHost($host)
    {
        $this->host = $host;
    }

    /**
     *  Método para adicionar o nome da base de dados
     *  @access private
     *  @name setDatabase()
     */
    private function setDatabase($dataBase)
    {
        $this->dataBase = $dataBase;
    }
}
?>
