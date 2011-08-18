<?php

/* 
funcao: printMenu
*/
function printMenu(){
        print '<div class="tw-ui-menu-principal">
                <a href="resumo.php" class="1"><div>Resumo</div></a>
                <a href="posts.php" class="2"><div>Posts</div></a>
                <a href="usuarios.php" class="3"><div>Usu&aacute;rios</div></a>
                <a href="configuracoes.php" class="4"><div>Configura&ccedil;&otilde;es</div></a>
        </div>';
}

/* 
funcao: printMenu
*/
function printCabecalho($title){
    print '<div class="tw-ui-cabecalho">
            <img src="imagens/tw.png" />
          '.(isset($title)?$title:'').'
          <a class="tw-ui-user-logged" href="logout.php">Sair</a>
          <span class="tw-ui-user-logged">'.$_SESSION['data']['email'].'</span>
          </div>';
}


function printMenuMod($list){
    $str = '<ul class="tw-ui-menu-mod">';
        if (count($list) > 0){
            for ($i = 0; $i < count($list); $i++){
                $str .= '<li><a href="'.$list[$i]['link'].'">'.htmlentities($list[$i]['name'], ENT_QUOTES, "UTF-8").'</a></li>';
            }
            print $str.'</ul>';
        } else {
            return false;
        }
}


function mountMenuModResumo(){
    $list = Array(
        Array('name' => 'Usuários', 'link' => 'link1.php'),
        Array('name' => 'Posts', 'link' => 'link2.php'),
        Array('name' => 'Comentários', 'link' => 'link3.php')
    );

    printMenuMod($list);
}

function mountMenuModUsuarios(){
    $list = Array(
        Array('name' => 'Mostrar todos', 'link' => 'usuarios.php'),
        Array('name' => 'Adicionar novo', 'link' => 'novo_usuario.php'),
        Array('name' => 'Seu perfil', 'link' => 'perfil.php')
    );

    printMenuMod($list);
}

?>
