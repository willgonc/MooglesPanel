/**
 *	@description Função de inicialização do módulo usuários
 *	
 *	@function
 *	@name init
 */
function init(){
	menuPrincipal('#menu');
	menuModulo();	
	$('#nome').focus();

	$('#botaoSalvar').click(function (){
		adicionaUsuario();
	});
}

/**
 *	@description Adiciona um usuário no banco
 *
 *	@function
 *	@name adicionaUsuario
 */
function adicionaUsuario(){
	$('#load').show();
	var nome = $('#nome').val();
	var email = $('#email').val();
	var senha = $('#senha').val();
	var confirmaSenha = $('#confirmaSenha').val();
	ajaxSync(
		"Controle.php",
		{ 
			"acao": "adicionaUsuario", 
			"nome": nome, 
			"email": email, 
			"senha": senha, 
			"confirmaSenha": confirmaSenha 
		}, function (data){
			if (data[0]) {
				$('.formulario input:text, .formulario input:password').val('');
				escreveMensagem(data[0], data[1]);
			} else {
				$('.formulario input:password').val('');
				escreveMensagem(data[0], data[1]);
			}
			$('#load').hide();
		}
	);
}

/**
 *	@description Monta a tadela de dados da lista de usuários
 *
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
					{ "sTitle": "E-mail" },
					{ "sTitle": "Status", "sWidth": "100px" },
					{ "sTitle": "", "sWidth": "100px" , "bSortable": false}
				];
				// montando array de dados
				for (var i = 0; i < data[1].length; i++){
					arr[i] = [
						data[1][i].nome,
						data[1][i].email,
						data[1][i].status == 1 ? '<span style="color: green">Ativo</span>' : '<span style="color: red">Bloqueado</span>',
						(nomeUsuarioAutenticado == data[1][i].nome ? '' :
						'<img src="../../imagens/editar.png" border="0" width="24" height="24" idUsuario="'+data[1][i].id+'" acao="editar" class="botaoAcao" />'+
						'<img src="../../imagens/remove.png" border="0" width="24" height="24" idUsuario="'+data[1][i].id+'" acao="remover" class="botaoAcao" />')
					];
				}
				montaTabelaDados('#datatablesUsuarios', 'tabelaUsuarios', arr, arrTitulo, function (){
					$('.botaoAcao').click(function (){
						if ($(this).attr('acao') == 'remover')
							confirm("Deseja remover este usuário?") ? removeUsuario($(this).attr('idUsuario')) : false;
						else
							editarUsuario($(this).attr('idUsuario'));
					});
				});
			} else {
				escreveMensagem(data[0], data[1]);
			}
		}
	);
}


function removeUsuario(id){
	ajaxSync( "Controle.php", { "acao": "removerUsuario", "id": id }, function (data){
		escreveMensagem(data[0], data[1]);
		dataTableUsuarios();
	});
}

function editarUsuario(id){
	$('body').append('<div id="dialogo"><select id="status"><option value="1">Ativo</option> <option value="0">Bloqueado</option></select></div>');
	$('#dialogo').dialog({
		title: "Mudar status do usu&aacute;rio",
		autoOpen: true,
		resizable: false,
		draggable: false,
		modal: true,
		buttons: {
			'Salvar' : function (){
				ajaxSync( "Controle.php", { "acao": "editarUsuario", "id": id, "status": $('#status').val() }, function (data){
					escreveMensagem(data[0], data[1]);
					dataTableUsuarios();
				});
				$(this).dialog('close');
			}
		}
	});
}
