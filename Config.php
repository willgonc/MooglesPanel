<?php
/**
 *	Arquivo de configuração
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */
Class Config 
{
    /**
     *  Nome do usuário do banco de dados
     *  @access private
     *  @name $user
     */
    private $user;

    /**
     *  Senha do usuário do banco de dados
     *  @access private
     *  @name $pass
     */
    private $pass;

    /**
     *  Host do banco de dados
     *  @access private
     *  @name $host
     */
    private $host;

    /**
     *  Nome do banco de dados.
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
        /** setando os valores das configurações */
        $this->setUser("root");
        $this->setPass("123456");
        $this->setHost("localhost");
        $this->setDatabase("tudosobreweb");
    }

    /**
     *  Retorna o nome do usuário
     *  @access public
     *  @name getUser()
     *  @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     *  Retorna a senha do usuário
     *  @access public
     *  @name getPass()
     *  @return string
     */
    public function getPass() {
        return $this->pass;
    }
    
    /**
     *  Retorna o host do banco de dados
     *  @access public
     *  @name getHost()
     *  @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     *  Retorna o nome da base de dados
     *  @access public
     *  @name getDataBase()
     *  @return string
     */
    public function getDataBase() {
        return $this->dataBase;
    }

    /**
     *  Retorna nome do usuário
     *  @access private
     *  @name setUser()
	 *	@param string
     */
    private function setUser($user) {
        $this->user = $user;
    }

    /**
     *  Método para adicionar a senha do usuário
     *  @access private
     *  @name setPass()
	 *  @param string
     */
    private function setPass($pass) {
        $this->pass = $pass;
    }

    /**
     *  Método para adicionar o host do banco de dados
     *  @access private
     *  @name setHost()
	 *	@param string
     */
    private function setHost($host) {
        $this->host = $host;
    }

    /**
     *  Método para adicionar o nome da base de dados
     *  @access private
     *  @name setDatabase()
	 *	@param string
     */
    private function setDatabase($dataBase) {
        $this->dataBase = $dataBase;
    }
}
?>
