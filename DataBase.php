<?php

/**
 *	Classe responsável pelas funçoes de manipulação do banco de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
require_once "Config.php";

Class DataBase extends Config
{
    /**
     *  Atributo que guarda o id da conexão com o banco de dados
     *  @access private
     *  @name $link
     */
    private $link;
	
    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
		/** Chamando o construtor da Classe herdada*/
        parent::__construct();
        $this->openConnect();
        $this->selectDataBase();
    }
    
    /**
     *  Método que atribui o id da conexão ao atributo $link
	 *	@param string $link
     *  @access private
     *  @name setLink()
     */
    private function setLink($link)
    {
        $this->link = $link;
    }

    /**
     *  Método que retorna o atributo $link
     *  @access public
     *  @name setLink()
	 *	@return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     *	Abre a conexão com o SGBD e armazena no atributo $link
	 *	@access private
	 *	@name openConnect()
     */
    private function openConnect()
    {
        $this->setLink(mysql_connect(parent::getHost(), parent::getUser(), parent::getPass()));
    }

    /**
     *	Seleciona a base de dados
	 *	@access private
	 *	@name selectDataBase()
     */
    private function selectDataBase()
    {
        mysql_select_db(parent::getDataBase());
    }

    /**
     *	Fecha a conexão com a base de dados
	 *	@access public
	 *	@name closeConnect()
     */
    public function closeConnect()
    {
        mysql_close($this->link);
    }

    /**
     *	Executa uma sql e retorna o resultado
     *	@param string $sql
	 *	@access public
	 *	@name executeQuery()
     *  @return resource|bool
     */
    public function executeQuery($sql)
    {
        try 
        {
            $result = mysql_query($sql);
            return $result;
        } 
        catch (Exception $e)
        {
            return $e;
        }
    }

    /**
     *  Retorna um array associativo ou indexado do resultado da query
     *	@param result $result 
	 *	@access public
	 *	@name fetchResults()
     *  @return array
     */
    public function fetchResults($result)
    {
        return mysql_fetch_array($result, MYSQL_BOTH);
    }

    /**
     *  Retorna a quantidade de linhas de uma consulta
     *	@param result $result 
	 *	@access public
	 *	@name getRows()
     *  @return int
     */
    public function getRows($result)
    {
        return mysql_num_rows($result);
    }
}

?>
