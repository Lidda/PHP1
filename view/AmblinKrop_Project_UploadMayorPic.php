<?php
	require_once '../Logic/UserLogic.php';
	$userLogic = new UserLogic();
	session_start();

  $userID = $_SESSION["user_id"];

  $target_file = "resources/mayorPics/mayor".$userID.".png"; //sets file name
  $uploadOk = true;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { //puts file in actual directory

          $im = imagecreatefrompng($target_file);

          if ($im) {
            imagesavealpha($im, true);
            imagefilter($im, IMG_FILTER_BRIGHTNESS, 30); // Processes image to increase brightness
            imagepng($im, $target_file);
            imagedestroy($im);
          }

          $userLogic->UpdateUser($userID, "mayorPic", "resources/mayorPics/mayor".$userID.".png"); //changes imageURL in DB
          echo "The image has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      } else {
        echo "File is not an image.";
        $uploadOk = false;
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

	<div class = "tinyFormBox">
		<h2> Upload mayor pic </h2>
    <form id="selectImgTag" action="AmblinKrop_Project_UploadMayorPic.php" method="post" enctype="multipart/form-data">
        <p >Select image to upload: </br></p>
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".png"></br>
        <input id="submitImg" type="submit" value="Upload Image" name="submit" >
    </form>
	</div>
</body>
</html>
