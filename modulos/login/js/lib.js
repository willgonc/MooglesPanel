/**
 *	@description Função de inicialização do módulo login
 *	
 *	@function
 *	@name init
 */
function init(){
	$('#load').hide();
	$('#email').focus();

	$('#email, #senha').keypress(function (event){
		if (event.keyCode == 13){
			$('#load').show();
			autenticaUsuario($('#email').val(), $('#senha').val());
		}
	});
	$('#botaoEntrar').click(function (){
		$('#load').show();
		autenticaUsuario($('#email').val(), $('#senha').val());
	});
}

/**
 *	@description Função que chama o controle de autenticação
 *		e trata o resultado exibindo as mensagens ou redirecionando
 *		para a página principal.
 *	
 *	@function
 *	@name autenticaUsuario
 *	@param {string} email Email do usuário
 *	@param {string} senha Senha do usuário
 */
function autenticaUsuario(email, senha){
	if (requerido(email) == false){
		escreveMensagemLogin('Preencha o campo <b>E-mail</b> corretamente!');
	} else if (requerido(senha) == false){
		escreveMensagemLogin('Preencha o campo <b>Senha</b> corretamente!');
	} else if (validaEmail(email)){
		ajaxSync("Controle.php",{ "acao": "autenticaUsuario", "email": email, "senha": senha }, function (data){
			if (data.resposta) {
				window.location = pegaDiretorioHost() + "index.php";
			} else {
				escreveMensagemLogin('Usuario ou senha incorretos!');
			}
		});
	} else {
		escreveMensagemLogin('Este endere&ccedil;o de <b>e-mail</b> n&atilde;o &eacute; v&aacute;lido!');
	}
}

function escreveMensagemLogin(msg){
	$('#load').hide();
	$('#mensagem').html(msg);
	$('#email').focus();
}
