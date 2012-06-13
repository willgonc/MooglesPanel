<?php

require_once '../../Core.php';

Class Control extends Core {
    public function __construct() { 
		parent::open_connection();
		parent::select_database();
		parent::execute_action();
		parent::close_connection();
	}

	public function save_config () {
		$response = Array(True, '');
		# Get data
		$title = 		isset($_GET['titleSite']) ? $_GET['titleSite'] : null;
		$email = 		isset($_GET['notificationEmail']) ? $_GET['notificationEmail'] : null;
		$description = 	isset($_GET['descriptionSite']) ? $_GET['descriptionSite'] : null;
		$facebook = 	isset($_GET['facebookPage']) ? $_GET['facebookPage'] : null;
		$google_plus = 	isset($_GET['googlePlusPage']) ? $_GET['googlePlusPage'] : null;
		$twitter = 		isset($_GET['twitterPage']) ? $_GET['twitterPage'] : null;

		if ($this->str_require($title))
			$title = htmlentities($title, ENT_QUOTES, 'UTF-8');

		if ($this->str_require($description))
			$description = htmlentities($description, ENT_QUOTES, 'UTF-8');

		if ($this->str_require($email) && !$this->validate_email($email))
			$response = Array(False, 'Este e-mail n&atilde;o &eacute; v&aacute;lido!');

		if ($response[0] && !$this->is_valid_url($facebook) && $this->str_require($facebook))
			$response = Array(False,'A url do Facebook n&atilde;o &eacuute; v&aacute;lida!');

		if ($response[0] && !$this->is_valid_url($google_plus) && $this->str_require($google_plus))
			$response = Array(False,'A url do Google + n&atilde;o &eacuute; v&aacute;lida!');

		if ($response[0] && !$this->is_valid_url($twitter) && $this->str_require($twitter))
			$response = Array(False,'A url do Twitter n&atilde;o &eacuute; v&aacute;lida!');


		if ($response[0]) {
			$response = $this->update_config($title, $description, $email, $facebook, $google_plus, $twitter);
			parent::return_json($response);
		} else {
			parent::return_json($response);
		}
	}
    
	private function update_config ($title, $description, $email, $facebook, $google_plus, $twitter) {
		$sql = 'UPDATE config SET
			title_site="'.$title.'",
			email_notification="'.$email.'",
			description_site="'.$description.'",
			facebook_page="'.$facebook.'",
			google_plus_page="'.$google_plus.'",
			twitter_page="'.$twitter.'"';

		$update = parent::execute_query($sql);

		if ($update)
			return Array(True, 'As configura&ccedil;&otilde;es foram salvas!');
		else
			return Array(True, 'Erro ao salvar as configura&ccedil;&otilde;es!');
	}

	public function get_config () {
		$sql = 'SELECT * FROM config';
		
		$result = parent::execute_query($sql);

		if (parent::get_num_rows($result) == 1) {
			while ($row = parent::fetch_results($result)) {
				$vals = Array(
					'title' => html_entity_decode($row['title_site'], ENT_QUOTES, 'UTF-8'),
					'description' => html_entity_decode($row['description_site'], ENT_QUOTES, 'UTF-8'),
					'facebook' => $row['facebook_page'],
					'google_plus' => $row['google_plus_page'],
					'twitter' => $row['twitter_page'],
					'email' => $row['email_notification']
				);
			}
			parent::return_json(Array(True, $vals));
		} else {
			parent::return_json(Array(True, 'Erro ao consultar as configura&ccedil;&otilde;es!'));
		}
	}

	/**
     *  Checks whether a string is empty
	 *
     *  @access public
     *  @name str_require()
	 *	@param string
     *  @return bool
     */
    private function str_require($str) {
        $str = trim($str);
        if (strlen($str) == 0 || empty($str) || $str == '')
            return False;
        else 
            return True;
    }

	/**
     *  Valid email
	 *
     *  @access private
     *  @name validate_email()
	 *	@param string
     *  @return bool
     */
    private function validate_email($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
            return True;
        else
            return False;
    }

	/**
     *  Valid url
	 *
     *  @access private
     *  @name is_valid_url()
	 *	@param string
     *  @return bool
     */
	private function is_valid_url($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
}
new Control();

?>
