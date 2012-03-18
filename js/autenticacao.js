function verificaAutenticacao(param){
	$.getJSON("../../VerificaAutenticacao.php", function (data){
		if (data.resposta) {
			if (param)
				window.location = "../../";
			else
				init();

		} else {
			if (param)
				init();
			else
				window.location = "../../modulos/login/";

		}
	});
}
