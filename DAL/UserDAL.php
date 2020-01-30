<?php
	require_once dirname(__FILE__).'/../Model/User.php';
	require_once dirname(__FILE__).'/ConnectionDAL.php';

	class UserDAL {
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

		// gets all user info from database and returns a filled array
		function GetAllUsersDB(){
			$sql = "SELECT users.userID as id, users.emailAddress as email, users.password as password, users.firstName as firstName,
				users.lastName as lastName, users.registrationDate as registrationDate, users.birthDate as birthDate,
				users.townName as townName, users.isActive as isActive, users.isAdmin as isAdmin, users.mayorPic as mayorPic
				FROM users;";

			$users = [];
			$result = mysqli_query($this->connection, $sql);
			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)) {
					$id = $row["id"];
					$email =  $row["email"];
					$password = $row['password'];
					$firstName = $row['firstName'];
					$lastName = $row['lastName'];
					$registrationDate = $row['registrationDate'];
					$birthDate = $row['birthDate'];
					$townName = $row['townName'];
					$isActive = $row['isActive'];
					$isAdmin = $row['isAdmin'];
					$mayorPic = $row['mayorPic'];

					$user = new User($id, $email, $password, $firstName, $lastName, $registrationDate,
								$townName, $birthDate, $isActive, $isAdmin, $mayorPic);
					$users[] = $user;
				}
				return $users;
			} else {
				echo 'no results found';
			}
		}

		// get users from the database based on a searchterm and category (id, name, email or registrationDate)
		function GetUsersInfoDB($searchTerm, $category){
			//cleans up users input and makes it lowercase (for the switch)
			$searchTerm = strtolower(mysqli_real_escape_string($this->connection, $searchTerm));
			$category = strtolower(mysqli_real_escape_string($this->connection, $category));

			$sql;
			$baseQuery = "SELECT users.userID as id, users.emailAddress as email, users.password as password, users.firstName as firstName,
				users.lastName as lastName, users.registrationDate as registrationDate, users.birthDate as birthDate,
				users.townName as townName, users.isActive as isActive, users.isAdmin as isAdmin, users.mayorPic as mayorPic
				FROM users ";


			switch ($category) {
			case "id":
				$sql = $baseQuery."WHERE users.userID LIKE '$searchTerm'";
				break;
			case "name":
				$sql = $baseQuery."WHERE users.firstName LIKE '$searchTerm' OR users.lastName LIKE '$searchTerm'";
				break;
			case "email":
				$sql =  $baseQuery."WHERE users.emailAddress LIKE '$searchTerm'";
				break;
			case "registrationdate":
				$sql = $baseQuery."WHERE users.registrationDate = '$searchTerm'";
				break;
			case "registeredbefore": //finds all users registered before entered date
				$sql = $baseQuery."WHERE users.registrationDate < '$searchTerm'";
				break;
			case "registeredafter": //finds all users registered after entered date
				$sql = $baseQuery."WHERE users.registrationDate > '$searchTerm'";
				break;
			case "isactive": //finds all users registered after entered date
				$sql = $baseQuery."WHERE users.isActive = '$searchTerm'";
				break;
			}

			//creates & returns array filled with User objects (from database)
			$users = [];
			$result = mysqli_query($this->connection, $sql);

			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)) {
					$id = $row["id"];
					$email =  $row["email"];
					$password = $row['password'];
					$firstName = $row['firstName'];
					$lastName = $row['lastName'];
					$registrationDate = $row['registrationDate'];
					$townName = $row['townName'];
					$birthDate = $row['birthDate'];
					$isActive = $row['isActive'];
					$isAdmin = $row['isAdmin'];
					$mayorPic = $row['mayorPic'];
					$user = new User($id, $email, $password, $firstName, $lastName, $registrationDate, $townName,
								$birthDate, $isActive, $isAdmin, $mayorPic);
					$users[] = $user;
				}
			}

			return $users;
		}

		//Adds a new user to the database
		function InsertUserDB($email, $password, $firstName, $lastName, $registrationDate, $birthDate, $townName, $mayorPic){
			$email = mysqli_real_escape_string($this->connection, $email);
			$password = mysqli_real_escape_string($this->connection, $password);
			$firstName = mysqli_real_escape_string($this->connection, $firstName);
			$lastName = mysqli_real_escape_string($this->connection, $lastName);
			$birthDate = mysqli_real_escape_string($this->connection, $birthDate);
			$townName = mysqli_real_escape_string($this->connection, $townName);

			$sql = "INSERT INTO users (emailAddress, password, firstName, lastName, registrationDate, birthDate, townName, mayorPic)
					VALUES ('$email', '$password', '$firstName', '$lastName', '$registrationDate', '$birthDate', '$townName', '$mayorPic');";
			$success = mysqli_query($this->connection, $sql);
			return $success; //returns true if query was executed
		}

		//allows you to update a column value of a user (by ID or Email)
		function UpdateUserDB($userInfo, $column, $value){
			$userInfo = mysqli_real_escape_string($this->connection, $userInfo);
			$column = mysqli_real_escape_string($this->connection, $column);
			$value = mysqli_real_escape_string($this->connection, $value);

			$sql = "UPDATE users SET $column = '$value' WHERE userID = '$userInfo' OR emailAddress LIKE '$userInfo';";
			$success = mysqli_query($this->connection, $sql);
			return $success; //returns true if query was executed
		}

		//Deletes a user by ID
		function DeleteUserDB($userID){
			$sql = "DELETE FROM users WHERE userID = '$userID'";

			$success = mysqli_query($this->connection, $sql);
			return $success; //returns true if query was executed
		}
	}
?>
