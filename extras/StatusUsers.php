<?php
require_once "DataBase.php";

Class StatusUsers extends DataBase
{
    private $usuarios;
    private $stat;
    private $pag;
    private $busca;

    public function __construct()
    {
        parent::__construct();
        
        $this->usuarios = $_POST['usuarios'];
        $this->stat = $_POST['estado'];
        $this->pag = $_POST['pag'];
        $this->busca = $_POST['busca'];
        
        $r = $this->alterUser();

        $this->redirect($r);

        parent::closeConnect();
    }

    private function alterUser()
    {
        $flag = 1;

        for ($i = 0; $i < count($this->usuarios); $i++)
        {
            if($this->stat == 1 || $this->stat == 0)
            {
                try
                {
                    $update = parent::executeQuery("UPDATE usuarios SET status=".$this->stat." WHERE id=".$this->usuarios[$i]);
                    if (!$update)
                        $flag = 0;
                } 
                catch( Exception $e )
                {
                    $flag = 0;
                }
            } 
            else
                $flag = 0;
        }
        return $flag;
    }

    private function redirect($flag)
    {
        if ($flag == 1)
        {
            $erro = true;
            if (count($this->usuarios) == 1)
            {
                $msg = 'O usuario foi alterado!';
                $status = 1;
            } 
            else 
            {
                $msg = 'Todos os usuarios foram alterados!';
                $status = 1;
            }
        } 
        else 
        {
            $erro = false;
            if (count($this->usuarios) == 1)
            {
                $msg = 'Erro ao alterar o usu&aacute;rio!'; 
                $status = 0;
            } 
            else 
            {
                $msg = 'Erro ao alterar os usu&aacute;rios!'; 
                $status = 0;
            }
        }

        echo 'users.php?pag='.$this->pag.'&busca='.$this->busca.'&msg='.urlencode($msg).'&status='.$status;
    }
}

new StatusUsers();
?>


