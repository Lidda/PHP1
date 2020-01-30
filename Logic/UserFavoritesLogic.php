<?php
	require_once dirname(__FILE__).'/../DAL/UserFavoritesDAL.php';

	class UserFavoritesLogic {
		private $favesDAL;

		function __construct(){
			$this->favesDAL = new UserFavoritesDAL();
		}

		//closes the db connection through neighborDAL
		function CloseConnection(){
			$this->favesDAL->dbCloseConnection();
		}

		function GetFavoriteNeighbors($userID){
			return $this->favesDAL->GetFavoriteNeighborsDB($userID);
		}

		//calls the function to add favorite in neighborDAL
		function FavoriteNeighbor($userID, $neighborID){
			//checks if the neighbor is not already in their favourites
			$neighbors = $this->favesDAL->GetFavoriteNeighborsDB($userID);
			if (in_array($neighborID, $neighbors)){
				return false;
			} else {
				return $this->favesDAL->FavoriteNeighborDB($userID, $neighborID);
			}
		}

		function DeleteFavoriteNeighbor($userID, $neighborID){
			return $this->favesDAL->DeleteFavoriteNeighborDB($userID, $neighborID);
		}
	}
?>
