<?php

require_once "DataBase.php";
require_once "Validation.php";

Class SaveConfiguration extends Validation
{

    private $email;
    private $titulo;    
    private $descricao;
    private $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
        $this->getData();

        if ($this->validateData())
        {
            $data = $this->insertData();
            //$this->redirect($data[0], $data[1]);
        }
        else
            $this->redirect(0, "O e-mail n&atilde;o &eacute; v&aacute;lido!");

        $this->dataBase->closeConnect();
    }

    private function getData()
    {
        $this->email = $_POST['email'];
        $this->titulo = $_POST['titulo'];    
        $this->descricao = $_POST['descricao'];    
    }

    private function validateData()
    {
        if (parent::strRequire($this->email))
        {
            if (parent::validaEmail($this->email))
                return 1;
            else
                return 0;
        }
        else
            return 1;
    }

    public function insertData()
    {
        $flagErro = 1;
        $msg = '';

        $this->titulo = htmlentities($this->titulo, ENT_QUOTES, "UTF-8");
        $this->descricao = htmlentities($this->descricao, ENT_QUOTES, "UTF-8");

        try {
            // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
            $update = $this->dataBase->executeQuery("UPDATE config SET 
                        email='".$this->email."',
                        descricao='".$this->descricao."',
                        titulo='".$this->titulo."'");
            if ($update)
            {
                $flagErro = 1;
                if ($msg == '')
                    $msg='As configura&ccedil;&otilde;es foram atualizadas com sucesso!';
            } 
            else 
            {
                $flagErro = 0;
                if ($msg == '')
                    $msg='N&atilde;o foi poss&iacute;vel atualizar as configura&ccedil;&otilde;es!';
            }

        } 
        catch ( Exception $e )
        {
            $flagErro = 0;
            if ($msg == '')
                $msg='N&atilde;o foi poss&iacute;vel atualizar as configura&ccedil;&otilde;es!';
        }

        return Array($flagErro, $msg);
    }

    public function redirect($flagErro, $msg)
    {
        if ($flagErro)
            header("Location: configuration.php?status=1&msg=".urlencode($msg));
        else
            header("Location: configuration.php?status=0&msg=".urlencode($msg));
    }
}

new SaveConfiguration();
?>
