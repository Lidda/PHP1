<?php
	require_once '../DAL/NeighborDAL.php';
	
	class NeighborLogic {
		private $neighborDAL;
		
		function __construct(){
			$this->neighborDAL = new NeighborDAL();
		}
		
		//closes the db connection through neighborDAL
		function CloseConnection(){
			$this->neighborDAL->dbCloseConnection();
		}
		
		//calls the function to get all neighbors from db in neighborDAL
		function GetAllNeighbors(){
			return $this->neighborDAL->GetAllNeighborsDB();
		}
		
		//calls the function to get a specific neighbors' info in neighborDAL
		function GetNeighborInfo($searchTerm, $category){
			return $this->neighborDAL->GetNeighborsInfoDB($searchTerm, $category);
		}
		
		//calls the function to add favourite in neighborDAL
		function AddFavouriteNeighbour($userID, $neighborID){
			return AddFavouriteNeighbourDB($userID, $neighborID);
		}
	}
?>