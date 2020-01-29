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
<?php include 'Head.php'?>
<body>
		<?php include "NavBar.php" ?>

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
		<a id = "csvLink" class = "floatright" href ="AmblinKrop_Project_NeighborsToCSV.php"><u> EXPORT ALL NEIGHBORS AS CSV FILE </u></a>
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
