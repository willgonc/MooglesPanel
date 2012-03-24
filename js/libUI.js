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
		$('.conteudo').hide();
		escreveTitulo($(this).html());
		$('#' + div).show();
	});

	var div = $('#menuModulo ul li:first a').attr('show');
	escreveTitulo($('#menuModulo ul li:first a').html());
	$('.conteudo').hide();
	$('#' + div).show();
}
