/**
 *	@description Função para criar o menu principal
 *	
 *	@function
 *	@name menuPrincipal
 *	@param {string} Seletor do elemento que irá receber o menu
 */
function menuPrincipal(local){
	$(local).html(
		'<div class="menuPrincipal ui-state-default">'	+
		'	<ul>'+
        '   	<li id="principalMod"><a href="../principal/">Principal</a></li>'+
        '   	<li id="arquivosMod"><a href="../arquivos/">Arquivos</a></li>'+
        '   	<li id="usuariosMod"><a href="../usuarios/">Usu&aacute;rios</a></li>'+
        '      	<li id="logout" class="rightMenu"><a href="#">Sair</a> </li>'+
        '      	<li id="perfilMenu" class="rightMenu">'+
		'			Ol&aacute;, <b id="nomeUsuario"></b>'+
		'		</li>'+
		'	</ul>'+
        '</div>');
	
	ajaxSync(pegaDiretorioHost() + "API.php", {'acao':'pegaUsuarioAutenticado'}, function(data) {
		$('#nomeUsuario').html(data.resposta);
	});

	var mod = pegaDiretorioModuloAtual();

	$('#logout').click(function (){
        ajaxSync(pegaDiretorioHost() + "ControleAutenticacao.php", {'acao': 'fechaSessao'}, function (data){
			mostraMensagem(data[1], function (){
				if (data[0])
					document.location.reload();
			}, data[0]);
		});
	});

	$('#'+mod+'Mod').addClass('activeMenu');
}

/**
 *  @description Monta uma tabela de dados com o datatables
 *
 *	@function
 *	@name montaTabelaDados
 *	@param {string} Seletor do conteiner da tabela
 *	@param {string} Id da tabela
 *	@param {array} Matriz de dados
 *	@param {array} Matriz com os títulos das colunas
 */
var oTable;
function montaTabelaDados(conteiner, idTable, arrDados, arrTitulo, callback){
	callback = typeof callback == 'function' ? callback : function (){return true};
	$(conteiner).html( '<table cellpadding="0" cellspacing="0" border="0" width="100%" class="display" id="'+idTable+'"></table>' );
	oTable = $('#' + idTable).dataTable({
		"aaData": arrDados,
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
		"aoColumns": arrTitulo,
		"fnInitComplete": callback,
		"fnUpdate": function ( oSettings, fnCallbackDraw ){alert(1)}
	});	
}

/**
 *  @description Mostra um dialogo com a mensagem.
 *
 *	@function
 *	@name escreveMensagem
 *	@param {string}
 *	@param {function}
 *	@param {bool}
 */
function mostraMensagem( mensagem, callClose, tipo ){
	if ($('#mensagem').length == 0)
		$('body').append('<div id="mensagem"></div>');

	var cor = tipo ? 'green' : 'red' ;
	var img = tipo ? 'sucesso' : 'erro';
	var str = '<span style="color: '+cor+';"><img src="../../imagens/'+img+'.png" border="0" />';

	$('#mensagem').dialog('destroy').html(str + '<br />' + mensagem + '</span>').dialog({
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
		close: callClose
	});
}

/**
 *  @description Mostra um dialogo de confirmação
 *
 *	@function
 *	@name escreveMensagem
 *	@param {string}
 *	@param {function} Executa esta função quando precionado ok
 *	@param {function} Executa esta função quando precionado cancelar
 */
function mostraConfirm(mensagem, funcOk, funcCancel){
	if ($('#confirm').length == 0)
		$('body').append('<div id="confirm"></div>');

	$('#confirm').dialog('destroy').html(mensagem).dialog({
		width: 400,
		closeOnEscape: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Confirma&ccedil;&atilde;o',
		buttons: {
			"OK" : function (){
				$(this).dialog('close');
				funcOk();
			}, 
			"Cancelar" : function (){
				$(this).dialog('close');
				funcCancel();
			}
		},
		open : function (){
			$(this).parent().children('div').children('a.ui-dialog-titlebar-close').hide();
		}
	});
}

/**
 *  @description Cria um dialogo do formulario
 *
 *	@function
 *	@name criaDialogoFormulario
 *	@param {string}
 *	@param {string}
 *	@param {function} Executa esta função quando precionado ok
 *	@param {function} Executa esta função quando precionado cancelar
 *	@param {function} Executa esta função quando o dialogo é aberto
 */
function criaDialogoFormulario(seletor, titulo, funcSalvar, funcCancelar, funcAbrirDialogo){
	$(seletor).dialog({
		width: 'auto',
		autoOpen: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: titulo,
		buttons: {
			"Salvar" : function (){
				$(this).dialog('close');
				if (funcSalvar)
					funcSalvar();
			},
			"Cancelar" : function (){
				$(this).dialog('close');
				if (funcCancelar)
					funcCancelar();
			}
		},
		open: function (){
			if (funcAbrirDialogo)
				funcAbrirDialogo();
		}
	});
}
