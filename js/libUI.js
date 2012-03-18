function menuPrincipal(local){
	$(local).html(
		'<div class="tw-ui-menu-principal">'	+
		'	<ul>'+
        '   	<li id="principalMod" title="Resumo"><a href="../principal/">Principal</a></li>'+
        '      	<li class="rightMenu" title="Sair do painel" ><a href="../../FechaSessao.php">Sair</a> </li>'+
        '      	<li id="perfilMenu" title="Exibir seu perfil" class="rightMenu">'+
		'			<a href="perfil.php">Ol&aacute;, <b id="nomeUsuario"></b></a> '+
		'		</li>'+
		'	</ul>'+
        '</div>');
	
	$.ajax({
	    type: 'GET',
		url: "../../api.php",
		dataType: 'json',
		success: function(data) {
			$('#nomeUsuario').html(data.resposta);
		},
		data: {'comando':'pegaUsuarioAutenticado'},
		async: false
	});

	var arrURL = window.location.pathname.split('/');
	var mod = arrURL[arrURL.length - 2];
	$(".tw-ui-menu-principal ul li").qtip({
		position: {
			my: "top center",
			at: "bottom center"
		},
		style: {
			classes: "ui-tooltip-shadow ui-tooltip-tipsy"
		}
	});
	
	$('#'+mod+'Mod').addClass('activeMenu');
}
