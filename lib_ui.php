<?php

/* 
funcao: printMenu
*/
function printMenu(){
        print '<div class="tw-ui-menu-principal">
            <!--ul>
                <li><a href="resumo.php">Resumo</a></li>
                <li><a href="usuarios.php">Usu&aacute;rios</a></li>
                <li><a href="configuracoes.php">Configura&ccedil;&otilde;es</a></li>
            </ul-->
                <a href="resumo.php"><div>Resumo</div></a>
                <a href="posts.php"><div>Posts</div></a>
                <a href="usuarios.php"><div>Usu&aacute;rios</div></a>
                <a href="configuracoes.php"><div>Configura&ccedil;&otilde;es</div></a>
        </div>';
}

/* 
funcao: printMenu
*/
function printCabecalho($title){
    print '<div class="tw-ui-cabecalho">
            <img src="imagens/tw.png" />
          '.$title.'
          <a class="tw-ui-user-logged" href="logout.php">Sair</a>
          <span class="tw-ui-user-logged">'.$_SESSION['data']['email'].'</span>
          </div>';
}
?>
