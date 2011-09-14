<?php

/**
 *	biblioteca de funções de manipulação de dados em geral
 *	
 *	@author markus vinicius da silva lima <markusslima@gmail.com>
 *	@copyright copyright © 2011, markus vinicius da silva lima.
 */

/**
 *	Verifica se o usuário está com uma sessão aberta e válida na
 *	base de dados caso não esteja redireciona o usuário para a página
 *	de login - ATENÇÃO: Necessita de uma conexão com o SGBD; a função
 * 	está no arquivo lib_db.php
 *
 *	@param string $pag_login pagina para qual será 
 *		redirecionada caso não esteja logado 
 *	@param string $pag_default pagina para qual será 
 *		redirecionada caso esteja logado mas a pagina 
 *		atual for a mesma de $pag_login
 */

function loggedUser($pag_login, $pag_default){
	/** Variável que armazena a página atual */
	$pagina = end(explode("/", $_SERVER['PHP_SELF']));

	/** Variável que armazena o marcador de erro */
	$flag = 0;

	/** Inicia os dados da sessão */
	session_start();

	/** Verifica se no array associativo $_SESSION existe a posição data */
	if (isset($_SESSION['data'])) {

		$data = $_SESSION['data'];

		try{
			$sql = 'SELECT * FROM usuarios WHERE email="'.$data['email'].'" 
						and senha="'.$data['senha'].'" and status=1';
			
			/** Executa a consulta do usuário */
			$result = executeQuery($sql);

			if ($result) {
				if (mysql_num_rows($result) == 1)
					$flag = 1;
				else
					$flag = 0;
			} else { 
				$flag = 0;
			}
		} catch (Exception $e){
			$flag = 0;
		}
	} else {
		$flag = 0;
	}
	
	/** Verifica os erros e redireciona */
	if (!$flag && $pagina != "login.php"){
		header('Location: login.php');
		exit;
	} elseif ($flag && $pagina == "login.php"){
		header('Location: '.$pag_default);
		exit;
	}
}













/*
    Função: validaEmail
    Descrição: Esta função valida um email 
    Parâmentro: String
    Retorno: true ou false
*/
function validaEmail ($email)
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    else
        return false;
}

/*
    Função: strRequire
    Descrição: Esta função verifica se uma string que está sendo
        requerida tem algum caracter fora os espaços em branco
    Parâmentro: String
    Retorno: true ou false
*/
function strRequire($str)
{
    // removendo espaços em branco
    $str = trim($str);
    if (strlen($str) == 0 || empty($str))
        return false;
    else 
        return true;
}

?>
