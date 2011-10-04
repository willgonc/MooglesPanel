<?php
/**
 *	Classe responsável por fazer a persistência dos dados
 *  do formulário de perfil
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "DataBase.php";
require_once "Validation.php";

Class SavePerfil extends Validation
{
    /**
     *  Atributo que guarda o id do formulário
     *  @access private
     *  @name $id
     */
    private $id;

    /**
     *  Atributo que guarda o nome do formulário
     *  @access private
     *  @name $nome
     */
    private $nome;

    /**
     *  Atributo que guarda o e-mail do formulário
     *  @access private
     *  @name $email
     */
    private $email;

    /**
     *  Atributo que guarda a senha do formulário
     *  @access private
     *  @name $senha
     */
    private $senha;

    /**
     *  Atributo que guarda a confirmação da senha do formulário
     *  @access private
     *  @name $confirm_senha
     */
    private $confirm_senha;
    /**
     *  Atributo que guarda o sql
     *  @access private
     *  @name $sql
     */
    private $sql;
    /**
     *  Atributo que guarda a instância do objeto DataBase
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
        $r = $this->validateData();  
        if ($r[0])
        {
            $u = $this->updateData();
            $this->redirect($u[0], $u[1]); 
        }
        else
           $this->redirect($r); 

        $this->dataBase->closeConnect();

    }

    /**
     *  Método de set dos dados do formulário
     *  @access private
     *  @name getData()
     */
    private function getData()
    {
        $this->id = is_numeric($_POST['id']);
        $this->nome = $_POST['nome'];
        $this->email = $_POST['email'];
        $this->senha = $_POST['senha'];
        $this->confirm_senha = $_POST['confirm_senha'];
    }

    /**
     *  Método que valida os dados para persistência
     *  @access private
     *  @name validateData()
     *  @return array
     */
    private function validateData()
    {
        $flagErro = 1;
        $msg = "";

        if (!parent::strRequire($this->nome) || !parent::strRequire($this->email))
        {
            $flagErro = 0;
            $msg = "Preencha todos os campos obrigat&oacute;rios!";
        } 
        else if (!parent::validaEmail($this->email))
        {
            $flagErro = 0;
            if ($msg == '')
                $msg = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        }
        else if (parent::strRequire($this->senha) || parent::strRequire($this->confirm_senha))
        {
            if ($this->senha != $this->confirm_senha)
            {
                $flagErro = 0;
                if ($msg == '')
                    $msg = "Confirme a senha corretamente!";
            }

            if (strlen($this->senha) < 6)
            {
                $flagErro = 0;
                if ($msg == '')
                    $msg = "A senha deve ter no m&iacute;nimo 6 caracteres!";
            }
        }

        return Array($flagErro, $msg);
    }
    
    /**
     *  Método que monta a sql de acordo com os dados recebidos
     *  @access private
     *  @name mountSql()
     *  @return string
     */
    private function mountSql()
    {
        $this->nome = htmlentities($this->nome, ENT_QUOTES, "UTF-8");
        $this->senha = sha1($this->senha);

        if (parent::strRequire($this->senha))
            $this->sql = "UPDATE usuarios SET nome='".$this->nome."', email='".$this->email."', senha='".$this->senha."' WHERE id=".$this->id;
        else
            $this->sql = "UPDATE usuarios SET nome='".$this->nome."', email='".$this->email."' WHERE id=".$this->id;
    }

    /**
     *  Método de set dos dados do formulário
     *  @access private
     *  @name getSession()
     */
    private function getSession()
    {
        session_start();
        return $_SESSION['data'];
    }

    /**
     *  Método de set dos dados do formulário
     *  @access private
     *  @name updateData()
     *  @return array
     */
    private function updateData()
    {
        $flagErro = 1;
        $msg = '';
        try 
        {
            $this->mountSql();
            if ($this->dataBase->executeQuery($this->sql)) 
            {

                $data = $this->getSession();
                session_destroy();
                session_start();

                if (parent::strRequire($this->senha))
                {
                    $_SESSION['data'] = Array(
                            'id' => $this->id,
                            'email' => $this->email, 
                            'senha' => $this->senha, 
                            'nome' => $this->nome
                        );
                } 
                else {
                    $_SESSION['data'] = Array( 
                            'id' => $this->id,
                            'email' => $email, 
                            'senha' => $data['senha'],
                            'nome' => $nome
                        );
                }

                $flagErro = 1;
                if ($msg == '')
                    $msg = "Seu perfil foi atualizado!";
            } 
            else 
            {
                $flagErro = 0;
                if ($msg == '')
                    $msg = "Erro ao atualizar o perfil!";
            }
        } 
        catch ( Exception $e )
        {
            $flagErro = 0;
            if ($msg == '')
                $msg = "Erro ao atualizar o perfil!";
        }

        return Array($flagErro, $msg);
    }

    /**
     *  Método de set dos dados do formulário
     *  @param bool $flagErro
     *  @param string $msg
     *  @access private
     *  @name redirect()
     */
    private function redirect($flagErro, $msg)
    {
        if ($flagErro)
            header("Location: perfil.php?status=1&msg=".urlencode($msg));
        else
            header("Location: perfil.php?status=0&msg=".urlencode($msg));
    }
}

new SavePerfil();
?>

