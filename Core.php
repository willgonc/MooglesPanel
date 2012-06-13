<?php

/**
 *	Center for general functions
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

require_once "Model.php";

Class Core extends Model {
    /**
     *  Get action of the request GET or POST
	 *
     *  @access private
     *  @name get_action()
     *  @return string | False
     */
	private function get_action() {
        if (isset($_GET['action']))
            return $_GET['action'];
        else if (isset($_POST['action']))
            return $_POST['action'];
        else
            return False;
	}

    /**
     *  Executes an action
	 *
     *  @access public
     *  @name execute_action()
     *  @param bool
     */
	public function execute_action(){
		$action = $this->get_action();

        if (func_num_args() == 1)
            $no_check_session = func_get_arg(0);

        if ($no_check_session) {
            $this->$action();
        } else {
            session_start();
            if (isset($_SESSION['data']))
                $this->$action();
            else
                $this->return_json(Array(null,'A sess&atilde; n&atilde;o foi encontrada!'));
        }
	}

    /**
     *  Return json response
	 *
     *  @access public
	 *	@param array
     *  @name return_json()
     */
	public function return_json($result) {
		echo json_encode($result);
	}

    /**
     *  Reads files menu of modules
	 *
     *  @access public
     *  @name read_file_menu_module()
     */
	public function read_file_menu_module() {
		$menu = Array();

		$diretorio = '../'; 
		$ponteiro  = opendir($diretorio);

		while ($i = readdir($ponteiro)) {
			if ($i != 'index.html' && $i != '.' && $i != '..'){
				if (file_exists('../'.$i.'/menu.php'))
					require_once '../'.$i.'/menu.php';
			}
		}

		$this->return_json(Array(True, $menu));
 	}
}

?>
