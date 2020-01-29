<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();

	$email = $_GET['email'];

	if (isset($_GET["activationCodeField"])){
		$code = $_GET["activationCodeField"];

		if (md5($email) == $code){
			if ($userLogic->UpdateUser($email, "isActive", 1)){
				echo 'sucessfully activated';
			}
		} else {
			echo 'Incorrect activation code';
		}
	}

	$userLogic->CloseConnection();
?>

<html>
<?php include 'Head.php'?>
<body>
	<ul id = "ulNav">
		<li class = "liNav" ><a class="active" href="AmblinKrop_Project_Homepage.php">Home</a></li>
		<li class = "liNav"><a href="AmblinKrop_Project_MyTown.php">My Town</a></li>
		<li class = "liNav"><a href="AmblinKrop_Project_Neighbors.php">Neighbors</a></li>
		<li class = "liNav floatright"><a href="AmblinKrop_Project_Contact.php">Contact</a></li>
		<li class = "liNav floatright"><a href="AmblinKrop_Project_AdminUsers.php">Admin</a></li>
		<?php
		//dynamically displays either a login or logout button
		if(isset($_SESSION['login'])){
			echo '<li id = "liNavLogout"><a href="AmblinKrop_Project_Logout.php">Logout</a></li>';
		}else {
			echo '<li id = "liNavLogin"><a href="AmblinKrop_Project_Login.php">Login</a></li>';
		}
		?>
	</ul>

	<div id = "smallFormBox">
		<h2> Activate account </h2></br>
		<form action="AmblinKrop_Project_Activation.php" method="get">
			Activation code: </br><input type="text" name = "activationCodeField" /><br/>
			<input type="hidden" name="email" value="<?php echo $email; ?>" /><input type="submit" />
		</form>
	</div>

</body>
</html>
