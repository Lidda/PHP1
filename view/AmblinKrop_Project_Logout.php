<?php
	session_start();
	$_SESSION = array();
    session_destroy();
	
	header("Location:AmblinKrop_Project_Homepage.php");
	exit();
?>