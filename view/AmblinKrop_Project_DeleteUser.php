<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();
	
	//checks if the user is authorised to access the page. If not, it redirects to the loginpage.
	$user = $userLogic->GetUsersInfo($_SESSION['user_id'], 'ID');
	if (! isset( $_SESSION['user_id'])) {
		header("Location: AmblinKrop_Project_Login.php");
		exit();
	}
	
	if (count($user) == 0) {
		header("Location: AmblinKrop_Project_Login.php");
		exit();
	}
	
	if ($user[0]->GetAdminStatus() == 0) {
		header("Location: AmblinKrop_Project_Login.php");
		exit();
	}
		
	//get the userID & email from URL
	$email = $_GET['email'];
	$userID = $_GET['userID'];
		
	if ($userLogic->DeleteUser($userID)){
		header("Location: AmblinKrop_Project_AdminUsers.php");
		echo $email . 'deleted';
	} else {
		echo 'could not connect to database.';
	}
?>

