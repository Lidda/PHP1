<?php
  session_start();

  //checks if the user is authorised to access the page. If not, it redirects to the loginpage.
	if (! isset( $_SESSION['user_id'])) {
		header("Location: AmblinKrop_Project_Login.php");
		exit();
	}

  require_once 'PDF/fpdf.php';
  require_once 'PDF/ean13.php';
  require_once '../Logic/NeighborLogic.php';
	require_once '../Logic/UserFavoritesLogic.php';
	require_once '../Logic/UserLogic.php';
	$neighborLogic = new NeighborLogic();
	$favesLogic = new UserFavoritesLogic();
	$userLogic = new UserLogic();

  $userID = $_SESSION['user_id'];
  $neighbors = (array)$favesLogic->GetFavoriteNeighbors($userID);

	$user = $userLogic->GetUsersInfo($_SESSION['user_id'], 'ID');
  $townName = $user[0]->GetTownName();
  $mayorPic = $user[0]->GetMayorPic();

  //actual PDF generation
  $pdf = new PDF_EAN13();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);

  //contents
  $pdf->EAN13(80,90, $_SESSION['user_id']); //generate and display barcode that corresponds with currently logged in user ID.
  $pdf->Image($mayorPic,15,20,20);
  $pdf->Cell(40,10, $townName);

  //loops through users' favourite neighbors and displays their pictures in corresponding rows
  for($i = 0; $i < count($neighbors); $i++){
    $imgURL = $neighbors[$i]->GetImageURL();

    $imgPosition = 45 + ($i*25); //places it on PDF with increments of 25
    $pdf->Image($imgURL,15,$imgPosition,20);
  }
  $pdf->Output();

?>
