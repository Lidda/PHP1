<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();
	
	//checks if all fields are set
	if (isset($_POST["emailField"]) && isset($_POST["passwordField"]) && isset($_POST["passwordFieldRepeat"]) && isset($_POST["firstNameField"])
				&& isset($_POST["lastNameField"]) && isset($_POST["birthDateField"])) {
		$email = $_POST["emailField"];
		$password = $_POST["passwordField"];
		$passwordRepeat = $_POST["passwordFieldRepeat"];
		$firstName = $_POST["firstNameField"];
		$lastName = $_POST["lastNameField"];
		$townName = $_POST["townNameField"];
		$birthDate = $_POST["birthDateField"];
		
		$users = $userLogic->GetUsersInfo($email, 'email');
		
		//checks if everything was entered correctly etc.
		if (strlen($email) > 0 && strlen($password) > 0 && strlen($townName) > 0 && strlen($firstName) > 0 && strlen($lastName) > 0 && strlen($birthDate) > 0){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
				if (strlen($_POST["emailField"]) > 0 && $userLogic->EmailAvailable($email)){
					if (strlen($townName) <= 8) {
						if (strlen($password) >= 8) {
							if($password == $passwordRepeat) {
								$today = date('Y-m-d');
								//creates a new user row in database (with encrypted password) & checks if it was successfull
								$userAdded = $userLogic->InsertUser($email, md5($password), $firstName, $lastName, $today, $birthDate, $townName);
													
								if ($userAdded) {
									/*sends an email with a link to that activation page. The link contains users' email-address.
									The activation code is the md5-encrypted version of their email.*/
									$subject = 'Please activate your E-mail address';
									$msg = 'Please activate your email-address using the following link:'. 
											'http://632005.infhaarlem.nl/PHP_Project/view/AmblinKrop_Project_Activation.php'.'?email='.$email.
											
											'Fill in the following activation code: '.
											md5($email);
									mail($email, $subject, $msg);
									echo 'successfully registered. Please verify your email-address through the link we sent you.';
								} else {
									echo 'could not add user to database due to a connection problem.';
								}
							} else {
								echo 'Password repeated inccorectly.</br>';
							}
						} else {
							echo 'Password too short. Please make a password of 8 characters or more.</br>';				
						}
					} else {
						echo 'Town name can not be longer than 8 characters.</br>';
					}
				} else {
					echo 'There is already an account with this email address.</br>';
				} 
			} else {
				echo 'Invalid email-address. Please re-enter. </br>';
			}
		} else {
			echo 'Please fill in every field.';
		}
	}
	$userLogic->CloseConnection();
?>

<html>
<head>
	<link rel = "stylesheet" type = "text/css" href = "AmblinKrop_Project.css" />
	
</head>
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
	
	<div class = "formBox big">
		<h2> Register account </h2>
		<form action="AmblinKrop_Project_Registration.php" method="post">
			email: <input type="text" name = "emailField" />
			password: <input type="password" name = "passwordField" />
			repeat password: </br><input type="password" name = "passwordFieldRepeat" />
			first name: <input type="text" class = "name" name = "firstNameField" />
			last name: <input type="text" class = "name" name = "lastNameField" />
			Town Name: <input type="text" class = "name" name = "townNameField" />
			date of birth: <input type="date" name = "birthDateField" />		
			<input id = 'submitRegistration' type="submit" />
		</form>
	</div>
	
</body>
</html>