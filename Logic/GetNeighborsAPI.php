<?php
  require_once '../DAL/NeighborDAL.php';
  $neighborDAL = new NeighborDAL();

  $neighbors = $neighborDAL->GetAllNeighborsDB();
  $arrayOfNeighbors  = [];

  foreach ($neighbors as $n){ //turn neighbor objects into neighbor arrays
    $neighborArray["ID"] = $n->GetNeighborID();
    $neighborArray["name"] = $n->GetName();
    $neighborArray["imageURL"] = $n->GetImageURL();
    $neighborArray["animal"] = $n->GetAnimal();
    $neighborArray["birthday"] = $n->GetBirthday();
    $neighborArray["coffee"] = $n->GetCoffee();
    $neighborArray["personality"] = $n->GetPersonality();

    $arrayOfNeighbors[] = $neighborArray; //add neighbor array (previously an object) to array of neighbors.
  }

  $neighborsJSON = json_encode($arrayOfNeighbors);
  echo $neighborsJSON; //put JSON string on webiste for external access
?>
