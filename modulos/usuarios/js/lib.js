/**
 *	@description Função de inicialização do módulo usuários
 *	@function
 *	@name init
 */
function init(){
	menuPrincipal('#menu');
	
	dataTableUsuarios();
	$('#listagemUsuarios').show();
	$(':button').button();
	
	// Diálogo do formulário de inclusão
	criaDialogoFormulario('#formularioAddUsuario', 'Adicionar usu&aacute;rio', adicionaUsuario, function (){});
					
	// Diálogo do formulário de edição		
	criaDialogoFormulario('#formularioEditarUsuario', 'Editar usu&aacute;rio', editaUsuario, function (){});

	// Abre o formulario de inclusão
	$('#botaoAdicionarUsuario').click(function (){
		resetaCampoTextoFormulario();
		$('#formularioAddUsuario').dialog('open');
	});

	// Abre o confirm para excluir o usuário
	$('#removeUsuario').click(function (){
		$('#formularioEditarUsuario').dialog('close');
		mostraConfirm('Você deseja excluir este usuário?', function (){
			removeUsuario($('#idEdit').val());
		}, function (){ 
			$('#formularioEditarUsuario').dialog('open');
		});
	});
}

/**
 *	@description Adiciona um usuário no banco
 *	@function
 *	@name adicionaUsuario
 */
function adicionaUsuario(){
	ajaxSync(
		"Control.php", { 
			"action": "add_user",
			"nome": $('#nome').val(), 
			"email": $('#email').val(), 
			"senha": $('#senha').val(), 
			"confirmaSenha": $('#confirmaSenha').val() 
		}, function (data){
			mostraMensagem( data[1], function (){
				if (data[0])
					document.location.reload();
				else
					$('#formularioAddUsuario').dialog('open');
			}, data[0]);
		}
	);
}

/**
 *	@description Monta a tadela de dados da lista de usuários
 *	@function
 *	@name dataTableUsuarios
 */
function dataTableUsuarios(){
	ajaxSync( "Control.php", { "action": "get_all_users" }, function (data){
		if (data[0]) {
			var arr = [];
			var widthTable = "100%";
			var arrTitulo = [
				{ "sTitle": "Nome" },
				{ "sTitle": "E-mail" }
			];

			// montando array de dados
			for (var i = 0; i < data[1].length; i++){
				arr[i] = [
					'<a href="#" title="Editar" idUsuario="'+data[1][i].id+'" class="linkDatatables">'+data[1][i].name+
						'<img src="../../imagens/edit.png" border="0" /></a>',
					data[1][i].email
				];
			}

			montaTabelaDados('#datatablesUsuarios', 'tabelaUsuarios', arr, arrTitulo, function (){
				// Registra os eventos para edição dos dados do usuário
				$('.linkDatatables').live('click', function (){
					ajaxSync( "Control.php", { "action": "get_data_user", "id": $(this).attr('idUsuario') }, function (data){
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
			mostraMensagem( data[0], function (){}, data[1]);
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
	ajaxSync( "Control.php", { "action": "rm_user", "id": id }, function (data){
		mostraMensagem(data[1], function (){
			if (data[0])
				document.location.reload();
			else
				$('#formularioEditarUsuario').dialog('open');
		}, data[0]);
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
	ajaxSync( "Control.php", { "action": "edit_user", 
		"id": $('#idEdit').val(), 
		"nome": $('#nomeEdit').val(),
		"email": $('#emailEdit').val(),
		"senha": $('#senhaEdit').val(),
		"confirmaSenha": $('#confirmaSenhaEdit').val()
	}, function (data){
		mostraMensagem(data[1], function (){
			if (data[0])
				document.location.reload();
			else
				$('#formularioEditarUsuario').dialog('open');
		}, data[0]);
	});
}
