<?php

require_once '../../Core.php';

Class Control extends Core {
    public function __construct() { 
		parent::open_connection();
		parent::select_database();
		parent::execute_action();
		parent::close_connection();
	}

	public function save_general () {
		$response = Array(True, '');
		# Get data
		$title = isset($_GET['titleSite']) ? $_GET['titleSite'] : null;
		$email = isset($_GET['notificationEmail']) ? $_GET['notificationEmail'] : null;
		$protocol = isset($_GET['protocol']) ? $_GET['protocol'] : null;

		if ($this->str_require($title))
			$title = htmlentities($title, ENT_QUOTES, 'UTF-8');

		if ($this->str_require($email)) {
			if (!$this->validate_email($email))
				$response[1] = 'Este e-mail n&atilde;o &eacute; v&aacute;lido!';
		}

		if ($protocol != 'http' && $protocol != 'https')
			$response[1] = 'Os protocolos v&aacute;lidos s&atilde;o http ou https!';

		if ($response[0]) {
			$response = $this->update_data_general($title, $email, $protocol);
			parent::return_json($response);
		} else {
			parent::return_json($response);
		}
	}
    
	private function update_data_general ($title, $email, $protocol) {
		$sql = 'UPDATE config SET
			title_site="'.$title.'",
			email_notification="'.$email.'",
			protocol="'.$protocol.'"';

		$update = parent::execute_query($sql);

		if ($update)
			return Array(True, 'As configura&ccedil;&otilde;es gerais foram salvas!');
		else
			return Array(True, 'Erro ao salvar as configura&ccedil;&otilde;es gerais!');
	}

	public function get_general () {
		$sql = 'SELECT * FROM config';
		
		$result = parent::execute_query($sql);

		if (parent::get_num_rows($result) == 1) {
			while ($row = parent::fetch_results($result)) {
				$vals = Array(
					'title' => $row['title_site'],
					'email' => $row['email_notification'],
					'protocol' => $row['protocol']
				);
			}
			parent::return_json(Array(True, $vals));
		} else {
			parent::return_json(Array(True, 'Erro ao consultar as configura&ccedil;&otilde;es gerais!'));
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
}
new Control();

?>
