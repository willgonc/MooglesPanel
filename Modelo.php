<?php

/**
 *	Arquivo de funções de manipulação do banco de dados
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */
require_once "Config.php";

Class Modelo extends Config {
    /**
     *  Id da conexão com o banco de dados
     *  @access private
     *  @name $link
     */
    private $link;
	
    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct() {
		parent::__construct();
		$this->openConnect();
		$this->selectDataBase();
    }

    /**
     *	Abre a conexão com o SGBD e armazena no atributo $link
	 *	@access private
	 *	@name openConnect()
     */
    private function openConnect() {
        $this->link = mysql_connect(parent::getHost(), parent::getUser(), parent::getPass());
    }

    /**
     *	Seleciona a base de dados
	 *	@access private
	 *	@name selectDataBase()
     */
    private function selectDataBase() {
        mysql_select_db(parent::getDataBase());
    }

    /**
     *	Fecha a conexão com a base de dados
	 *	@access public
	 *	@name closeConnect()
     */
    public function closeConnect() {
        mysql_close($this->link);
    }

    /**
     *	Executa uma sql e retorna o resultado
     *	@param string $sql
	 *	@access public
	 *	@name executeQuery()
     *  @return resource|bool
     */
    public function executeQuery($sql) {
        try {
            $result = mysql_query($sql);
            return $result;
        } catch (Exception $e) {
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
    public function fetchResults($result) {
        return mysql_fetch_array($result, MYSQL_BOTH);
    }

    /**
     *  Retorna a quantidade de linhas de uma consulta
     *	@param result $result 
	 *	@access public
	 *	@name getNumRows()
     *  @return int
     */
    public function getNumRows($result) {
        return mysql_num_rows($result);
    }
}

?>
