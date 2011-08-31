<?php

/* 
funcao: printMenu
*/
function printMenu(){
        print '<div class="tw-ui-menu-principal">
                <a href="resumo.php" class="1"><div>Resumo</div></a>
                <a href="posts.php" class="2"><div>Posts</div></a>
                <a href="usuarios.php" class="3"><div>Usu&aacute;rios</div></a>
                <a href="config.php" class="4"><div>Configura&ccedil;&otilde;es</div></a>
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
    $class = '';
    for ($i = 0; $i < count($list); $i++){
        if ($i == 0)
            $class = 'first-item';
        elseif ($i == (count($list)-1))
            $class = 'last-item';
        else
            $class = '';

        $str .= '<li><a href="'.$list[$i]['link'].'" class="'.$class.'">'.$list[$i]['name'].'</a></li>';
    }

    print $str.'</li></ul>';
}


function mountMenuModResumo(){
    $list = Array(
        Array('name' => 'Usu&aacute;rios', 'link' => 'link1.php'),
        Array('name' => 'Posts', 'link' => 'link2.php'),
        Array('name' => 'Coment&aacute;ios', 'link' => 'link3.php')
    );

    printMenuMod($list);
}

function mountMenuModUsuarios(){
    $list = Array(
        Array('name' => 'Mostrar todos', 'link' => 'usuarios.php'),
        Array('name' => 'Adicionar novo', 'link' => 'novo_usuario.php'),
        Array('name' => 'Seu perfil', 'link' => 'perfil.php')
        //Array('name' => returnFormSearch('usuarios.php', 'get', '', 20), 'link' => 'null')
    );

    printMenuMod($list);
}

function mountMenuModPosts(){
    $list = Array(
        Array('name' => 'Mostrar todos', 'link' => 'posts.php'),
        Array('name' => 'Adicionar novo', 'link' => 'novo_post.php'),
        Array('name' => 'Categorias', 'link' => 'categorias.php')
        //Array('name' => returnFormSearch('posts.php', 'get', '', 20), 'link' => 'null')
    );

    printMenuMod($list);
}


function returnFormSearch($action, $method, $name, $size){
    $action = (isset($action)?'action="'.$action.'"':'');
    $method = (isset($method)?'method="'.$method.'"':'');
    $name = (isset($name)?'name="'.$name.'"':'');
    $size = (isset($size)?'size="'.$size.'"':'size="20"');

    return '<div class="tw-ui-busca">
               <form '.$action.' '.$method.' '.$name.'>
                   <input type="text" class="input-text" '.$size.' name="busca" value="'.(isset($_GET['busca'])?$_GET['busca']:'').'" />
                   <input type="submit" class="input-submit" value="Buscar" />
               </form>
           </div>';
}

?>
