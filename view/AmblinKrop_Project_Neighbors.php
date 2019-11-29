<?php
	require_once '../Logic/NeighborLogic.php';
	require_once '../Logic/UserFavoritesLogic.php';
	$neighborLogic = new NeighborLogic();
	$userFavoritesLogic = new UserFavoritesLogic();
	$neighbors = [];
	
	session_start();
	
	//finds all neighbors related to searchterm
	if(isset($_GET['searchTerm'])){
		$searchTerm = $_GET['searchTerm'];
		$searchCategory = $_GET['searchCategory']; //= selected category
		$neighbors = $neighborLogic->GetNeighborInfo($searchTerm, $searchCategory);
	} else {
		$neighbors = (array)$neighborLogic->GetAllNeighbors(); //if no search term is set -> get all neighbors
	}
?>

<html>
<head>
	<link rel = "stylesheet" type = "text/css" href = "AmblinKrop_Project.css" />
	
</head>
<body>
	<ul id = "ulNav">
		<li class = "liNav" ><a class="active" href="AmblinKrop_Project_Homepage.php">Home</a></li>
		<li class = "liNav"><a href="AmblinKrop_Project_MyTown.php">My Town</a></li>
		<li class = "liNav selected"><a href="AmblinKrop_Project_Neighbors.php">Neighbors</a></li>
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
       
    <form id = 'neighborSearchForm' action="AmblinKrop_Project_Neighbors.php" method="get">
		<h2> Search Neighbors </h2>
        
		<div id = "search">
			<select name = "searchCategory">
				<option value="name">name</option>
				<option value="personality">personality</option>
				<option value="animal">animal</option>
			</select>
			<input type="text" name="searchTerm" placeholder="search.."> </input>
			<input type="submit" name="search" value="Search neighbors"><br><br></input>
		<a id = 'reloadButton' href="AmblinKrop_Project_Neighbors.php">reload</a>
		</div>		
	</form>
	
	<div class = "neighborsTable">
        <table>
            <tr>
				<th></th>
				<th>name</th>
                <th>personality</th>
                <th>animal</th>
				<th>birthday</th>
				<th>coffee preference</th>
                <th>add to faves</th>
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
					. '</td><td><a href="AmblinKrop_Project_AddFavoriteNeighbor.php?neighborID='. $neighborID . '"> 
									<img id = "favicon" src="resources\favoriteIcon.png" width="25"> <label>< add me!</label>
								</a>'
					. '</td></tr>';	
				}			
			?>
		</table>
	</div>

</body>
</html>