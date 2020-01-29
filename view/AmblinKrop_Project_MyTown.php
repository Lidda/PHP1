<?php
	require_once '../Logic/NeighborLogic.php';
	require_once '../Logic/UserFavoritesLogic.php';
	require_once '../Logic/UserLogic.php';
	$neighborLogic = new NeighborLogic();
	$favesLogic = new UserFavoritesLogic();
	$userLogic = new UserLogic();

	$neighbors = [];
	$users = [];

	session_start();

	//checks if the user is authorised to access the page. If not, it redirects to the loginpage.
	if (! isset( $_SESSION['user_id'])) {
		header("Location: AmblinKrop_Project_Login.php");
		exit();
	}

	//gets the town name
	$user = $userLogic->GetUsersInfo($_SESSION['user_id'], 'ID');

	if (count($user) > 0) {
		$townName =  $user[0]->GetTownName();
		$mayorPic = $user[0]->GetMayorPic();
	} else {
		echo "Database connection problem";
	}

	$userID = $_SESSION['user_id'];
	$neighbors = (array)$favesLogic->GetFavoriteNeighbors($userID);
?>

<html>
<?php include 'Head.php'?>
<body>
	<ul id = "ulNav">
		<li class = "liNav" ><a class="active" href="AmblinKrop_Project_Homepage.php">Home</a></li>
		<li class = "liNav selected"><a href="AmblinKrop_Project_MyTown.php">My Town</a></li>
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


	<?php echo "<h2 id='townName'>$townName Neighbors</h2>
				 <a href = AmblinKrop_Project_UploadMayorPic.php> <img id = 'mayorPic' src = $mayorPic></img> </a>" ?>
	<div class = "neighborsTable neighborsTableFav">

        <table>
            <tr>
				<th></th>
				<th>name</th>
                <th>personality</th>
                <th>animal</th>
				<th>birthday</th>
				<th>coffee preference</th>
                <th></th>
            </tr>

			<?php
				//loops through database and displays neighbors in corresponding rows
				foreach($neighbors as $n){
					$imgURL = $n->GetImageURL();
					$neighborID = $n->GetNeighborID();

					echo '<tr><td>' . '<img src= "' . $imgURL . '" alt="img" height="100" width="100">'
					. '</td><td>' . $n->GetName()
					. '</td><td>' . $n->GetPersonality()
					. '</td><td>' . $n->GetAnimal()
					. '</td><td>' . $n->GetBirthday()
					. '</td><td>' . $n->GetCoffee()
					. '</td><td><a href="AmblinKrop_Project_DeleteFavoriteNeighbor.php?neighborID='. $neighborID . '">
									<img id = "favicon" src="resources\binIcon.png" width="35">
								</a>'
					. '</td></tr>';
				}
			?>
		</table>
		<a id = 'addNeighborsButton' href="AmblinKrop_Project_Neighbors.php">add neighbors</a>
	</div>


</body>
</html>
