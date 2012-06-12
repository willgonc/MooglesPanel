<?php

/**
 *	 Class configuration panel
 *	 @author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

Class Config {

	# Your mysql user
    private $user = "you_user";

	# Your mysql password
    private $pass = "you_password";

	# Your mysql server host
    private $host = "you_host";

	# Your mysql database
    private $database = "you_database";

    /**
     *  Return the user mysql
	 *
     *  @access public
     *  @name get_user()
     *  @return string
     */
    public function get_user() {
        return $this->user;
    }

    /**
     *  Return the password mysql
	 *
     *  @access public
     *  @name get_pass()
     *  @return string
     */
    public function get_pass() {
        return $this->pass;
    }
    
    /**
     *  Return the host server mysql
	 *
     *  @access public
     *  @name get_host()
     *  @return string
     */
    public function get_host() {
        return $this->host;
    }

    /**
     *  Returns the name of the database
	 *
     *  @access public
     *  @name get_database()
     *  @return string
     */
    public function get_database() {
        return $this->database;
    }
}

?>
