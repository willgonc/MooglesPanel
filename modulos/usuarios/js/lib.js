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

function dataTableUsuarios(){
	ajaxSync( "Controle.php", { "acao": "pegaTodosUsuarios" }, function (data){
			if (data[0]) {
				var arr = [];
				var widthTable = "100%";
				var arrTitulo = [
					{'nome':'Nome', 'align':'left', 'width':'50%'},
					{'nome':'E-mail', 'align':'left', 'width':'40%'},
					{'nome':'Status', 'align':'left', 'width':'10%'}
				];
				for (var i = 0; i < data[1].length; i++){
					arr[i] = [
						data[1][i].nome,
						data[1][i].email,
						data[1][i].status == 1 ? '<span style="color: green">Ativo</span>' : '<span style="color: red">Bloqueado</span>'
					];
				}
				$('#listagemUsuarios').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="datatable"></table>' );
				$('#datatable').dataTable({
					"aaData": arr,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"aoColumns": [
						{ "sTitle": "Nome" },
						{ "sTitle": "E-mail" },
						{ "sTitle": "Status" }
					]
				});	
			} else {
				escreveMensagem(data[0], data[1]);
			}
		}
	);
}
