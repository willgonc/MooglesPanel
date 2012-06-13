function init() {
	$('#tab').tabs();
	$(':button').button();

	getConfig();

	$('#btnSave').click(function () {
		ajaxSync(
			"Control.php", { 
				"action": "save_config",
				"titleSite": 			$('#titleSite').val(), 
				"notificationEmail": 	$('#notificationEmail').val(), 
				"descriptionSite": 		$('#descriptionSite').val(), 
				"facebookPage": 		$('#facebookPage').val(), 
				"googlePlusPage": 		$('#googlePlusPage').val(), 
				"twitterPage": 			$('#twitterPage').val()
			}, function (data){
				showMessage( data[1], function (){ }, data[0]);
			}
		);
	});
}

function getConfig () {
	ajaxSync(
		"Control.php", { 
			"action": "get_config"
		}, function (data){
			if (data[0]) {
				$('#titleSite').val(data[1].title);
				$('#notificationEmail').val(data[1].email);
				$('#descriptionSite').val(data[1].description), 
				$('#facebookPage').val(data[1].facebook), 
				$('#googlePlusPage').val(data[1].google_plus), 
				$('#twitterPage').val(data[1].twitter)
			} else {
				showMessage( data[1], function (){}, data[0]);
			};
		}
	);
}
