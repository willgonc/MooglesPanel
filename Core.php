<?php

###################################################################
#
#	Center for general functions
#	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
#
###################################################################

require_once "Model.php";

Class Core extends Model {

    /**
     *  Get actioni of the request GET or POST
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
     */
	public function execute_action(){
		$action = $this->get_action();

		if ($action)
			$this->$action();
		else
			$this->retornaResultado(Array(False,'A a&ccedil;&atilde;o '.$action.' n&atilde;o foi encontrada!'));
	}

    /**
     *  Return json response
	 *
     *  @access private
     *  @name return_json()
     */
	public function return_json($result) {
		echo json_encode($result);
	}

    /**
     *  Gets open session
	 *
     *  @access public
     *  @name get_session()
     *  @return array|false
     */
    public function get_session() {
        return isset($_SESSION['data']) ? $_SESSION['data'] : False;
    }
}

new ControleGeral();

?>
