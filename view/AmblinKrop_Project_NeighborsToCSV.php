<?php
  require_once '../Logic/NeighborLogic.php';
  $neighborLogic = new NeighborLogic();

  $neighbors = $neighborLogic->GetAllNeighbors();

  $data = "ID,Name,Personality,Animal,Birthday,Coffee Preference\n";

  foreach($neighbors as $n){
    $data .=
    $n->GetNeighborID() .",".
    $n->GetName() .",".
    $n->GetPersonality() .",".
    $n->GetAnimal() .",".
    $n->GetBirthday().",\"".
    $n->GetCoffee() ."\"\n"
    ;
  }

  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=\"my-data.csv\"");
  echo $data;
?>
