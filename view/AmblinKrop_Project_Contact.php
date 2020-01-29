<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();

	if (isset($_POST["emailField"]) && isset($_POST["messageBox"])) {
		$email = $_POST["emailField"];
		$subject = $_POST["subjectField"];
		$msg = $_POST["messageBox"];
		$msg = $msg . " //sender: " . $email;

		mail("632005@student.inholland.nl", $subject, $msg);
		echo "Email sent.";
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
		<li class = "liNav selected floatright"><a href="AmblinKrop_Project_Contact.php">Contact</a></li>
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

	<div class = "formBox">
		<h2> Contact me </h2>
		<form action="AmblinKrop_Project_Contact.php" method="post">
			your email: <input type="text" name = "emailField" />
			subject: <input type="text" name = "subjectField" />
			message: <textarea id = "messageBoxContact" name="messageBox" cols="40" rows="5"></textarea>
		<input id = "submitContact" type="submit" />
		</form>
	</div>

</body>
</html>
