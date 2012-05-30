/**
 *  @description Mostra uma tela de load
 *	@function
 *	@name mostraLoading
 */
function mostraLoading(){
	if ($('#loading').length == 0)
		$('body').append('<div id="loading"><img src="../../imagens/load.gif" border="0" /></div>');
	
	$('#loading').show();
}

/**
 *  @description Esconde a tela de load
 *	@function
 *	@name escondeLoading
 */
function escondeLoading(){
	$('#loading').hide();
}

/**
 *	@description Função que verifica a sessão do usuário e redireciona
 *		para o modulo correspondente
 *
 *	@function
 *	@name verificaAutenticacao
 */
function verificaAutenticacao(){
	ajaxSync("../../Authentication.php", {"action":"check_user"}, function(data) {
		var mod = pegaDiretorioModuloAtual();
		if (data[0]) {
			if (mod == 'login')
				window.location = pegaDiretorioHost();
		} else {
			if (mod != 'login')
				window.location = pegaDiretorioModulo("login");
		}
	});
}
verificaAutenticacao();

/**
 *	@description Realiza uma chamada ajax síncrona sem cache
 *
 *	@function
 *	@name ajaxSync
 *	@param {string} url Url da chamada ajax
 *	@param {array} data Dados a serem passados
 *	@param {function} call Função de callback que é executada em caso
 *		de sucesso
 */
function ajaxSync(url, data, call){
	mostraLoading();
	$.ajax({
	    type: 'GET',
		url: url,
		dataType: 'json',
		success: function (data){
			escondeLoading();

			if (call)
				call(data);
		},
		error: function (jqXHR, textStatus, errorThrown){
			alert("A requisição falhou: " + textStatus);
			document.location.reload();
		},
		data: (data ? data : {}),
		async: false,
		cache: false
	});
}

/**
 *	@description Realiza uma chamada ajax assíncrona sem cache
 *
 *	@function
 *	@name ajax
 *	@param {string} url Url da chamada ajax
 *	@param {array} data Dados a serem passados
 *	@param {function} call Função de callback que é executada em caso
 *		de sucesso
 */
function ajax(url, data, call){
	$.ajax({
	    type: 'GET',
		url: url,
		dataType: 'json',
		success: (call ? call : function (){}),
		data: (data ? data : {}),
		async: true,
		cache: false
	});
}

/**
 *	@description Pega o nome diretório host da aplicação
 *
 *	@function
 *	@name pegaNomeHost
 *	@return {string}
 */
function pegaNomeHost(){
	if (window.location.hostname)
		return window.location.hostname;
	else if (window.location.host)
		return window.location.host;
	else
		return window.location.href.split('/')[2];
}

/**
 *	@description Pega o protocolo usado
 *
 *	@function
 *	@name pegaNomeProtocolo
 *	@return {string}
 */
function pegaNomeProtocolo(){
	if (window.location.protocol)
		return window.location.protocol;
	else
		return 'http:'
}

/**
 *	@description Retorna o diretório aonde se encontra o painel
 *
 *	@function
 *	@name pegaDiretorioHost
 *	@return {string}
 */
function pegaDiretorioHost(){
	var arr = [];
	var host = '';
	if (window.location.pathname){
		arr = window.location.pathname.split('/');
		for (var i = 0; arr[i] != 'modulos'; i++)
			if (arr[i] != '')
				host += '/' + arr[i];
	}

	return host + '/';
}

/**
 *	@description Retorna a url de um modulo
 *
 *	@function
 *	@name pegaDiretorioHost
 *	@para {string} Nome do módulo
 *	@return {string}
 */
function pegaDiretorioModulo(modulo){
	return pegaDiretorioHost() + "modulos/" + modulo + "/";
}

/**
 *	@description Retorna o link raiz completo da aplicação
 *
 *	@function
 *	@name pegaPath
 *	@return {string}
 */
function pegaPath(){
	return pegaNomeProtocolo() + '//' + pegaNomeHost() + pegaDiretorioHost();
}

/**
 *	@description Retorna o nome do diretório do módulo atual
 *
 *	@function
 *	@name pegaDiretorioModuloAtual
 *	@return {string}
 */
function pegaDiretorioModuloAtual(){
	var arrURL = window.location.pathname.split('/');
	return arrURL[arrURL.length - 2];
}

/**
 *  @description Valida um email
 *
 *	@function
 *	@name validaEmail
 *	@param {string} email E-mail a ser validado
 *	@return {bool} True caso esteje no formato correto
 */
function validaEmail(email){
    var reEmail = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
    if (reEmail.test(email))
        return true;
    else if (email != null && email != "")
        return false;
    else
        return false;
}

/**
 *  @description Verifica se uma string está vazia ou nao
 *
 *	@function
 *	@name requerido
 *	@param {string}
 *	@return {bool}
 */
function requerido(str){
    if (str == '' || str == undefined || str == null || str.length == 0)
        return false;
    else
        return true;
}

/**
 *  @description Limpa os campos de texto de um formulário
 *	@function
 *	@name resetaCampoTextoFormulario
 */
function resetaCampoTextoFormulario(){
	$('.formulario input:text, .formulario textarea, .formulario input:password').val('');
}


function formataDataBanco(data){
	var arr = data.split(' ');
	var arrData = arr[0].split('-');
	var novaData = arrData[2] + '/' + arrData[1] + '/' + arrData[0];
	return novaData + ' <br />&agrave;s<br /> ' + arr[1];
}
