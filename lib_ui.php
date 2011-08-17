<?php
/* 

funcao: printMenu
parametro: Array
exemplo: 

*/


function printMenu($list){
    $str = '<ul class="tw-ui-menu">';
    if (count($list) > 0){
        for ($i = 0; $i < count($list); $i++){
            $str .= '<li><a href="'.$list[$i]['link'].'">'.$list[$i]['name'].'</li>';
        }
        print $str;
    } else {
        return false;
    }
}

printMenu(Array(
                Array('name' => 'teste', 'link' => 'http://markus.com'), 
                Array('name' => 'teste1', 'link' => 'http://markus2.com'), 
                Array('name' => 'teste2', 'link' => 'http://markus1.com'), 
        ));

?>
