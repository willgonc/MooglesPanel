function init(){
	$('#load').hide();
	$('#email').focus();

	$('#email, #senha').keypress(function (){
		if (event.keyCode == 13){
			autenticaUsuario($('#email').val(), $('#senha').val());
			$('#load').show();
		}
	});
	$('#botaoEntrar').click(function (){
		$('#load').show();
		autenticaUsuario($('#email').val(), $('#senha').val());
	});
}

function autenticaUsuario(email, senha){
	$.getJSON("AutenticaUsuario.php",{ "email": email, "senha": senha }, function (data){
		setTimeout("$('#load').hide()",2000);
		
		if (data.resposta)
			window.location = "../../index.php";
		else
			$('#msg').html('Usuario ou senha incorretos!');
		
	});
}
