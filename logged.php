<?php

Class Logged
{
    private $flag = 0;
    private $sql;
    private $result;
    private $pagina; 

    public function validateUser($objDb) {
        session_start();
        $this->pagina = end(explode("/", $_SERVER['PHP_SELF']));

        if (isset($_SESSION['data'])) { 
            $data = $_SESSION['data'];

            try{
                $sql = 'SELECT * FROM usuarios WHERE email="'.$data['email'].'" 
                            and senha="'.$data['senha'].'" and status=1';
                
                // consulta na base os dados
                $result = $objDb->executeQuery($sql);

                if ($result) {
                    if (getRows($result) == 1)
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

        if ($flag == 0 && $pagina != "login.php")
            header('Location: login.php');
        else if ($flag == 1 && $pagina == "login.php")
            header('Location: summary.php');
    }
}
?>
