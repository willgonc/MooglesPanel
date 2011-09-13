<?php

/**
 *	Biblioteca de funções de manipulação da base de dados
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */


/*
 *	Abre a conexão com o SGBD e seleciona a base de dados
 *	
 *	Retorna o link da conexão
 *	@return link
 */
function openConnectDB(){
	/**	Armazena o link da conexao */
	$link = mysql_connect(HOST, USER, PASS);

	/** Seleciona a base de dados */
	mysql_select_db(DATA_BASE);

	/** Retornando a conexão*/
	return $link;
}

?>
