<?php
/**
 *	Classe responsável pelas configurações
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */
Class Config 
{
    /**
     *  Atributo que guarda o nome do usuário do banco de dados
	 *
     *  @access private
     *  @name $user
     */
    private $user;

    /**
     *  Atributo que guarda a senha do usuário do banco de dados
	 *
     *  @access private
     *  @name $pass
     */
    private $pass;

    /**
     *  Atributo que guarda o nome do host do banco de dados
	 *
     *  @access private
     *  @name $host
     */
    private $host;

    /**
     *  Atributo que guarda o nome da base de dados.
	 *
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;

    /**
     *  Atributo que guarda o nome do módulo padrão, esse
	 *	modulo será chamado quando o despachante nao receber
	 *	a ação.
	 *
     *  @access private
     *  @name $moduloPadrao
     */
    private $moduloPadrao;

    /**
     *  Método construtor da classe
	 *
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
        
		$this->setModuloPadrao("principal");
    }

    /**
     *  Método que retorna o atributo nome do usuário
	 *
     *  @access public
     *  @name getUser()
     *  @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *  Método que retorna o atributo senha do usuário
	 *
     *  @access public
     *  @name getPass()
     *  @return string
     */
    public function getPass()
    {
        return $this->pass;
    }
    
    /**
     *  Método que retorna o atributo host do banco de dados
	 *
     *  @access public
     *  @name getHost()
     *  @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     *  Método que retorna o atributo nome da base de dados
	 *
     *  @access public
     *  @name getDataBase()
     *  @return string
     */
    public function getDataBase()
    {
        return $this->dataBase;
    }

    /**
     *  Método que retorna o atributo moduloPadrao
	 *
     *  @access public
     *  @name getModuloPadrao()
     *  @return string
     */
    public function getModuloPadrao()
    {
        return $this->moduloPadrao;
    }

    /**
     *  Método para adicionar o nome do usuário
	 *
     *  @access private
     *  @name setUser()
     */
    private function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *  Método para adicionar a senha do usuário
	 *
     *  @access private
     *  @name setPass()
     */
    private function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     *  Método para adicionar o host do banco de dados
	 *
     *  @access private
     *  @name setHost()
     */
    private function setHost($host)
    {
        $this->host = $host;
    }

    /**
     *  Método para adicionar o nome da base de dados
	 *
     *  @access private
     *  @name setDatabase()
     */
    private function setDatabase($dataBase)
    {
        $this->dataBase = $dataBase;
    }
    
	/**
     *  Método para adicionar o nome do módulo padrão
	 *
     *  @access private
     *  @name setModuloPadrao()
     */
    private function setModuloPadrao($modulo)
    {
        $this->moduloPadrao = $modulo;
    }
}
?>
