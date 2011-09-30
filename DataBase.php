<?php

/**
 *	Classe de manipulação da base de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "Config.php";

Class DataBase extends Config
{
    // guarda o link com conexão
    private $link;

    public function __construct()
    {
        parent::__construct();
        $this->openConnect();
        $this->selectDataBase();
    }
    
    private function setLink($link)
    {
        $this->link = $link;
    }

    public function getLink()
    {
        return $this->link;
    }

    /**
     *	Abre a conexão com o SGBD e seleciona a base de dados
     *	
     *	Retorna o link da conexão
     *	@return string|false retorna um identificador de conexao ou 
     *      false em caso de falha
     */
    private function openConnect()
    {
        /**	Armazena o link da conexao */
        $this->setLink(mysql_connect(parent::getHost(), parent::getUser(), parent::getPass()));
    }

    private function selectDataBase()
    {
        /** Seleciona a base de dados */
        mysql_select_db(parent::getDataBase());
    }

    /**
     *	Fecha uma conexão com o SGBD
     *	
     *	@param string $link identificador da conexão com o SGBD
     *
     */
    public function closeConnect()
    {
        mysql_close($this->link);
    }

    /**
     *	Executa uma sql e retorna o resultado ou no caso de error ou exceção
     *  retorna um sql ou a exceção
     *	
     *	@param string $sql string em formato sql
     *
     *  @return resource|bool resultado da query ou exceção
     */
    public function executeQuery($sql)
    {
        try 
        {
            /** Executa uma sql */
            $result = mysql_query($sql);

            /** Retorna o resultado */
            return $result;
        } 
        catch (Exception $e)
        {
            /** Retorna uma exceção caso ocorra */
            return $e;
        }
    }

    /**
     *  Retorna um array associativo do resultado da query
     *	
     *	@param string $result resultado de uma query
     *
     *  @return array Retorna um array associativo ou numerico correspondente a linha
     */
    public function fetchResults($result)
    {
        return mysql_fetch_array($result, MYSQL_BOTH);
    }

    public function getRows($result)
    {
        return mysql_num_rows($result);
    }
}

?>
