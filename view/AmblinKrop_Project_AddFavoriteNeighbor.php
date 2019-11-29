<?php
	require_once '../Logic/UserFavoritesLogic.php';
	$favesLogic = new UserFavoritesLogic();
	session_start();
	
	if (isset( $_SESSION['user_id'])) {
		//get the neighborID from URL & the userID from the session
		$neighborID = $_GET['neighborID'];
		$userID = $_SESSION['user_id'];
		if ($favesLogic->FavoriteNeighbor($userID, $neighborID)){
			header("Location: AmblinKrop_Project_MyTown.php");
			exit();
		} else {
			header("Location: AmblinKrop_Project_MyTown.php");
		}		
	} else {
		$_SESSION['page'] = 'Neighbors';
		header("Location: AmblinKrop_Project_Login.php");
	}
?>