<?php

/**
 *	Biblioteca de funções de manipulação da base de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */


/**
 *	Abre a conexão com o SGBD e seleciona a base de dados
 *	
 *	Retorna o link da conexão
 *	@return string|false retorna um identificador de conexao ou 
 *      false em caso de falha
 */
function openConnect(){
    /** Importanto arquivo de configuração */
    require_once "config.php";

	/**	Armazena o link da conexao */
	$link = mysql_connect(HOST, USER, PASS);

	/** Seleciona a base de dados */
	mysql_select_db(DATA_BASE);

	/** Retornando a conexão*/
	return $link;
}

/**
 *	Fecha uma conexão com o SGBD
 *	
 *	@param string $link identificador da conexão com o SGBD
 *
 */
function closeConnect($link){
    mysql_close($link);
}

/**
 *	Executa uma sql e retorna o resultado ou no caso de error ou exceção
 *  retorna um sql ou a exceção
 *	
 *	@param string $sql string em formato sql
 *	@param string $link identificador da conexão com o SGBD
 *
 *  @return resource|bool resultado da query, error ou exceção
 */
function executeQuery($sql){
    try {
        /** Executa uma sql */
        $result = mysql_query($sql);

        /** Testa se o resultado da query */
        if ($result)
            /** Retorna o resultado */
            return $result;
        else
            /** Retorna o erro de sql */
            return mysql_error();
    } catch (Exception $e){
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
function fetchResults($result){
    return mysql_fetch_array($result, MYSQL_BOTH);
}

?>
