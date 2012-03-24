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

