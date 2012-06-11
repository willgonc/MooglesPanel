/**
 *	@description Função de inicialização do módulo login
 *	
 *	@function
 *	@name init
 */
function init(){
	$('#email').focus();
	$(':button').button();

	$('#senha').keypress(function (event){
		if (event.keyCode == 13){
			$('#load').show();
			authenticateUser($('#email').val(), $('#senha').val());
		}
	});
	$('#botaoEntrar').click(function (){
		$('#load').show();
		authenticateUser($('#email').val(), $('#senha').val());
	});
}

/**
 *	@description Authenticates a user
 *	
 *	@function
 *	@name authenticateUser
 *	@param {string}
 *	@param {string}
 */
function authenticateUser(email, password){
	ajaxSync("Control.php",{ "action": "authenticate_user", "email": email, "password": password }, function (data){
		if (data[0])
			window.location = pegaDiretorioHost();
		else
			showMessage(data[1], function (){
				$('#email').focus();
			}, false);
	});
}
