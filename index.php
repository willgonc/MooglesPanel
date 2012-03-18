<?php

require_once "Config.php";

Class Despachante Extends Config
{
    /**
     *  Método construtor da classe
	 *
     *  @access public
     *  @name __construct()
     */
    public function __construct()
    {
		parent::__construct();
		header("Location: ./modulos/".$this->pegaAcao()."/");
    }

    /**
     *  Método que pega a acao, caso não seja passada nenhuma ação
	 *	retorna o valor padrão definido no arquivo de configurações
	 *
     *  @access public
     *  @name __construct()
     */
	private function pegaAcao()
	{
		if (isset($_GET['acao']))
		{
			return $_GET['acao'];
		}
		else
		{
			return parent::getModuloPadrao();
		}
	}
}

new Despachante();

?>
