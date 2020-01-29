<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();

	if (isset($_POST["emailField"])){
		//creates random string of 8 characters
		$pwd = bin2hex(openssl_random_pseudo_bytes(4));
		$email = $_POST["emailField"];
		$users = $userLogic->GetUsersInfo($email, 'email');

		if (count($users) > 0){
			$msg = 'Your password has been reset. Please log in using your new password: '.$pwd;

			mail($email, 'Password Reset', $msg);
			$userLogic->UpdateUser($email, 'password', md5($pwd));

			echo 'Password has been reset and has been sent to the entered e-mail address.';
		} else {
			echo "Could not reset this users' password. Please contact us using the contact form.";
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
		<h2> Reset password </h2></br>
		<form action="AmblinKrop_Project_PasswordReset.php" method="post">
			Email </br><input type="text" name = "emailField" /><br/>
			<i>*your new password will be sent to the entered email</i>
			<input type="submit" />
		</form>
	</div>

</body>
</html>
