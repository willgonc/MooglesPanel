/**
 *	@description Função de inicialização do módulo login
 *	
 *	@function
 *	@name init
 */
function init(){
	$('#email').focus();
	$(':button').button();

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
	ajaxSync("Controle.php",{ "acao": "autenticaUsuario", "email": email, "senha": senha }, function (data){
		if (data[0])
			window.location = pegaDiretorioHost();
		else
			escreveMensagemLogin(data[1]);
	});
}

/**
 *	@description Escreve uma mensagem na tela de login
 *	
 *	@function
 *	@name escreveMensagemLogin
 *	@param {string} 
 */
function escreveMensagemLogin(msg){
	$('#load').hide();
	$('#mensagem').html(msg);
	$('#email').focus();
}
