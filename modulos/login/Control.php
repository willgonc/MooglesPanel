<?php

#######################################################################
#
#	Class for user authentication
#	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
#
#######################################################################

require_once "../../Core.php";

Class Control extends Core {

	private $id;
	private $name;
	private $email;
	private $password;

	public function __construct() {
		parent::open_connection();
		parent::select_database();
		parent::execute_action();
		parent::close_connection();
	}

    /**
     *  Authenticates data sent by the form and creates the session if they 
	 *		are correct
	 *
     *  @access public
     *  @name authenticate_user()
	 *	@return JSON
     */
	public function authenticate_user() {
		session_start();
        $this->email = $_GET['email'];
        $this->senha = $_GET['password'];
		$data = $this->validate_data();

		if ($data[0] == True) {
            $this->create_session();
            parent::return_json(Array(True,'A sess&atilde;o foi criada!'));
        } else {
            $this->destroy_session();
            parent::return_json(Array(False, $data[1]));
        }
	}

    
    /**
     *	Create a session storing user data  
	 *
     *  @access private
     *  @name create_session()
     */
    private function create_session() {
        $_SESSION['data'] = Array(
			'id' 	=> $this->id,
			'name' 	=> $this->name,
			'email' => $this->email,
			'password' => $this->password,
		);
    }

    /**
     *  Destroy session
	 *
     *  @access private
     *  @name destroy_session()
     */
    private function destroy_session() {
        session_destroy();
    }

    /**
     *  Validated data
	 *
     *  @access private
     *  @name validate_data()
	 *	@return array
     */
    private function validate_data() {
		$arr = Array(False, 'Preencha todos os campos!');
        if ($this->str_require($this->email) || $this->str_require($this->password)) {

			$sql = 'SELECT * FROM user WHERE email="'.$this->email.'" and password="'.sha1($this->senha).'"';
			$result = parent::execute_query($sql);
		
			if ($result) {
				if (parent::get_num_rows($result) == 1) {

					$arrData = Array();
					while ($row = parent::fetch_results($result)) {
						$this->id = $row['id'];
						$this->name = $row['name'];
						$this->email = $row['email'];
						$this->password = $row['password'];
					}

					$arr[0] = True;
					$arr[1] = 'Usu&aacute;rio autenticado!';
				} else {
					$arr[0] = False;
					$arr[1] = 'Usu&aacute;rio ou senha incorretos!';
				}
			} else {
				$arr[0] = False;
				$arr[1] = 'Erro ao validar os dados!';
			}
        }
		return $arr;
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
}

new Control();

?>
