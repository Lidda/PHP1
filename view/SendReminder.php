<?php
  /* conceptual code for assessment ;)
    Sends an email with users info every month with cron job (through directAdmin)
    Cronjob has an environmental variable IS_CRON to prevent user from running it manually.  */

  if (getenv("IS_CRON") != 1) {//prevents users from running script manually
    die("Access denied.");
  }

  session_start();
  require_once dirname(__FILE__).'/../Logic/UserLogic.php';
  require_once dirname(__FILE__).'/../Logic/UserFavoritesLogic.php';
	$userLogic = new UserLogic();
  $favesLogic = new UserFavoritesLogic();

  $users = (array)$userLogic->GetUsersInfo("1", "isActive"); //get all active users

  foreach($users as $u){
    $email = $u->GetEmailAddress();
    $neighbors = (array)$favesLogic->GetFavoriteNeighbors($u->GetUserID());

    if (Count($neighbors) > 0){ //check if user has neighbors added to their favourites
      $neighborNames = "";
      foreach($neighbors as $n){ //get all neighbor names and add to string
        $neighborNames .= $n->GetName() . " ,";
      }

      $msg =
      'Your current neighbors are:
      \n'.$neighborNames.'
      Keep your town updated!
      ';
    } else {
      $msg =
      'Your town has no added neighbors!
      \nKeep your town updated!
      ';
    }

    mail($email, 'Password Reset', $msg); //send email with current neighbors
  }


?>
