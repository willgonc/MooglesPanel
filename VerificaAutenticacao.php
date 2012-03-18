<?php

/**
 *	Classe responsável por validar a sessão aberta do usuário
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
require_once "DataBase.php";

Class VerificaAutenticacao Extends DataBase
{
    
    /**
     *  Método construtor da classe
	 *
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct() 
    {
		parent::__construct();

        $session = $this->pegaSessao();
        
        if ($session)
            echo json_encode(Array("resposta" => $this->validaUsuario($session)));
        else
            echo json_encode(Array("resposta" => False));

    }

    /**
     *  Método que valida os dados da sessão aberta do usuário
	 *
     *  @param array
     *  @access private
     *  @name validaUsuario()
     *  @return bool
     */
    private function validaUsuario($data)
    {
        try{
            $sql = 'SELECT * FROM usuarios WHERE 
                email="'.$data['email'].'" and 
                senha="'.$data['senha'].'" and 
                status=1';
            
            // consulta na base os dados
            $result = parent::executeQuery($sql);

            if ($result) {
                if (parent::getRows($result) == 1)
                    return True;
                else
                    return False;
            } else { 
                return False;
            }
        } catch (Exception $e){
            return False;
        }
    }

    /**
     *  Método para retornar a sessão aberta caso tenha uma
	 *
     *  @access private
     *  @name pegaSessao()
     *  @return array|null
     */
    private function pegaSessao()
    {
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : null;
    }
}

new VerificaAutenticacao();

?>
