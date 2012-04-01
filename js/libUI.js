/**
 *	@description Função para criar o menu principal
 *	
 *	@function
 *	@name menuPrincipal
 *	@param {string} Seletor do elemento que irá receber o menu
 */
function menuPrincipal(local){
	$(local).html(
		'<div class="tw-ui-menu-principal">'	+
		'	<ul>'+
        '   	<li id="principalMod"><a href="../principal/">Principal</a></li>'+
        '   	<li id="usuariosMod"><a href="../usuarios/">Usu&aacute;rios</a></li>'+
        '      	<li id="logout" class="rightMenu"><a href="#">Sair</a> </li>'+
        '      	<li id="perfilMenu" class="rightMenu">'+
		'			<a href="perfil.php">Ol&aacute;, <b id="nomeUsuario"></b></a> '+
		'		</li>'+
		'	</ul>'+
        '</div>');
	
	ajaxSync(pegaDiretorioHost() + "api.php", {'acao':'pegaUsuarioAutenticado'}, function(data) {
		$('#nomeUsuario').html(data.resposta);
	});

	var mod = pegaDiretorioModuloAtual();

	$('#logout').click(function (){
        ajaxSync(pegaDiretorioHost() + "ControleAutenticacao.php", {'acao': 'fechaSessao'}, function (data){
			if (data[0] == true)
				window.location = pegaDiretorioHost();
		});
	});

	$('#'+mod+'Mod').addClass('activeMenu');
}

/**
 *	@description Define o funcionamento do menu interno
 *	
 *	@function
 *	@name menuModulo
 */
function menuModulo(){
	$('#menuModulo ul li a').click(function (){
		$('#menuModulo ul li a').removeClass('menuModuloAtivo');
		$(this).addClass('menuModuloAtivo');

		var div = $(this).attr('show');
		var call = $(this).attr('call');
		$('.conteudo').hide();
		escreveTitulo($(this).html());
		$('#' + div).show();
		eval(call);
	});

	var div = $('#menuModulo ul li:first a').attr('show');
	var call = $('#menuModulo ul li:first a').attr('call');
	escreveTitulo($('#menuModulo ul li:first a').html());
	$('.conteudo').hide();
	$('#' + div).show();
	eval(call);
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
		"fnInitComplete": callback
	});	
}
