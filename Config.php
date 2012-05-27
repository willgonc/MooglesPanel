<?php

#####################################################################
#
#	 Class configuration panel
#	 @author Markus Vinicius da Silva Lima <markusslima@gmail.com>
#
#####################################################################

Class Config {
	# Your mysql user
    private $user = "root";

	# Your mysql password
    private $pass = "123456";

	# Your mysql server host
    private $host = "localhost";

	# Your mysql database
    private $database = "tudosobreweb";

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
