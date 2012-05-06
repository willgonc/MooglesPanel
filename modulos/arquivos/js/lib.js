function init(){
	menuPrincipal('#menu');
	$('#listagemArquivos').show();
	$(':button').button();

	new AjaxUpload('botaoAdicionarArquivo', {
		action: 'Controle.php',
		data: {'acao':'uploadArquivo', 'path': pegaPath()},
		onSubmit: function (){
			mostraLoading();
		},
		onComplete: function (file, response){
			escondeLoading();
			data = eval(response);
			mostraMensagem(data[1], function(){
				if (data[0])
					document.location.reload();
			}, data[0]);
		}
	});	
}

function dataTableArquivos(){

}
