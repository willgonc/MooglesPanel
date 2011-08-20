function criaModal(param, call){
    $('.tw-modal').remove();
    $('body').append('<div class="tw-modal">'+
            '   <div class="tw-conteiner-modal">'+
            '       <img class="tw-btn-close" src="imagens/close.png" />'+
            '       <div class="tw-content-modal">'+
            (param.conteudo != undefined?param.conteudo:'')+
            '       </div>'+
            '   </div>'+
            '</div>');

    $('.tw-conteiner-modal').css({
        'position':'fixed',
        'left':'50%',
        'top':'50%',
        'margin-left':-(param.width/2)+'px',
        'margin-top':-(param.height/2)+'px',
        'width':param.width+'px',
        'height':param.height+'px'
    });

    $('.tw-btn-close').click(function(){
        $('.tw-modal').remove();
    });

    if (call)
        call();
}



/*
 *  Função que carrega o editor de texto
 */
function carregaRichText(){
    $("#texto")
        .css("height","250px")
        .css("width","825px")
        .htmlbox({
            toolbars:[ 
                ["undo","redo", 
                "separator","bold","italic","underline","strike","sup","sub", 
                "separator","justify","left","center","right", 
                "separator","ol","ul","indent","outdent", 
                "separator","link","unlink","image",
                "separator","fontsize", "fontcolor","code"] 
            ], 
            icons:"silk",
            skin:"blue",
            about: false
    });
}
