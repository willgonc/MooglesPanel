/**
 *	@description Função para criar o menu principal
 *	
 *	@function
 *	@name menuPrincipal
 */
function menuPrincipal(){
	ajaxSync("Control.php", {'action': 'read_file_menu_module'}, function (data){
		var strMenu = '<div class="menuPrincipal ui-state-default"><ul>';
		for (var i = 0; i < data[1].length; i++) {
			strMenu += '<li id="'+data[1][i][0]+'"><a href="../'+data[1][i][0]+'/">'+data[1][i][1]+'</a></li>';
		}
        strMenu += '<li id="logout" class="rightMenu"><a href="#">Sair</a> </li>'+
        	'      	<li id="perfilMenu" class="rightMenu">'+
			'			Ol&aacute;, <b>'+global_user_data.name+'</b>'+
			'		</li>';
		$('#menu').html(strMenu + '</ul></div>');
	});

	var mod = pegaDiretorioModuloAtual();

	$('#logout').click(function (){
        ajaxSync("../../Authentication.php", {'action': 'close_session'}, function (data){
			showMessage(data[1], function (){
				if (data[0])
					document.location.reload();
			}, data[0]);
		});
	});

	$('#'+mod+'Mod').addClass('activeMenu');
}

$(document).ready(function () {
	menuPrincipal();
	init();
});


/**
 *  @description Mounts a list of registered users
 *
 *	@function
 *	@name mountDatatable
 *	@param {string}
 *	@param {string}
 *	@param {array}
 *	@param {array}
 *	@param {function}
 */
var oTable;
function mountDatatable(conteiner, idTable, arrData, arrTitle, callback){
	callback = typeof callback == 'function' ? callback : function (){return true};
	$(conteiner).html( '<table cellpadding="0" cellspacing="0" border="0" width="100%" class="display" id="'+idTable+'"></table>' );
	oTable = $('#' + idTable).dataTable({
		"aaData": arrData,
		"oLanguage": {
			"sProcessing":   "Processando...",
			"sLengthMenu":   "Mostrar _MENU_ registros",
			"sZeroRecords":  "Não foram encontrados resultados",
			"sInfo":         "Mostrando de _START_ at&eacute; _END_ de _TOTAL_ registros",
			"sInfoEmpty":    "Mostrando de 0 at&eacute; 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros no total)",
			"sInfoPostFix":  "",
			"sSearch":       "Buscar",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Primeiro",
				"sPrevious": "Anterior",
				"sNext":     "Seguinte",
				"sLast":     "&Uacute;ltimo"
			}
		},
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aoColumns": arrTitle,
		"fnInitComplete": callback
	});	
}

/**
 *  @description Show the message dialog
 *
 *	@function
 *	@name showMessage
 *	@param {string}
 *	@param {function}
 *	@param {bool}
 */
function showMessage( message, closeFunction, typeMessage ){
	if ($('#message').length == 0)
		$('body').append('<div id="message"></div>');

	var color = typeMessage ? 'green' : 'red' ;
	var img = typeMessage ? 'sucesso' : 'erro';
	var str = '<span style="color: '+color+';"><img src="../../imagens/'+img+'.png" border="0" />';

	$('#message').dialog('destroy').html(str + '<br />' + message + '</span>').dialog({
		width: 400,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Mensagem',
		buttons: {
			"Fechar" : function (){
				$(this).dialog('close');
			}
		},
		close: function (){
			if (closeFunction)
				closeFunction();
		}
	});
}

/**
 *  @description shows the confirmation dialog
 *
 *	@function
 *	@name showConfirm
 *	@param {string}
 *	@param {function}
 *	@param {function}
 */
function showConfirm(message, okFunction, cancelFunction){
	if ($('#confirm').length == 0)
		$('body').append('<div id="confirm"></div>');

	$('#confirm').dialog('destroy').html(message).dialog({
		width: 400,
		closeOnEscape: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Confirma&ccedil;&atilde;o',
		buttons: {
			"OK" : function (){
				$(this).dialog('close');
				if (okFunction)
					okFunction();
			}, 
			"Cancelar" : function (){
				$(this).dialog('close');
				if (cancelFunction)
					cancelFunction();
			}
		},
		open : function (){
			// remove close button jquery ui dialog
			$(this).parent().children('div').children('a.ui-dialog-titlebar-close').hide();
		}
	});
}

/**
 *  @description Creates a dialog for a form. With the save button and cancel.
 *
 *	@function
 *	@name createDialogForm
 *	@param {string}
 *	@param {string}
 *	@param {function}
 *	@param {function}
 *	@param {function}
 */
function createDialogForm(selector, title, saveFunction, cancelFunction, callback){
	$(selector).dialog({
		width: 'auto',
		autoOpen: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: title,
		buttons: {
			"Salvar" : function (){
				$(this).dialog('close');
				if (saveFunction)
					saveFunction();
			},
			"Cancelar" : function (){
				$(this).dialog('close');
				if (cancelFunction)
					cancelFunction();
			}
		},
		open: function (){
			if (callback)
				callback();
		}
	});
}
