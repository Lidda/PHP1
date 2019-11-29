<?php
	require_once '../Model/Neighbor.php';
	require_once 'ConnectionDAL.php';
	
	class NeighborDAL {
		private $connection;
		private $connectionDAL;
			
		//makes database connection when instantiated 
		function __construct() {
			$this->connectionDAL = ConnectionDAL::GetInstance();
			$this->connection = $this->connectionDAL->GetConnection();
		}
		
		//close database connection
		function dbCloseConnection(){
			$this->connectionDAL->CloseConnection();
		}
		
		// gets all neighbors info from database and returns a filled array
		function GetAllNeighborsDB(){
			$sql = "SELECT neighbors.neighborID as id, name, imageURL, animal, birthday, coffee, personality
					FROM neighbors;";
				
			$neighbors = [];
			$result = mysqli_query($this->connection, $sql);
			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)) {
					$id = $row["id"];
					$name = $row["name"];
					$imageURL = $row["imageURL"];
					$animal = $row["animal"];
					$birthday = $row["birthday"];
					$coffee = $row["coffee"];
					$personality = $row["personality"];
					
					$neighbor = new Neighbor($id, $name, $imageURL, $animal, $birthday, $coffee, $personality);
					$neighbors[] = $neighbor;
				}
				return $neighbors;
			} else { 
				echo 'no results found';
			}
		}
		
		// get neighbors from the database based on a searchterm and category (id, name, email or registrationDate)
		function GetNeighborsInfoDB($searchTerm, $category){
			//cleans up users input and makes it lowercase (for the switch)
			$searchTerm = strtolower(mysqli_real_escape_string($this->connection, $searchTerm));
			$category = strtolower(mysqli_real_escape_string($this->connection, $category));
			
			$sql;
			$baseQuery = "SELECT neighbors.neighborID as id, name, imageURL, animal, birthday, coffee, personality
				FROM neighbors "; 
			
			switch ($category) {
			case "id":
				$sql = $baseQuery."WHERE neighbors.neighborID LIKE '$searchTerm'";
				break;
			case "name":
				$sql = $baseQuery."WHERE neighbors.name LIKE '$searchTerm'";
				break;
			case "personality":
				$sql =  $baseQuery."WHERE neighbors.personality LIKE '$searchTerm'";
				break;
			case "animal":
				$sql =  $baseQuery."WHERE neighbors.animal LIKE '$searchTerm'";
				break;
			}
			
			//creates & returns array filled with User objects (from database)
			$neighbors = [];
			$result = mysqli_query($this->connection, $sql);
			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)) {
					$id = $row["id"];
					$name = $row["name"];
					$imageURL = $row["imageURL"];
					$animal = $row["animal"];
					$birthday = $row["birthday"];
					$coffee = $row["coffee"];
					$personality = $row["personality"];
					
					$neighbor = new Neighbor($id, $name, $imageURL, $animal, $birthday, $coffee, $personality);
					$neighbors[] = $neighbor;
				}
				return $neighbors;
			} else { 
				echo 'no neighbors found';
			}
			
			return $neighbors;
		}
		
	}
?>