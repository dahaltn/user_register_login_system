<?php 
class register extends databaseObject{
	protected $conn;
	protected $result=false;
	protected $count;
	protected $table_name="users"; 
	protected $errors;//store validation errors;


 	//insert user into user field
  public function insert_user($fields){

 	$sql = "INSERT INTO {$this->table_name} (";
	$sql .= implode(", ", array_keys($fields));
	$sql .= ")values(";
	$sql .= ":".implode(", :", array_keys($fields));
	$sql .= ")";
	try{
	$stmp = $this->conn->prepare($sql);
	$stmp->execute($fields);
		if($stmp->rowCount()>0){
			$this->result  = true;
		}
		return $this;
	}catch(PDOException $e){
		$this->errors = $e->getMessage();	
	}
  }
 
	


 public function result(){
 	return $this->result;
 }
}
