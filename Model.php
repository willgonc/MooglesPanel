<?php

/**
 *  Class with functions for database manipulation
 *	@author Markus Vinicius da Silva Lima <markusslima@gmail.com>
 */

require_once "Config.php";

Class Model extends Config {
    
    # Link connection to the database 
    private $link;
	
    /**
     *	Open the connection to the database and setting charset
	 *
	 *	@access private
	 *	@name open_connection()
     */
    public function open_connection() {
        $this->link = mysql_connect(parent::get_host(), parent::get_user(), parent::get_pass());

        # setting charset mysql 
        mysql_set_charset('utf8', $this->link);
    }

    /**
     *	Select the database
	 *
	 *	@access private
	 *	@name select_database()
     */
    public function select_database() {
        mysql_select_db(parent::get_database());
    }

    /**
     *	Close the connection to the database
	 *
	 *	@access public
	 *	@name close_connection()
     */
    public function close_connection() {
        mysql_close($this->link);
    }

    /**
     *	Executes a sql and returns the result on success
	 *
	 *	@access public
	 *	@name execute_query()
     *	@param string
     *  @return result
     */
    public function execute_query($sql) {
        try {
            $result = mysql_query($sql);
            return $result;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     *  Returns an associative array indexed or the result of a query
	 *
	 *	@access public
	 *	@name fetch_results()
     *	@param result 
     *  @return array
     */
    public function fetch_results($result) {
        return mysql_fetch_array($result, MYSQL_BOTH);
    }

    /**
     *  returns the number of rows from a query
	 *
	 *	@access public
	 *	@name get_num_rows()
     *	@param result
     *  @return int
     */
    public function get_num_rows($result) {
        return mysql_num_rows($result);
    }
}

?>
