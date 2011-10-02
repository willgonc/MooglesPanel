function dropdown(){
    $('.item-menu').mouseover(function (){
        $(this).children('.submenu').show();
    }).mouseout(function (){
        $(this).children('.submenu').hide();
    });
}
