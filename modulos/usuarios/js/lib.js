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
