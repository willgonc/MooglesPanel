<?php

require_once "DataBase.php";
require_once "Validation.php";

Class Logging extends Validation
{
    /**
     *  Atributo que guarda o email
     *  @access private
     *  @name $email
     */
    private $email;

    /**
     *  Atributo que guarda a senha
     *  @access private
     *  @name $senha
     */
    private $senha;

    /**
     *  Atributo que armazena a instancia da Classe DataBase
     *  @access private
     *  @name $dataBase
     */
    private $dataBase;
   
    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
        $this->dataBase = new DataBase();
        
        session_start();

		$this->getData();
		$data = $this->validateData();
        if ($data)
        {
            $this->createSession($data);
            header("Location: summary.php");
        }
        else
        {
            $this->destroySession();
            header("Location: login.php?status=0&msg=".urlencode('Usu&aacute;rio ou senha incorretos'));
        }
		echo $data;
        $this->dataBase->closeConnect();
    }

    /**
     *  Método que armazena nos atributos os dados recebidos por post
     *  @access private
     *  @name getData()
     */
    private function getData()
    {
        $this->email = $_POST['email'];
        $this->senha = sha1($_POST['senha']);
    }
    
    /**
     *  Método que cria a sessão e armazena dos dados da mesma
	 *	@param array $data
     *  @access private
     *  @name createSession()
     */
    private function createSession($data)
    {
        $_SESSION['data'] = $data;
    }

    /**
     *  Método que encerra a sessão
     *  @access private
     *  @name destroySession()
     */
    private function destroySession()
    {
        session_destroy();
    }

    /**
     *  Método que valida os dados recebidos pelo formulário
     *  @access private
     *  @name validateData()
	 *	@return bool
     */
    private function validateData()
    {
        if (parent::strRequire($this->email) || parent::strRequire($this->senha)) 
		{
            try
			{
                $result = $this->dataBase->executeQuery('SELECT * FROM usuarios WHERE 
                    email="'.$this->email.'" and 
                    senha="'.$this->senha.'" 
                    and status=1' );
            
                if ($result) 
				{
                    if ($this->dataBase->getRows($result) == 1)
					{
						$arrData = Array();
                        while ($row = $this->dataBase->fetchResults($result))
                        {
                            $arrData['nome'] = $row['nome'];
                            $arrData['id'] = $row['id'];
                        }
                        $arrData['email'] = $this->email;
                        $arrData['senha'] = $this->senha;

                        return $this->arrData;
                    } 
					else 
                        return 0;
                } 
				else 
                    return 0;
            } 
			catch (Exception $e)
                return 0;
        } 
		else 
            return 0;
    }
}

new Logging();

?>
