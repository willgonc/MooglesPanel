<?php

Class Logged
{
    private $dataBase;
    public function __construct($objDb) 
    {
        $this->dataBase = $objDb;
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

    private function getSession()
    {
        session_start();
        return isset($_SESSION['data']) ? $_SESSION['data'] : 0;
    }
}
?>
