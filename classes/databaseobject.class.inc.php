<?php
require_once("include".DIRECTORY_SEPARATOR."function.php");

class databaseObject{
	protected $table_name="users";
	protected $conn;


	 function __construct(){
	$this->conn=Connection::conn() ;
	}



	//find user by username to get stored salt value 
	public function find_by_username($username){
		$stmp = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE username=:username");
		$stmp->execute(array(
			'username'=>$username
			));
		if($stmp->rowCount()>0){
			$row =$stmp->fetchAll();
			return array_shift($row);			
		}
		return false;
	}

	//check if user exists in database
	public function check_users($username, $password){
		
		$user_by_username = $this->find_by_username($username);
		if($user_by_username){
			$salt = $user_by_username['salt'];
			$password = hash('sha256', $password.$salt);
		}

			$stmp = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE username=:username AND password=:password ");
			$stmp->execute(array(
				"username" => $username,
				"password" => $password
				));		
				if($stmp->rowCount()>0):
					$row = $stmp->fetchAll();
					$this->found_user_row = array_shift($row);;
				endif;
				return $this;		
		} 


	//find user by id to get login user detail
	public function find_by_id(){
		$stmp = $this->conn->prepare("SELECT * FROM {$this->table_name} WHERE id=:id");
		$stmp->execute(array(
			'id'=>$this->user_session
			));
		if($stmp->rowCount()===1){
			$row =$stmp->fetchAll();
			return array_shift($row);
		}
		return false;
	}

	//Get all registered users
	 public function query(){
	 	try{
	 	$stmp = $this->conn->prepare("SELECT * FROM users"); 
	 	$stmp->execute();
	 	$row = $stmp->fetchAll();
	 	if($stmp->rowCount()>0){
	   		$this->result = $row;
	 	}
	 	return $this;
	 }catch(PDOException $e){
	 		$this->errors = $e->getMessage();	
			
		 }
	 }
	



}


	?>