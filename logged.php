<?php

Class Logged
{
    private $flag;
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
                        $this->flag = 1;
                    else
                        $this->flag = 0;
                } else { 
                    $this->flag = 0;
                }
            } catch (Exception $e){
                $this->flag = 0;
            }
        } else {
            $this->flag = 0;
        }

        if ($this->flag == 0 && $this->pagina != "login.php")
            header('Location: login.php');
        else if ($this->flag == 1 && $this->pagina == "login.php")
            header('Location: summary.php');
    }
}
?>
