<?php
	//Database connection info
	define ('DB_HOST', 'localhost');
	define ('DB_USER', 's632005_AmblinK');
	define ('DB_PASSWORD', 'oY2XsbrxON');
	define ('DB_DB', 's632005_Project1');
	
	class ConnectionDAL {
		private static $instance = null;
		private $connection;
		
		public function GetConnection(){
			return $this->connection;
		}
		
		// Get an instance of the Database (singleton)
		public static function GetInstance() {
				if(!self::$instance) { // If no instance then make one
					self::$instance = new self();
				}
				return self::$instance;
			}
			
		// Constructor (can only go through getInstance())
		//makes database connection when instantiated 
		private function __construct() {
			$this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)
				or die ("<br/>Could not connect to MySQL server");
				
				mysqli_select_db($this->connection, DB_DB)
				or die ("<br/>Could not select the indicated database");
					
				return $this->connection;
			
		// Error handling
			if(mysqli_connect_error()) {
				trigger_error("Failed to connect to MySQL: " . mysql_connect_error(), E_USER_ERROR);
			}
		}
		
		//close DB connection
		function CloseConnection(){
			mysqli_close($this->connection);
		}
	
	}
		
		
?>