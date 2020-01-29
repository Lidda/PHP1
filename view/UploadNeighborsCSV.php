<?php
  require_once '../Logic/UserLogic.php';
  $userLogic = new UserLogic();
  session_start();

  if(isset($_POST["submit"])) {
   $fileContents = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
   $fileContents = explode(PHP_EOL, $fileContents);

   $userInfoArrays = [];
   $columnNames = [];

   for($i=0; $i<count($fileContents); $i++){
     if($i == 0){
       $columnNames = str_getcsv($fileContents[$i], ",", '"', "\\"); //get first row to indicate column name
     } else {
       $userInfoArrays[] = str_getcsv($fileContents[$i], ",", '"', "\\"); //get all other information and add to info array
     }
   }

   $data = [];
   foreach ($userInfoArrays as $userInfo){
     $user = [];

     foreach($userInfo as $key => $u){ //columnName key matches up with key of $userInfoArrays
       $columnName = $columnNames[$key];
       $user[$columnName] = $u;
     }

     $data[] = $user; //array with arrays with user info, indexed by key
   }

   //add to DB
   foreach($data as $d){
     $pwd = bin2hex(openssl_random_pseudo_bytes(4)); //random password, user will have to reset it after account is added.
     $today = date('Y-m-d');
     $userAdded = $userLogic->InsertUser($d["email"], md5($pwd), $d["firstName"], $d["lastName"], $today, $d["birthDate"], $d["townName"], "resources/mayorPics/default_mayor.jpg");
   }

   if ($userAdded){
     echo "successfully added to database.";
   } else {
     echo "something went wrong adding do database.";
   }

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
		<li class = "liNav floatright"><a href="AmblinKrop_Project_AdminUsers.php">Admin</a></li>
		<?php
		if(isset($_SESSION['login'])){ 				//dynamically displays either a login or logout button
			echo '<li id = "liNavLogout"><a href="AmblinKrop_Project_Logout.php">Logout</a></li>';
		}else {
			echo '<li id = "liNavLogin"><a href="AmblinKrop_Project_Login.php">Login</a></li>';
		}
		?>
	</ul>

  <div class="tinyFormBox">
    <h2> Upload neighbor CSV file </h2>
      <form action="UploadNeighborsCSV.php" method="post" enctype="multipart/form-data">
        <p>Select file</p>
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv"/>
        <input id = "submitCSV" type="submit" name="submit" />
      </form>
  </div>
</body>
</html>
