<?php 
class editUser extends databaseObject{
	// protected $conn;
	protected $result;
	protected $count;
	protected $table_name="users"; 
	protected $errors;//store validation errors;

	

	private function extract_field_array($fields){
		$arr_fields = array();
		foreach($fields as $field=>$field_val){
			
			$arr_fields[] = $field."=:".$field;
		}
		return $arr_fields;
	}

	public function edit_user($fields){
		$sql = "UPDATE {$this->table_name} SET "; 
		$sql .= implode(", ", $this->extract_field_array($fields));	
		$sql .= " WHERE id=:id";
		$stmp = $this->conn->prepare($sql);
		$stmp->execute($fields);
		if($stmp->rowCount()>0){
			return true;
		}else{
			return false;
		}
	}



}
