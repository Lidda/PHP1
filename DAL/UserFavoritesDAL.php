<?php
	require_once dirname(__FILE__).'/ConnectionDAL.php';
	require_once dirname(__FILE__).'/../Model/Neighbor.php';

	class UserFavoritesDAL {
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

		//get one users' favorite neighbors (by filtering on userID)
		function GetFavoriteNeighborsDB($userID){
			$sql = "SELECT neighbors.neighborID as id, name, imageURL, animal, birthday, coffee, personality
					FROM user_favorites
					JOIN neighbors ON user_favorites.neighborID = neighbors.neighborID
					WHERE userID = '$userID';";

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
				return[];
			}
		}

		function FavoriteNeighborDB($userID, $neighborID){
			$sql = "INSERT INTO user_favorites (userID, neighborID) VALUES ('$userID', '$neighborID');";
			echo $sql;
			$success = mysqli_query($this->connection, $sql);
			return $success; //returns true if query was executed
		}

		function DeleteFavoriteNeighborDB($userID, $neighborID){
			$sql = "DELETE FROM user_favorites WHERE userID = '$userID' AND neighborID = '$neighborID';";
			$success = mysqli_query($this->connection, $sql);
			return $success; //returns true if query was executed
		}
	}
?>
