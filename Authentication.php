<?php

###################################################################
#
#	User authentication
#	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
#
###################################################################

require_once "Core.php";

Class Authentication extends Core {

    public function __construct() {
		parent::open_connection();
		parent::select_database();
        session_start();
		parent::execute_action();
		parent::close_connection();
    }
    
    /**
     *  Check authenticated user
	 *
     *  @access public
     *  @name check_user()
     *  @return JSON
     */
    public function check_user() {
		$data = $this->get_session();
		$response = Array(False, 'Usu&aacute;rio n&atilde;o autenticado!');

		if ($data) {
			$sql = 'SELECT * FROM user WHERE email="'.$data['email'].'" and password="'.$data['senha'].'"'; 
            
            $result = parent::execute_query($sql);

            if ($result) {
                if (parent::get_num_rows($result) == 1){
                    $response[0] = True;
                    $response[1] = 'Usu&aacute;rio validado!';
                } else {
                    $response[0] = False;
                    $response[1] = 'E-mail ou Senha incorretos!';
				}
            } else { 
                $response[0] = False;
				$response[1] = 'Erro ao validar o usu&aacute;rio!';
            }
		}
		parent::return_json($response);
    }
	
	/**
     *  Closes an open session
	 *
     *  @access public
     *  @name close_session()
     *  @return JSON
     */
    public function close_session() {
        session_destroy();
		parent::return_json(Array(True, 'A sess&atilde;o foi fechada com sucesso!'));
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

new Authentication();

?>
