<?php

/**
 *	Class of user control
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

require_once "../../Core.php";

Class Control extends Core {

	private $id;
	private $name;
	private $email;
	private $password;
	private $confirm_password;

    public function __construct() { 
		parent::open_connection();
		parent::select_database();
		parent::execute_action();
		parent::close_connection();
	}

	/**
     *  Add user
	 *
     *  @access puplic
     *  @name add_user()
     */
	public function add_user(){
		$this->get_data();
        $response = Array(True, '');
		
        if (!$this->str_require($this->name) || !$this->str_require($this->email) || !$this->str_require($this->password) || !$this->str_require($this->confirm_password)) {
            $response[0] = False;
            $response[1] = "Preencha todos os campos obrigat&oacute;rios do formul&aacute;rio!";
        } else if (!$this->validate_email($this->email)) {
            $response[0] = False;
            $response[1] = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if ($this->password != $this->confirm_password) {
            $response[0] = False;
            $response[1] = "Confirme a senha corretamente!";
        } else if (strlen($this->password) < 6) {
            $response[0] = False;
            $response[1] = "A senha deve ter no m&iacute;nimo 6 caracteres!";
        } else {
			$check = $this->check_email();
			if ($check[0] == False){
				$response[0] = $check[0];
				$response[1] = $check[1];
			}
		}

        if ($response[0]) {
			$this->password = sha1($this->password);

			$this->name = htmlentities($this->name, ENT_QUOTES, "UTF-8");
			try {
				$insert = parent::execute_query("INSERT INTO user (name, email, password) 
							VALUES ('".$this->name."','".$this->email."', '".$this->password."')");
				
				if ($insert) {
					$response[0] = True;
					$response[1] = "O usu&aacute;rio foi adicionado com sucesso!";
				} else {
					$response[0] = False;
					$response[1] = "Erro ao adicionar o usu&aacute;rio!";
				}
			} catch ( Exception $e ){
				$response[0] = False;
				$response[1] = "Erro ao adicionar o usu&aacute;rio!";
			}
		}
		parent::return_json($response);
	}

    /**
     *  Delete user
	 *
     *  @access public
     *  @name rm_user()
     */
	public function rm_user(){
		session_start();
		$response = Array(True, '');
		$select = parent::execute_query('SELECT id FROM user');
		if (parent::get_num_rows($select) == 1){
			$response[0] = False;
			$response[1] = "Este &eacute; o &uacute;nico usu&aacute;rio do painel, por isso voc&ecirc; n&atilde;o pode exclu&iacute;-lo!";
		} else if ($_GET['id'] == $_SESSION['data']['id']) {
			$response[0] = False;
			$response[1] = "Voc&ecirc; n&atilde;o pode excluir este usu&aacute;rio!";
		} else {
			$delete = parent::execute_query("DELETE FROM user WHERE id=".$_GET['id']);

			if ($delete) {
				$response[0] = True;
				$response[1] = "O usu&aacute;rio foi removido!";
			} else {
				$response[0] = False;
				$response[1] = "Erro ao remover usu&aacute;rios!";
			}
		}
        parent::return_json($response);
	}
	
    /**
     *  The user updates the data in the database
	 *
     *  @access public
     *  @name edit_user()
     */
	public function edit_user() {
		$this->get_data();
        $response = Array(True, '');
		
        if (!$this->str_require($this->name) || !$this->str_require($this->email)) {
            $response[0] = False;
            $response[1] = "Preencha todos os campos obrigat&oacute;rios do formul&aacute;rio!";
        } else if (!$this->validate_email($this->email)) {
            $response[0] = False;
            $response[1] = "O e-mail n&atilde;o &eacute; v&aacute;lido!";
        } else if ($this->str_require($this->password) || $this->str_require($this->confirm_password)){
			if ($this->password != $this->confirm_password) {
				$response[0] = False;
				$response[1] = "Confirme a senha corretamente!";
			} else if (strlen($this->password) < 6) {
				$response[0] = False;
				$response[1] = "A senha deve ter no m&iacute;nimo 6 caracteres!";
			}
        } else {
			$check = $this->check_email();
			if (!$check[0]){
				$response[0] = $check[0];
				$response[1] = $check[1];
			}
		}

        if ($response[0]) {
			$this->password = $this->str_require($this->password) ? sha1($this->password) : null;

			$this->name = htmlentities($this->name, ENT_QUOTES, "UTF-8");
			try {
				$update = parent::execute_query("UPDATE user SET 
					name='".$this->name."', 
					email='".$this->email."'
					".($this->password != null ? ", password='".$this->password."'" : "")."
					WHERE id=".$this->id);

				if ($update) {
					session_start();
        			if ($_SESSION['data']['id'] == $this->id){
						$_SESSION['data']['name'] = $this->name;
						$_SESSION['data']['email'] = $this->email;
						if ($this->password != null){
							$_SESSION['data']['password'] = $this->password;
						}
					}

					$response[0] = True;
					$response[1] = "O usu&aacute;rio foi editado!";
				} else {
					$response[0] = False;
					$response[1] = "Erro ao editar usu&aacute;rio!2";
				}
			} catch ( Exception $e ){
				$response[0] = False;
				$response[1] = "Erro ao editar usu&aacute;rio!1";
			}
		}

		parent::return_json($response);
	}
    
	/**
     *  Pega os dados recebidos na requisição
	 *
     *  @access puplic
     *  @name get_data()
     */
	private function get_data() {
		$this->id = 				isset($_GET['id']) ? $_GET['id'] : null;
		$this->name =		 		isset($_GET['name']) ? $_GET['name'] : null;
		$this->email = 				isset($_GET['email']) ? strtolower($_GET['email']) : null;
		$this->password = 			isset($_GET['password']) ? $_GET['password'] : null;
		$this->confirm_password = 	isset($_GET['confirmPassword']) ? $_GET['confirmPassword'] : null;
	}

	/**
     *  Verified email address
	 *
     *  @access private
     *  @name check_email()
	 *	@return array
     */
	private function check_email() {
		$whereId = $this->id != null ? ' and id<>'.$this->id : '';
        $response = Array(True, '');
        try {
            $result = parent::execute_query("SELECT * FROM user WHERE email='".$this->email."'".$whereId);
            if ($result) {
                if (parent::get_num_rows($result) == 0) {
					$response[0] = True;
					$response[1] = "";
                } else {
					$response[0] = False;
					$response[1] = "Este e-mail j&aacute; est&aacute; cadastrado!";
                }
            } else {
				$response[0] = False;
				$response[1] = "Erro ao verificar o e-mail!";
            }
        } catch ( Exception $e ) {
			$response[0] = False;
			$response[1] = "Erro ao verificar o e-mail!";
        }
        return $response;
    }

    /**
     *  Get all registered users
	 *
     *  @access public
     *  @name get_all_users()
     */
	public function get_all_users() {
        $response = Array(True, '');
		$vals = Array();
        try {
			$select = parent::execute_query("SELECT * FROM user ORDER BY name");
            
            if ($select) {
				while ($row = parent::fetch_results($select)) {
					$vals[] = Array(
						'id' => $row['id'],
						'name' => $row['name'],
						'email' => $row['email']
					);
				}
				$response[0] = True;
				$response[1] = $vals;
            } else {
				$response[0] = False;
				$response[1] = "Erro ao buscar usu&aacute;rios!";
            }
        } catch ( Exception $e ) {
			$response[0] = False;
			$response[1] = "Erro ao buscar usu&aacute;rios!";
        }
        parent::return_json($response);
	}

	/**
     *  Get data from the user
	 *
     *  @access public
     *  @name get_data_user()
     */
	public function get_data_user() {
	 	$this->get_data();
	 	$select = parent::execute_query('SELECT * FROM user WHERE id='.$this->id);
		if ($select) {
			if (parent::get_num_rows($select) == 1) {
				while($row = parent::fetch_results($select)) {
					$arr = Array(
						'id' => $row['id'],
						'nome' => html_entity_decode($row['name'], ENT_QUOTES, 'UTF-8'),
						'email' => $row['email'],
						'senha' => $row['password']
					);
				}
				parent::return_json(Array(true, $arr));
			} else {
				parent::return_json(Array(False,'Erro ao buscar dados do usuário!'));
			}
		} else {
			parent::return_json(Array(False, 'Erro ao buscar dados do usuário!'));
		}
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
