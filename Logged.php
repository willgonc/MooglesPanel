<?php

/**
 *	Classe responsável por validar a sessão aberta do usuário
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class Logged
{
    
    /**
     *  Atributo que guarda a instância do objeto DataBase
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;

    /**
     *  Método construtor da classe
     *  @param object
     *  @access public
     *  @name __construct()
     */
    public function __construct($objDataBase) 
    {
        $this->dataBase = $objDataBase;
        $pagina = end(explode("/", $_SERVER['PHP_SELF']));
        $session = $this->getSession();
        
        if ($session)
            $flag = $this->validationUser($session);
        else
            $flag = 0;

        if ($flag == 0 && $pagina != "login.php")
            header('Location: login.php');
        else if ($flag == 1 && $pagina == "login.php")
            header('Location: summary.php');
    }

    /**
     *  Método que valida os dados da sessão aberta do usuário
     *  @param array
     *  @access private
     *  @name validationUser()
     *  @return bool
     */
    private function validationUser($data)
    {
        try{
            $sql = 'SELECT * FROM usuarios WHERE 
                email="'.$data['email'].'" and 
                senha="'.$data['senha'].'" and 
                status=1';
            
            // consulta na base os dados
            $result = $this->dataBase->executeQuery($sql);

            if ($result) {
                if ($this->dataBase->getRows($result) == 1)
                    return 1;
                else
                    return 0;
            } else { 
                return 0;
            }
        } catch (Exception $e){
            return 0;
        }
    }

    /**
     *  Método para retornar a sessão aberta caso tenha uma
     *  @access private
     *  @name getSession()
     *  @return array|null
     */
    private function getSession()
    {
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : null;
    }
}
?>
