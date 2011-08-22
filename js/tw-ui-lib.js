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
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "cut,copy,paste,undo,redo,search,replace,|,bold,italic,underline,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,outdent,indent,|,link,unlink,code",
		theme_advanced_buttons2 : ",styleselect,formatselect,fontselect,fontsizeselect,|,sub,sup,|,charmap,emotions,iespell,image,media,advhr,|,ltr,rtl",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,styleprops,|,cite,abbr,acronym,del,ins,attribs",
//		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

}
/*function carregaRichText(){
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
}*/
