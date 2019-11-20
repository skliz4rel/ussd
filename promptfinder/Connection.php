<?php
include('config.inc');

	class Connection{

		//Declaring the variable of the class
		public $connection = null;
	
		function __construct(){
			
		}
		
		//This is going to return the connection object
		function doConnection(){
			$dsn = 'mysql:dbname='.database.';host='.dbserverip;
				$user = ''.username;
				$password = ''.password;

				try {
					$this->connection = new PDO($dsn, $user, $password);
					
					//Now we are going to select the database below
					$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
					
				} catch (PDOException $e) {
					//echo 'Connection failed: ' . $e->getMessage();
				}
				
			return $this->connection;
		}
	}
?>