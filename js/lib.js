/**
 *	@description Função que verifica a sessão do usuário
 *
 *	@function
 *	@name verificaAutenticacao
 */
function verificaAutenticacao(){
	$.ajax({
	    type: 'GET',
		url: pegaPath() + "VerificaAutenticacao.php",
		dataType: 'json',
		success: function(data) {
			var arrURL = window.location.pathname.split('/');
			var mod = arrURL[arrURL.length - 2];
			if (data.resposta) {
				if (mod == 'login')
					window.location = "../../";

			} else {
				if (mod != 'login')
					window.location = "../../modulos/login/";

			}
		},
		data: {},
		async: false
	});
}

verificaAutenticacao();

/**
 *	@description Pega o nome do host
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
	var str = '';
	if (window.location.pathname){
		arr = window.location.pathname.split('/');
		for (var i = 0; arr[i] != 'modulos'; i++)
			if (arr[i] != '')
				str += '/' + arr[i];
	}

	return str;
}

/**
 *	@description Retorna o link raiz completo do painel
 *
 *	@function
 *	@name pegaPath
 *	@return {string}
 */
function pegaPath(){
	return pegaNomeProtocolo() + '//' + pegaNomeHost() + pegaDiretorioHost() + '/';
}

/**
 *  @description Valida um email
 *
 *	@function
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




















function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}

function requerido(str){
    if (str == '' || str == undefined || str == null || str.length == 0)
        return false;
    else
        return true;
}

function exibeMsgFormElem(elem, msg, estado){
    $('.msg-login').remove();
    elem.parent().append('<div class="msg-login" style="color: red">' + msg + '</div>');
}

