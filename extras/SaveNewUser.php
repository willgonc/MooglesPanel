<?php
/**
 *	Classe responsável por salvar os dados das configurações do painel
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "DataBase.php";
require_once "Validation.php";

Class SaveNewUser extends Validation
{
    /**
     *  Atributo que armazena o nome
     *  @access private
     *  @name $nome
     */
    private $nome;
    
    /**
     *  Atributo que armazena o email
     *  @access private
     *  @name $email
     */
    private $email;
    
    /**
     *  Atributo que armazena o senha
     *  @access private
     *  @name $senha
     */
    private $senha;
    
    /**
     *  Atributo que armazena o confirm_senha
     *  @access private
     *  @name $confirm_senha
     */
    private $confirm_senha;
    
    /**
     *  Atributo que armazena a instância do objeto DataBase
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
        $this->getData();

        $data = $this->validateData();
        if ($data[0])
        {
            $checkmail = $this->checkEmail();
            if ($checkmail[0])
            {
                $insert = $this->insertData();
                if ($insert[0])
                    $this->redirect($insert[0], 'Usu&aacute;rio cadastrado com sucesso!');
                else
                    $this->redirect($insert[0], $checkmail[1]);
            }
            else
                $this->redirect($checkmail[0], $checkmail[1]);
            
        }
        else
            $this->redirect($data[0], $data[1]);

        $this->dataBase->closeConnect();
    }

    /**
     *  Método que recebe os dados
     *  @access private
     *  @name getData()
     */
    private function getData()
    {
        $this->nome = $_POST['nome'];
        $this->email = $_POST['email'];
        $this->senha = $_POST['senha'];
        $this->confirm_senha = $_POST['confirm_senha'];
    }

    /**
     *  Método que valida os dados para persitência
     *  @access private
     *  @name validateData()
     */
    private function validateData()
    {
        $flagErro = 1;
        $msg = "";

        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email) || !parent::strRequire($this->senha) || !parent::strRequire($this->confirm_senha))
        {
            $flagErro = 0;
            $msg = "Preencha todos os campos do formul&aacute;rio!";
        }
        else if (!parent::validaEmail($this->email))
        {
            $flagErro = 0;
            if ($msg == '')
                $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        }
        else if ($this->senha != $this->confirm_senha)
        {
            $flagErro = 0;
            if ($msg == '')
               $msg = "Confirme a senha corretamente!";
        }
        else if (strlen($this->senha) < 6)
        {
            $flagErro = 0;
            if ($msg == '')
                $msg = "A senha deve ter no m&iacute;nimo 6 caracteres!";
        }
        return Array($flagErro, $msg);
    }

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    public function checkEmail()
    {
        $flagErro = 1;
        $msg = '';

        try {
            $result = $this->dataBase->executeQuery("SELECT * FROM usuarios WHERE email='".$this->email."'");
            if ($result) 
            {
                if ($this->dataBase->getRows($result) >= 1)
                {
                    $flagErro = 0;
                    if ($msg == '')
                        $msg = "Este e-mail j&aacute; est&aacute; cadastrado!";
                }
                else
                {
                    $flagErro = 1;
                    if ($msg == '')
                        $msg = "";
                }
            } 
            else 
            {
                $flagErro = 0;
                if ($msg == '')
                    $msg = "Erro ao cadastrar usuário!";
            }
        } 
        catch ( Exception $e )
        {
            $flagErro = 0;
            if ($msg == '')
                $msg = "Erro ao cadastrar usuário!";
        }
        return Array($flagErro, $msg);
    }

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    private function insertData()
    {
        $this->senha = sha1($this->senha);

        $this->nome = htmlentities($this->nome, ENT_QUOTES, "UTF-8");
        try {
            // FAZ A ATUALIZACAO DA TABELA configuracoes NA BASE
            $insert = mysql_query("INSERT INTO usuarios (nome, email, senha, status) 
                        VALUES ('".$this->nome."','".$this->email."', '".$this->senha."', 0)");
            
            if ($insert) {
                $flagErro = 1; 
                if ($msg == '')
                    $msg = "O usu&aacute;rio foi adicionado!";
            } else {
                $flagErro = 0;
                if ($msg == '')
                    $msg = "Erro ao adicionar o usu&aacute;rio!";
            }
        } catch ( Exception $e ){
            $flagErro = 0;
            if ($msg == '')
                $msg = "Erro ao adicionar o usu&aacute;rio!";
        }
        return Array($flagErro, $msg);
    }

    /**
     *  Método construtor da classe
     *  @access public
     *  @name __construct()
     */
    private function redirect($flagErro, $msg)
    {
        if ($flagErro)
            header("Location: new_user.php?status=1&msg=".urlencode($msg));
        else 
            header("Location: new_user.php?status=0&msg=".urlencode($msg));
    }
}
new SaveNewUser();

?>

