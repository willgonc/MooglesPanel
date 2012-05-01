/**
 *	@description Função de inicialização do módulo usuários
 *	
 *	@function
 *	@name init
 */
function init(){
	menuPrincipal('#menu');
	
	dataTableUsuarios();
	$('#listagemUsuarios').show();
	escreveTitulo('Usu&aacute;rios');
	$(':button').button();
	
	$('#formularioAddUsuario').dialog({
		width: 'auto',
		autoOpen: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Adicionar usu&aacute;rio',
		buttons: {
			"Salvar" : function (){
				$(this).dialog('close');
				adicionaUsuario();
			},
			"Cancelar" : function (){
				$(this).dialog('close');
			}
		}
	});
					
					
	$('#formularioEditarUsuario').dialog({
		width: 'auto',
		autoOpen: false,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Editar usu&aacute;rio',
		buttons: {
			"Salvar" : function (){
				$(this).dialog('close');
				editaUsuario();
			},
			"Cancelar" : function (){
				$(this).dialog('close');
			}
		}
	});

	// Dialogo para adicionar usuário
	$('#botaoAdicionarUsuario').click(function (){
		resetaCampoTextoFormulario();
		$('#formularioAddUsuario').dialog('open');
	});


	/*/ Botão de excluir um usuário
	$('#removeUsuario').click(function (){
		if (confirm('Você deseja excluir este usuário?')){
			removeUsuario($('#idEdit').val());
			
			$('.conteudo').hide();
			escreveTitulo('Todos os usu&aacute;rios');
			$('#listagemUsuarios').show();
			dataTableUsuarios();
		}
	});*/
}

/**
 *	@description Adiciona um usuário no banco
 *	@function
 *	@name adicionaUsuario
 */
function adicionaUsuario(){
	mostraLoading();
	ajaxSync(
		"Controle.php", { 
			"acao": "adicionaUsuario",
			"nome": $('#nome').val(), 
			"email": $('#email').val(), 
			"senha": $('#senha').val(), 
			"confirmaSenha": $('#confirmaSenha').val() 
		}, function (data){
			escondeLoading();
			if (data[0]) {
				mostraMensagem( 'Sucesso', data[1], function (){
					resetaCampoTextoFormulario();
					$('#formularioAddUsuario').dialog('open'); 
				}, data[0]);
			} else {
				mostraMensagem( 'Erro', data[1], function (){
					$('.formulario input:password').val('');
					$('#formularioAddUsuario').dialog('open');
				}, data[0]);
			}
		}
	);
}

/**
 *	@description Monta a tadela de dados da lista de usuários
 *	@function
 *	@name dataTableUsuarios
 */
function dataTableUsuarios(){
	ajaxSync( "Controle.php", { "acao": "pegaTodosUsuarios" }, function (data){
		if (data[0]) {
			var nomeUsuarioAutenticado;
			ajaxSync(pegaDiretorioHost() + "api.php", {'acao':'pegaUsuarioAutenticado'}, function(data) {
				nomeUsuarioAutenticado = data.resposta;
			});
			var arr = [];
			var widthTable = "100%";
			var arrTitulo = [
				{ "sTitle": "Nome" },
				{ "sTitle": "E-mail" }
			];

			// montando array de dados
			for (var i = 0; i < data[1].length; i++){
				arr[i] = [
					'<a href="#" title="Editar" idUsuario="'+data[1][i].id+'" class="linkDatatables">'+data[1][i].nome+
						'<img src="imagens/edit.png" border="0" /></a>',
					data[1][i].email
				];
			}

			montaTabelaDados('#datatablesUsuarios', 'tabelaUsuarios', arr, arrTitulo, function (){
				$('.linkDatatables').click(function (){
					ajaxSync( "Controle.php", { "acao": "pegaDadosUsuario", "id": $(this).attr('idUsuario') }, function (data){
						if (data[0]){
							$('#idEdit').val(data[1].id);
							$('#nomeEdit').val(data[1].nome);
							$('#emailEdit').val(data[1].email);
							$('#senhaEdit').val('');
							$('#confirmaSenhaEdit').val('');
							$('#formularioEditarUsuario').dialog('open');
						} else {
							mostraMensagem( 'Erro ao buscar dados do usu&aacute;rio!', function (){}, data[0]);
						}
					});
				});
			});
		} else {
			escreveMensagem(data[0], data[1]);
		}
	});
}

/**
 *	@description Remove um usuário do banco de dados
 *
 *	@function
 *	@name removeUsuario
 *	@param {integer} Id do usuário a ser removido
 */
function removeUsuario(id){
	ajaxSync( "Controle.php", { "acao": "removerUsuario", "id": id }, function (data){
		if (data[0])
			dataTableUsuarios();

		escreveMensagem(data[0], data[1]);
	});
}

/**
 *	@description Edita um usuário na base de dados
 *
 *	@function
 *	@name editaUsuario
 *	@param {integer} Id do usuário a ser editado
 */
function editaUsuario(id){
	mostraLoading();
	ajaxSync( "Controle.php", { "acao": "editarUsuario", 
		"id": $('#idEdit').val(), 
		"nome": $('#nomeEdit').val(),
		"email": $('#emailEdit').val(),
		"senha": $('#senhaEdit').val(),
		"confirmaSenha": $('#confirmaSenhaEdit').val()
	}, function (data){
		escondeLoading();
		if (data[0]){
			$('#nomeUsuario').html($('#nomeEdit').val());
			verificaAutenticacao();
			dataTableUsuarios();
		}
		mostraMensagem(data[1], function (){}, data[0]);
		$('#senhaEdit, #confirmaSenhaEdit').val('');
	});
}
