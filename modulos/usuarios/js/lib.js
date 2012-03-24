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


var TTT;

function adicionaUsuario(){
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
			TTT = data;
			if (data.resultado.retorno) {
				window.location = pegaDiretorioHost() + "index.php";
			} else {
				if (data.resultado.mensagem)
					escreveMensagem(data.resposta.mensagem, data.resposta.retorno);
				else
					escreveMensagem('Erro ao adicionar o usu&aacute;rio!', false);
			}
		}
	);
}
