/**
 *	@description Função de inicialização do módulo usuários
 *	@function
 *	@name init
 */
function init(){
	usersTable();
	$('#listagemUsuarios').show();
	$(':button').button();
	
	createDialogForm('#formularioAddUsuario', 'Adicionar usu&aacute;rio', addUser, function (){});
	createDialogForm('#formularioEditarUsuario', 'Editar usu&aacute;rio', editUser, function (){});

	$('#botaoAdicionarUsuario').click(function (){
		$('.formulario input:text, .formulario textarea, .formulario input:password').val('');
		$('#formularioAddUsuario').dialog('open');
	});

	$('#removeUsuario').click(function (){
		$('#formularioEditarUsuario').dialog('close');
		showConfirm('Você deseja excluir este usuário?', function (){
			removeUser($('#idEdit').val());
		}, function (){ 
			$('#formularioEditarUsuario').dialog('open');
		});
	});
}

/**
 *	@description Add the User Database
 *	@function
 *	@name addUser
 */
function addUser(){
	ajaxSync(
		"Control.php", { 
			"action": "add_user",
			"name": $('#nome').val(), 
			"email": $('#email').val(), 
			"password": $('#senha').val(), 
			"confirmPassword": $('#confirmaSenha').val() 
		}, function (data){
			showMessage( data[1], function (){
				if (data[0])
                    usersTable();
				else
					$('#formularioAddUsuario').dialog('open');
			}, data[0]);
		}
	);
}

/**
 *	@description mounts the data table of users
 *	@function
 *	@name usersTable
 */
function usersTable(){
	ajaxSync( "Control.php", { "action": "get_all_users" }, function (data){
		if (data[0]) {
			var arr = [];
			var widthTable = "100%";
			var arrTitle = [
				{ "sTitle": "Nome" },
				{ "sTitle": "E-mail" }
			];

			for (var i = 0; i < data[1].length; i++){
				arr[i] = [
					'<a href="#" title="Editar" idUsuario="'+data[1][i].id+'" class="linkDatatables">'+data[1][i].name+
						'<img src="../../imagens/edit.png" border="0" /></a>',
					data[1][i].email
				];
			}

			mountDatatable('#datatablesUsuarios', 'tabelaUsuarios', arr, arrTitle, function (){
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
							showMessage( 'Erro ao buscar dados do usu&aacute;rio!', function (){}, data[0]);
						}
					});
				});
			});
		} else {
			showMessage( data[0], function (){}, data[1]);
		}
	});
}

/**
 *	@description Removes a User Database
 *
 *	@function
 *	@name removeUser
 *	@param {integer}
 */
function removeUser(id){
	ajaxSync( "Control.php", { "action": "rm_user", "id": id }, function (data){
		showMessage(data[1], function (){
			if (data[0])
                usersTable();
			else
				$('#formularioEditarUsuario').dialog('open');
		}, data[0]);
	});
}

/**
 *	@description Edit the User Database
 *
 *	@function
 *	@name editUser
 *	@param {integer}
 */
function editUser(id){
	ajaxSync( "Control.php", { "action": "edit_user", 
		"id": $('#idEdit').val(), 
		"name": $('#nomeEdit').val(),
		"email": $('#emailEdit').val(),
		"password": $('#senhaEdit').val(),
		"confirmPassword": $('#confirmaSenhaEdit').val()
	}, function (data){
		showMessage(data[1], function (){
			if (data[0])
                usersTable();
			else
				$('#formularioEditarUsuario').dialog('open');
		}, data[0]);
	});
}
