<?php
/**
 *	Classe responsável por salvar os dados das configurações do painel
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */

require_once "DataBase.php";
require_once "Validation.php";

Class SaveConfiguration extends Validation
{
    /**
     *  Atributo que armazena o email
     *  @access private
     *  @name $email
     */
    private $email;
    /**
     *  Atributo que armazena o título
     *  @access private
     *  @name $titulo
     */
    private $titulo;    
    /**
     *  Atributo que armazena a descricao
     *  @access private
     *  @name $descricao
     */
    private $descricao;
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

        if ($this->validateData())
        {
            $data = $this->updateData();
            $this->redirect($data[0], $data[1]);
        }
        else
            $this->redirect(0, "O e-mail n&atilde;o &eacute; v&aacute;lido!");

        $this->dataBase->closeConnect();
    }

    /**
     *  Método que recebe os dados do formulário e armazena nos métodos
     *  @access private
     *  @name getData()
     */
    private function getData()
    {
        $this->email = $_POST['email'];
        $this->titulo = $_POST['titulo'];    
        $this->descricao = $_POST['descricao'];    
    }

    /**
     *  Método que valida os dados para persitência
     *  @access private
     *  @name validateData()
     *  @return bool
     */
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

    /**
     *  Método que faz a persistência dos dados na base
     *  @access private
     *  @name updateData()
     *  @return array
     */
    public function updateData()
    {
        $flagErro = 1;
        $msg = '';

        $this->titulo = htmlentities($this->titulo, ENT_QUOTES, 'UTF-8');
        $this->descricao = htmlentities($this->descricao, ENT_QUOTES, 'UTF-8');

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

    /**
     *  Método que redireciona para a página de configurações
     *  @param bool $flagErro
     *  @param string $msg
     *  @access private
     *  @name redirect()
     */
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
