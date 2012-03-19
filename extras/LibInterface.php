<?php

/**
 *	Classe para manipulação de dados de interface
 *	
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 *	@copyright Copyright © 2011, Markus Vinicius da Silva Lima.
 */
Class LibIterface
{

    /**
     *  Método que retorna o html do título do conteúdo da página
     *  @param $string
     *  @access private
     *  @name $getHtmlCabecalho()
     *  @return string
     */
    public function getHtmlCabecalho($title)
    {
        return '<div class="tw-ui-cabecalho">'.(isset($title)?htmlentities($title, ENT_QUOTES, 'UTF-8'):'').'</div>';
    }

    /**
     *  Método que retorna os dados da sessão aberta do usuário
     *  @access private
     *  @name $getSession()
     *  @return array|null
     */
    public function getSession()
    {
        return isset($_SESSION['data'])?$_SESSION['data']:null;
    }

    /**
     *  Método que retorna o html para exibição da mensagem
     *  @access private
     *  @name $getMessage()
     *  @return string
     */
    public function getMessage()
    {
        $status = isset($_GET['status'])?$_GET['status']:'';
        $msg = isset($_GET['msg'])?$_GET['msg']:'';

        if ($msg != '' && $status != '')
        {
            if ($status == 0)
                return '<div class="tw-ui-mensagem"><p class="errorMsg">'.urldecode($msg).'</p></div>';
            elseif ($status == 1) 
                return '<div class="tw-ui-mensagem"><p class="okMsg">'.urldecode($msg).'</p></div>';
        }
        else
        {
            return '';
        }
    }

    /**
     *  Método que retorna o html do formulário de busca das listagens
     *  @access private
     *  @param $action Nome do arquivo que trata os dados
     *  @param $method Método de envio dos dados
     *  @param $name Nome do formulário
     *  @param $size Tamanho do campo de busca
     *
     *  @name $getHtmlFormSearch()
     *  @return string
     */
    public function getHtmlFormSearch($action, $method, $name, $size){
        $action = (isset($action)?'action="'.$action.'"':'');
        $method = (isset($method)?'method="'.$method.'"':'');
        $name = (isset($name)?'name="'.$name.'"':'');
        $size = (isset($size)?'size="'.$size.'"':'size="20"');

        return '<div class="tw-ui-busca">
                   <form '.$action.' '.$method.' '.$name.'>
                       <input type="text" class="input-text" '.$size.' name="busca" value="'.(isset($_GET['busca'])?$_GET['busca']:'').'" />
                       <input type="image" class="input-image" src="imagens/search.png" />
                   </form>
               </div>';
    }
}

?>
