function init(){
	$('#load').hide();
	$('#email').focus();

	$('#email, #senha').keypress(function (){
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

function autenticaUsuario(email, senha){
	if (email.length > 0 && senha.length > 0){
		$.getJSON("AutenticaUsuario.php",{ "email": email, "senha": senha }, function (data){
			
			if (data.resposta) {
				window.location = "../../index.php";
			} else {
				$('#load').hide();
				$('#msg').html('Usuario ou senha incorretos!');
				$('#email').focus();
			}
		});
	} else {
		$('#load').hide();
		$('#msg').html('Preencha os campos corretamente!');
		$('#email').focus();
	}
}
