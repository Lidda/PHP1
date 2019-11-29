<?php
	class Neighbor{
		private $neighborID;
		private $name;
		private $imageURL;
		private $animal;
		private $birthday;
		private $coffee;
		private $personality;
					
		function __construct($id, $name, $image, $animal, $birthday, $coffee, $personality){
			$this->neighborID = $id;
			$this->name = $name;
			$this->imageURL = $image;
			$this->animal = $animal;
			$this->birthday = $birthday;
			$this->coffee = $coffee;
			$this->personality = $personality;
		}
		
		public function GetNeighborID(){
			return $this->neighborID;
		}
		
		public function GetName(){
			return $this->name;
		}
		public function SetName($name){
			$this->name = $name;
		}
			
		public function GetImageURL(){
			return $this->imageURL;
		}
		public function SetImageURL($imageURL){
			$this->imageURL = $imageURL;
		}
			
		public function GetAnimal(){
			return $this->animal;
		}
		public function SetAnimal($animal){
			$this->$animal = $animal;
		}
			
		public function GetBirthday(){
			return $this->birthday;
		}
		public function SetBirthday($birthday){
			$this->$birthday = $birthday;
		}
		
		public function GetCoffee(){
			return $this->coffee;
		}
		public function SetCoffee($coffee){
			$this->$coffee = $coffee;
		}
			
		public function GetPersonality(){
			return $this->personality;
		}
		public function SetPersonality($personality){
			$this->personality = $personality;
		}
	}
?>