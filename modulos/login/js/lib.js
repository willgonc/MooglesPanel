function init(){
	$('#email').focus();

	$('#email, #senha').keypress(function (){
		if (event.keyCode == 13)
			autenticaUsuario($('#email').val(), $('#senha').val());
	});
	$('#botaoEntrar').click(function (){
		autenticaUsuario($('#email').val(), $('#senha').val());
	});
}
var teste;


function autenticaUsuario(email, senha){
	$.getJSON("AutenticaUsuario.php",{ "email": email, "senha": senha }, function (data){
		teste = data;
		if (data.resposta)
			window.location = "../../index.php";
		else
			alert('Usuario ou senha incorretos!');
		
	});
}
