function verificaAutenticacao(){
	$.ajax({
	    type: 'GET',
		url: "../../VerificaAutenticacao.php",
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
