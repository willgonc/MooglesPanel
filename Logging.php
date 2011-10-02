<?php

require_once "DataBase.php";
require_once "Validation.php";


Class Logging extends Validation
{
    private $email;
    private $senha;
    private $msg;
    private $result;
    private $arrData = Array();
    private $dataBase;
    
    public function __construct()
    {
        $this->dataBase = new DataBase();

        $this->email = $this->getEmailPost();
        $this->senha = $this->getSenhaPost();

        if ($data = $this->validateData())
        {
            $this->createSession($data);
            header("Location: summary.php");
        }
        else
        {
            $this->destroySession();
            header("Location: login.php");
        }

        $this->dataBase->closeConnect();
    }

    private function getEmailPost()
    {
        return $_POST['email'];
    }

    private function getSenhaPost()
    {
        return sha1($_POST['senha']);
    }
    
    private function createSession($data)
    {
        session_start();
        $_SESSION['data'] = $data;
    }

    private function destroySession()
    {
        session_destroy();
    }

    private function validateData()
    {
        if (parent::strRequire($this->email) || parent::strRequire($this->senha)) {
            try{
                $this->result = $this->dataBase->executeQuery('SELECT * FROM usuarios WHERE 
                    email="'.$this->email.'" and 
                    senha="'.$this->senha.'" 
                    and status=1' );
            
                if ($this->result) {
                    if ($this->dataBase->getRows($this->result) == 1){
                        $row = Array();
                        while ($row = $this->dataBase->fetchResults($this->result))
                        {
                            $this->arrData['nome'] = $row['nome'];
                            $this->arrData['id'] = $row['id'];
                        }
                        $this->arrData['email'] = $this->email;
                        $this->arrData['senha'] = $this->senha;

                        return $this->arrData;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } catch (Exception $e){
                return 0;
            }
        } else {
            return 0;
        }
    }
}

new Logging();

?>
