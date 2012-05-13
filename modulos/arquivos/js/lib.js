function init(){
	menuPrincipal('#menu');
	$('#listagemArquivos').show();
	$(':button, :submit').button();

	// Diálogo do formulário de inclusão
	criaDialogoFormulario('#formularioAddArquivo', 'Adicionar arquivo', function (){
		if ($('#arquivo').val()) {
			$('#formAddArquivo').submit();
		} else {
			$('#formularioAddArquivo').dialog('close');
			mostraMensagem( 'Selecione um arquivo!', function (){ $('#formularioAddArquivo').dialog('open'); }, false);
		}
	}, function (){}, function (){
		$('#arquivo').val('');
	});

	$('#botaoAddArquivo').click(function (){
		$('#formularioAddArquivo').dialog('open');
	});
	
	dataTableArquivos();
}

var ARRTHUMB = {
	'DOC' 	: 'doc.png',
	'DOCX' 	: 'doc.png',
	'ODS'	: 'doc.png',
	'ZIP' 	: 'compact.png',
	'RAR' 	: 'compact.png',
	'PDF' 	: 'pdf.png',
	'XLS' 	: 'planilha.png'
}


function dataTableArquivos(){
	ajaxSync( "Controle.php", { "acao": "pegaTodosArquivos" }, function (data){
		if (data[0]) {
			var arr = [];
			var widthTable = "100%";
			var arrTitulo = [
				{ "sTitle": "", "sWidth": "68px", "sClass": "center", "bSortable": false },
				{ "sTitle": "Nome do arquivo" },
				{ "sTitle": "Tipo de arquivo", "sWidth": "150px", "sClass": "center"  },
				{ "sTitle": "Data do upload", "sWidth": "150px", "sClass": "center"  }
			];

			// montando array de dados
			for (var i = 0; i < data[1].length; i++){
				var thumb;
				var extencoes = /png|jpg|jpe|jpeg|gif|bmp/;

				if (data[1][i].nome.match(extencoes)){
					thumb = '<img src="./upload/'+data[1][i].nome+'" width="80" height="80" />';
				} else {
					thumb = '<img src="./imagens/'+ARRTHUMB[data[1][i].tipo]+'" />';
				}
				arr[i] = [
					thumb,
					'<a href="#" title="Editar" idArquivo="'+data[1][i].id+'" class="linkDatatables">'+data[1][i].legenda+
						'<img src="../../imagens/edit.png" border="0" /></a>',
					data[1][i].tipo,
					formataDataBanco(data[1][i].data)
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
