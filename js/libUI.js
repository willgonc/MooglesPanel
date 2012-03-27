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
 *  @description Monta uma tabela de dados com paginação a partir de uma
 *		matriz
 *
 *	@function
 *	@name montaTabelaDados
 *	@param {array} Matriz de dados
 */
function montaTabelaDados(conteiner, arrDados, arrTitulo, widthTable, quantExibicao, pag){
	// valores default
	quantExibicao = quantExibicao ? quantExibicao : 10;
	pag = pag ? pag : 1;
	var linhas = arrDados.length > quantExibicao ? quantExibicao : arrDados.length;
	var de = pag == 1 ? pag : (pag * quantExibicao) + 1;



	var paginacao =  de + ' - Total ' + arrDados.length ;
	//'<div class="paginacaoTabelaDados"><div class="botaoPaginacaoAnterior"></div><div class="botaoPaginacaoProximo"></div></div>';

	var table = '<table class="tabelaDados" width="'+widthTable+'">';

	// cabecalho
	/*if (arrTitulo){
		table += '<thead><tr>';
		for (var i = 0; i < arrTitulo.length; i++){
			table += '<th align="'+arrTitulo[i].align+'" width="'+arrTitulo[i].width+'">'+arrTitulo[i].nome+'</th>';
		}
		table += '</tr></thead>';
	}*/

	// corpo da tabela
	table += '<tbody>';
	for (var i = 0; i < linhas; i++){
		table += '<tr>';
		for (var j = 0; j < arrDados[i].length; j++){
			table += '<td>'+arrDados[i][j]+'</td>';
		}
		table += '</tr>';
	}
	table += '</tbody>';

	table += '</table>';

	$(conteiner).html(paginacao+table);
}
