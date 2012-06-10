<?php

/**
 *	Instalation file
 */

require_once "Model.php";

Class Install extends Model {
	public function __construct() {
		# Start connection
		parent::open_connection();
		parent::select_database();
		
		# Create tables
		$this->createTables();
		
		# Close connection
		parent::close_connection();
	}

	/*
	 *	Create tables
	 *
	 *	@access private
	 *	@name createTables()
	 */
	private function createTables() {
		$sql = "CREATE TABLE IF NOT EXISTS user (
			id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name 		VARCHAR(255) NOT NULL,
			email 		VARCHAR(255) NOT NULL,
			type 		VARCHAR(40) NOT NULL,
			password 	VARCHAR(40) NOT NULL)";

		$result = parent::execute_query($sql);

		if ($result)
			print "<b>user:</b> Table was created successfully!<br />";
		else
			print "Error: <span style='color: red'>".mysql_error()."</span>";

		# Search for user admin
		$sql_user = "SELECT * FROM user WHERE email='admin@painel.com'";
		$r_user = parent::execute_query($sql_user);
		
		# The Administrator user has been created
		if (parent::get_num_rows($r_user) == 0) {
			# Insert default user
			$sql2 = "INSERT INTO user
				(name, email, type, password) VALUES 
				('Administrador','admin@painel.com', 'administrador', '".sha1(123456)."')";
			
			$result2 = parent::execute_query($sql2);
			
			if ($result2)
				print "The Administrator user was created successfully!<br />";
			else
				print "Erro: ".mysql_error()."<br />";
		} else {
			print "<span style='color: red'>The Administrator user has been created!</span><br />";
		}


		$sql = "CREATE TABLE IF NOT EXISTS config (
			id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title_site 				VARCHAR(255) NOT NULL,
			description_site		VARCHAR(255) NOT NULL,
			email_notification 		VARCHAR(255) NOT NULL,
			facebook_page 			VARCHAR(255) NOT NULL,
			google_plus_page 		VARCHAR(255) NOT NULL,
			twitter_page 			VARCHAR(255) NOT NULL,
			protocol 				VARCHAR(5) NOT NULL)";

		$result = parent::execute_query($sql);

		# Search for user admin
		if ($result)
			print "<b>config:</b> Table was created successfully!<br />";
		else
			print "Error: <span style='color: red'>".mysql_error()."</span>";

		# Search for configuration
		$sql_config = "SELECT * FROM config";
		$r_config = parent::execute_query($sql_config);
		
		# The configuration has been created
		if (parent::get_num_rows($r_config) == 0) {
			# Insert default configuration
			$sql2 = "INSERT INTO config
				(title_site, description_site, email_notification, facebook_page, google_plus_page, twitter_page, protocol) VALUES 
				('My site', 'Description' ,'admin@painel.com', '', '', '', 'http')";
			
			$result2 = parent::execute_query($sql2);
			
			if ($result2)
				print "The configuration was created successfully!<br />";
			else
				print "Erro: ".mysql_error()."<br />";
		} else {
			print "<span style='color: red'>The conguration has been created!</span><br />";
		}
	}
}

new Install();

?>
