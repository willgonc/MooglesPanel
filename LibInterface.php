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
     *  Método que retorna o html do menu principal
     *  @access private
     *  @name $getHtmlMenuPrincipal()
     *  @return string
     */
    public function getHtmlMenuPrincipal()
    {
        $data = $this->getSession();
        return '<div class="tw-ui-menu-principal">
                 <img src="imagens/tw.png" />
                 <div class="item-menu"><a href="summary.php">Resumo</a></div>
                 <div class="item-menu">
                     <a href="posts.php">Posts</a>
                     <div class="submenu tw-ui-submenu">
                         <p><a href="posts.php">Todos os posts</a></p>
                         <p><a href="new_post.php">Adicionar post</a></p>
                         <p><a href="categories.php">Categorias</a></p>
                     </div>
                 </div>
                 <div class="item-menu">
                     <a href="#">Usu&aacute;rios</a>
                     <div class="submenu tw-ui-submenu">
                         <p><a href="users.php">Todos os usu&aacute;rios</a></p>
                         <p><a href="new_user.php">Adicionar usu&aacute;rio</a></p>
                     </div>
                 </div>
                 <div class="item-menu"><a href="configuration.php">Configura&ccedil;&otilde;es</a></div>
                 <div class="item-menu">
                     <a href="#">Ajuda</a>
                     <div class="submenu tw-ui-submenu">
                         <p><a href="manual.php">Manual</a></p>
                         <p><a href="about.php">Sobre</a></p>
                     </div>
                 </div>
                 <div class="tw-ui-user-logged item-menu">
                     <a href="#">'.$data['nome'].'</a>
                     <div class="submenu-right submenu">
                         <p><a href="perfil.php">Perfil</a></p>
                         <p><a href="Logout.php">Sair</a></p>
                     </div>
                 </div>
         </div>';
    }

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
}

?>
