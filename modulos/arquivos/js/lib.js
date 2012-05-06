function init(){
	menuPrincipal('#menu');
	$('#listagemArquivos').show();
	$(':button').button();

	new AjaxUpload('botaoAdicionarArquivo', {
		action: 'Controle.php',
		data: {'acao':'uploadArquivo', 'path': pegaPath()},
		onSubmit: function (file, ext){
			var extencoes = /png|jpg|jpe|jpeg|gif|bmp|odt|docx|doc|txt|pdf|zip|rar/;
			if (ext.match(extencoes)){
				mostraLoading();
			} else {
				mostraMensagem('Arquivo em formato inv&aacute;lido!', function (){}, false);
				return false;
			}
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

	dataTableArquivos();
}

function dataTableArquivos(){
	ajaxSync( "Controle.php", { "acao": "pegaTodosArquivos" }, function (data){
		if (data[0]) {
			var arr = [];
			var widthTable = "100%";
			var arrTitulo = [
				{ "sTitle": "" },
				{ "sTitle": "Nome do arquivo" },
				{ "sTitle": "Tipo de arquivo" },
				{ "sTitle": "Data do upload"}
			];

			// montando array de dados
			for (var i = 0; i < data[1].length; i++){
				arr[i] = [
					'<img src="./upload/'+data[1][i].nome+'" width="80" height="80" />',
					'<a href="#" title="Editar" idArquivo="'+data[1][i].id+'" class="linkDatatables">'+data[1][i].legenda+
						'<img src="imagens/edit.png" border="0" /></a>',
					data[1][i].tipo,
					data[1][i].data
				];
			}

			montaTabelaDados('#datatablesArquivos', 'tabelaArquivos', arr, arrTitulo, function (){
				// Registra os eventos para edição dos dados do usuário
				$('.linkDatatables').live('click', function (){
					/*ajaxSync( "Controle.php", { "acao": "pegaDadosUsuario", "id": $(this).attr('idUsuario') }, function (data){
						if (data[0]){
							$('#idEdit').val(data[1].id);
							$('#nomeEdit').val(data[1].nome);
							$('#emailEdit').val(data[1].email);
							$('#senhaEdit').val('');
							$('#confirmaSenhaEdit').val('');
							$('#formularioEditarUsuario').dialog('open');
						} else {
							mostraMensagem( 'Erro ao buscar dados do usu&aacute;rio!', function (){}, data[0]);
						}
					});*/
				});
			});
		} else {
			mostraMensagem( data[0], function (){}, data[1]);
		}
	});

}
