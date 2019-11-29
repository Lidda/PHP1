<?php
	require_once '../DAL/UserDAL.php';
	
	class UserLogic {
		private $userDAL;
		
		function __construct(){
			$this->userDAL = new UserDAL();
		}
		
		//closes the db connection through userDAL
		function CloseConnection(){
			$this->userDAL->dbCloseConnection();
		}
		
		//checks if a given email is already in the database
		function EmailAvailable($email){
			$allUsers = $this->userDAL->GetAllUsersDB();
			foreach ($allUsers as $u){
				if ($u->getEmailAddress() == $email) {
					return false;
				}
			}
			
			return true;
		}
		
		//calls the function to get all users from db in userDAL
		function GetAllUsers(){
			return $this->userDAL->GetAllUsersDB();
		}
		
		//calls the function to get a specific users' info in userDAL
		function GetUsersInfo($searchTerm, $category){
			return $this->userDAL->GetUsersInfoDB($searchTerm, $category);
		}
		
		//calls the insertUser method in userDAL
		function InsertUser($email, $password, $firstName, $lastName, $registrationDate, $birthDate, $townName){
			return $this->userDAL->InsertUserDB($email, $password, $firstName, $lastName, $registrationDate, $birthDate, $townName);	
		}
		
		//calls the update method in userDAL
		function UpdateUser($searchTerm, $column, $value){
			return $this->userDAL->UpdateUserDB($searchTerm, $column, $value);
		}
		
		//calls the delete user method in userDAL
		function DeleteUser($userID){
			return $this->userDAL->DeleteUserDB($userID);
		}
	}
	
?>