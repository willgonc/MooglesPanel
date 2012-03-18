function verificaAutenticacao(param){
	$.get("../../VerificaAutenticacao.php", function (data){
		if (data == true)
			init();
		else
			if (!param)
				window.location = "../../modulos/login/";
	});
}
