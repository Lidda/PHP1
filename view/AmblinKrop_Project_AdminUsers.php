<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	$users = [];

	session_start();

	//checks if the user is authorised to access the page. If not, it redirects to the loginpage.
	$user = $userLogic->GetUsersInfo($_SESSION['user_id'], 'ID');
	if (! isset( $_SESSION['user_id']) || $user[0]->GetAdminStatus() == 0) {
		header("Location: AmblinKrop_Project_Login.php");
		$_SESSION['page'] = 'AdminUsers';
	}

	//finds all users related to searchterm
	if(isset($_GET['searchTerm'])){
		$searchTerm = $_GET['searchTerm'];
		$searchCategory = $_GET['searchCategory']; //= selected category
		$users = $userLogic->GetUsersInfo($searchTerm, $searchCategory);
	} else {
		$users = (array)$userLogic->GetAllUsers(); //if no search term is set -> get all users
	}
?>

<html>
<?php include 'Head.php'?>
<body>
	<ul id = "ulNav">
		<li class = "liNav" ><a class="active" href="AmblinKrop_Project_Homepage.php">Home</a></li>
		<li class = "liNav"><a href="AmblinKrop_Project_MyTown.php">My Town</a></li>
		<li class = "liNav"><a href="AmblinKrop_Project_Neighbors.php">Neighbors</a></li>
		<li class = "liNav floatright"><a href="AmblinKrop_Project_Contact.php">Contact</a></li>
		<li class = "liNav floatright selected"><a href="AmblinKrop_Project_AdminUsers.php">Admin</a></li>
		<?php
		//dynamically displays either a login or logout button
		if(isset($_SESSION['login'])){
			echo '<li id = "liNavLogout"><a href="AmblinKrop_Project_Logout.php">Logout</a></li>';
		}else {
			echo '<li id = "liNavLogin"><a href="AmblinKrop_Project_Login.php">Login</a></li>';
		}
		?>
	</ul>

    <form class = 'searchForm' action="AmblinKrop_Project_AdminUsers.php" method="get">
		<h2> Manage Users </h2>

		<div id = "search">
			<select name = "searchCategory">
			  <option value="name">name</option>
			  <option value="email">email</option>
			  <option value="registrationdate">registration date (yyyy-mm-dd)</option>
			  <option value="registeredbefore">registered before (yyyy-mm-dd)</option>
			  <option value="registeredafter">registered after (yyyy-mm-dd)</option>
			</select>

			<input type="text" name="searchTerm" placeholder="search.."> </input>
			<input type="submit" name="search" value="Search users"><br><br></input>
		</div>

        <table>
            <tr>
                <th>ID</th>
				<th>email</th>
                <th>First name</th>
                <th>Last name</th>
				<th>Regstration date</th>
				<th>Birth date</th>
				<th>Active</th>
				<th>Admin</th>
                <th></th>
            </tr>

			<?php
				foreach($users as $u){
					echo '<tr><td>' . $u->GetUserID()
					. '</td><td>' . $u->GetEmailAddress()
					. '</td><td>' . $u->GetFirstName()
					. '</td><td>' . $u->GetLastName()
					. '</td><td>' . $u->GetRegistrationDate()
					. '</td><td>' . $u->GetBirthDate()
					. '</td><td>' . $u->GetActivity()
					. '</td><td>' . $u->GetAdminStatus()
					. '</td><td><label id ="removetxt"><b>REMOVE:</b></label> <a href="AmblinKrop_Project_DeleteUser.php?userID='. $u->GetUserID() .'&email='. $u->GetEmailAddress() .'">
									<img id = "favicon" src="resources\binIcon.png" width="20">
								</a>'
					. '</td></tr>';
				}
			?>
		</table>
		<a id ="csvLink" href="UploadNeighborsCSV.php">Add users through CSV file</a>
		<a id = 'reloadButton' href="AmblinKrop_Project_AdminUsers.php">reload</a>
	</form>

</body>
</html>
