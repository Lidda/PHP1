<?php
	require_once '../Model/User.php';
	require_once '../Logic/TwitterAPI.php';
	$twitterAPI = new TwitterAPI();
	/*spl_autoload_register_(function ($class_name){
		include $class_name . '.php';
	} */
  $tweets = $twitterAPI->GetTweets();
	session_start();

?>


<html>
 <?php include 'Head.php'?>
<body>
	<ul id = "ulNav">
		<li class = "liNav selected"><a class="active" href="AmblinKrop_Project_Homepage.php">Home</a></li>
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

	<div id = "homeBox">
		Welcome to my website. </br>
		Here you can find all the neighbor info from <i>Animal Crossing - New Leaf</i>
	</div>

	<div id = "twitterFeedBox">
		Tweets on ACNL
		<?php
		foreach($tweets as $tweet){
			echo
			'<div id ="tweetBox">
				<p>Created at: '.$tweet["created_at"].' </p>
				<p>Username: '.$tweet["user"]["screen_name"].'</p>
				<p>Tweet: '.$tweet["text"].'</p>
				<p> </p></br>
			</div>';
		}
		?>
	</div>

</body>
</html>
