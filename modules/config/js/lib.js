var t;
function init() {
	$('#tab').tabs();
	$(':button').button();

	getConfigGeneral();

	$('#btnSaveGeneral').click(function () {
		ajaxSync(
			"Control.php", { 
				"action": "save_general",
				"titleSite": $('#titleSite').val(), 
				"notificationEmail": $('#notificationEmail').val(), 
				"protocol": $('#protocol').val()
			}, function (data){
				showMessage( data[1], function (){
					document.location.reload();
				}, data[0]);
			}
		);
	});
}

function getConfigGeneral () {
	ajaxSync(
		"Control.php", { 
			"action": "get_general"
		}, function (data){
				t = data;
			if (data[0]) {
				$('#titleSite').val(data[1].title);
				$('#notificationEmail').val(data[1].email);
				$('#protocol').val(data[1].protocol);
			} else {
				showMessage( data[1], function (){}, data[0]);
			};
		}
	);
}
