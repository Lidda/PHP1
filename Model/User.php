<?php
	class User{
		public $userID;
		private $emailAddress; 
		private $password;
		private $firstName = 'user';
		private $lastName = 'user';
		private $registrationDate;
		private $birthDate;
		private $townName;
		private $isActive;
		private $isAdmin;
				
		function __construct($id, $email, $password, $firstName, $lastName, $registrationDate, $townName,
								$birthDate, $isActive, $isAdmin){
			$this->userID = $id;
			$this->emailAddress = $email; 
			$this->password = $password;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->registrationDate = $registrationDate;
			$this->birthDate = $birthDate;
			$this->townName = $townName;
			$this->isActive = $isActive;
			$this->isAdmin = $isAdmin;
		}
		
		public function GetUserID(){
			return $this->userID;
		}
		public function SetUserID($ID){
			$this->userID = $ID;
		}
		
		public function GetEmailAddress(){
			return $this->emailAddress;
		}
		public function SetEmailAddress($emailAddress){
			$this->emailAddress = $emailAddress;
		}
		
		public function GetPassword(){
			return $this->password;
		}
		public function SetPassword($name){
			$this->password = $name;
		}
		
		public function GetFirstName(){
			return $this->firstName;
		}
		public function SetFirstName($name){
			$this->firstName = $name;
		}
		
		public function GetLastName(){
			return $this->lastName;
		}
		public function SetLastName($name){
			$this->lastName = $name;
		}
				
		public function GetRegistrationDate(){
			return $this->registrationDate;
		}
		public function SetRegistrationDate($registrationDate){
			$this->registrationDate = $registrationDate;
		}
		
		public function GetBirthDate(){
			return $this->birthDate;
		}
		public function SetBirthDate($birthDate){
			$this->birthDate = $birthDate;
		}
		
		public function GetTownName(){
			return $this->townName;
		}
		public function SetTownName($townName){
			$this->townName = $townName;
		}
		
		public function GetActivity(){
			return $this->isActive;
		}
		public function SetActivity($isActive){
			$this->isActive = $isActive;
		}
		
		public function GetAdminStatus(){
			return $this->isAdmin;
		}
		public function SetAdminStatus($isAdmin){
			$this->isAdmin = $isAdmin;
		}
	}
		
?>