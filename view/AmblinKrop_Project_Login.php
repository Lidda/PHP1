<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();

	//checks email&password combination. if correct: give the session the user ID and redirect.
	if (isset($_POST["emailField"]) && isset($_POST["passwordField"])) {
		$email = $_POST["emailField"];
		$password = $_POST["passwordField"];

		$users = $userLogic->GetUsersInfo($email, 'email');
		if (count($users) > 0) {
			if ($users[0]->GetPassword() == md5($password)) {
				$_SESSION['user_id'] = ($users[0]->GetUserID());
				$_SESSION['user_admin'] = ($users[0]->GetAdminStatus());
				$_SESSION['login'] = true;

				if(isset($_POST['rememberMeCheckbox'])){ //checks if the 'remember me' checkbox has been checked and sets a cookie
					setcookie('user_email', $email, time() + (86400 * 30), "/");
				}

				//checks from what page the user came and if they are authorized to access the page (as admin)
				if($_SESSION['user_admin']  == 1 && $_SESSION['page'] == 'AdminUsers'){
					header("Location:AmblinKrop_Project_AdminUsers.php");
				} else {
					header("Location:AmblinKrop_Project_Homepage.php");
				}
				exit();
			} else {
				echo 'wrong email or password, please try again.';
			}
		} else {
			echo 'wrong email or password, please try again.';
		}
	}

	$emailCookie = "";
	$checked = "";
	if(isset($_COOKIE['user_email'])){ //if the cookie is there it saves it to a variable which can be used in the HTML code
		$emailCookie = $_COOKIE['user_email'];
		$checked = 'checked=checked'; //html for checking the checkbox
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
		if(isset($_SESSION['login'])){ 				//dynamically displays either a login or logout button
			echo '<li id = "liNavLogout"><a href="AmblinKrop_Project_Logout.php">Logout</a></li>';
		}else {
			echo '<li id = "liNavLogin"><a href="AmblinKrop_Project_Login.php">Login</a></li>';
		}
		?>
	</ul>

	<div id = "smallFormBox">
		<h2> Login </h2>
		<form action="AmblinKrop_Project_Login.php" method="post">
			email: </br><input type="text" name = "emailField" value = <?php echo $emailCookie;?>></br>
			password: </br><input type="password" name = "passwordField" /><br/>
			<div id = 'rememberMe'> <input type = "checkbox" name="rememberMeCheckbox" <?php echo $checked;?>> <i>remember me</i></br></div>
			<a class = 'floatright' href="AmblinKrop_Project_PasswordReset.php">Forgot password</a></br>
			<input id = "loginSubmit" type="submit" value = "log in" />
			<div id = 'registerlink'> No account? <a href="AmblinKrop_Project_Registration.php"> <strong>register</strong> </a> </div>
		</form>
	</div>
</body>
</html>
