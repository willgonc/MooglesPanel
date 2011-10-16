<?php

require_once "DataBase.php";

Class RemoveUsers extends DataBase
{

    private $usuarios;
    private $pag;
    private $busca;

    public function __construct()
    {
        parent::__construct();

        $this->usuarios = $_POST['usuarios'];
        $this->pag = $_POST['pag'];
        $this->busca = $_POST['busca'];
        
        $r = $this->deleteUsers();
        $this->redirect($r);
        parent::closeConnect();
    }

    private function deleteUsers()
    {
        $flag = 1;
        for ($i = 0; $i < count($this->usuarios); $i++){
            try{
                $r = parent::executeQuery('DELETE FROM usuarios WHERE id='.$this->usuarios[$i]);
                if (!$r)
                    $flag = 0;
            } catch (Exception $e){
                $flag = 0;
            }

            if ($flag == 0)
            {   
                return $flag;
            }
        }
        return $flag;
    }

    private function redirect($flag)
    {
        $msg = '';
        $status = 1;
        if ($flag == 1)
        {
            $erro = true;
            if (count($this->usuarios) == 1)
            {
                $msg    = 'O usu&aacute;rio foi removido!';
                $status = 1;
            } 
            else 
            {
                $msg    = 'Todos os usu&aacute;rios foram removidos!';
                $status = 1;
            }
        } 
        else 
        {
            $erro = false;
            if (count($this->usuarios) == 1)
            {
                $msg    = 'Erro ao remover o usu&aacute;rio!'; 
                $status = 0;
            } 
            else 
            {
                $msg    = 'Erro ao remover os usu&aacute;rios!'; 
                $status = 0;
            }
        }
        echo 'users.php?pag='.$this->pag.'&busca='.$this->busca.'&msg='.urlencode($msg).'&status='.$status;
    }
}

new RemoveUsers();


?>

