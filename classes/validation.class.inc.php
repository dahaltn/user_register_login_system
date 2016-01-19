<?php
require_once("include".DIRECTORY_SEPARATOR."function.php");
class Validation{
	private $conn = null; // store db connection
	private $table_name = "users"; 
	private $errors = array();// to store form validation errors 
	private $passed = false; //if empty errors passed = true

	//connect to database upon object creation
	public function __construct(){
		$this->conn =Connection::conn();
	}

	//validate fields
	function form_validate($fields){
		foreach ($fields as $field_name=>$field_rules) {

			//Iterate  the rule value for validation 
			foreach ($field_rules as $rule => $rule_value) {

				//check the require fields are empty or not, if empty no need to go for further validation
				if($rule==="require" && $rule_value===TRUE && $_POST[$field_name]===''){
					$this->errors[$field_name]=ucfirst($field_name). " can't be empty<br />";

				//if not empty go for further validation
				}elseif(!empty($_POST[$field_name])){
					// Email validation 
					//before @ sign, it could contain a to z underscore  dot and 1 to 9 character which could repeat min 2 to 20 times 
					//@ sign required 
					//after @ sign, a to z and 1 to 9 it could repeat 3 to 30 times
					//dot is required after that a to z min 2 to 4 times repetation 
				  if($rule==="preg_match" && $rule_value=== "email" && !preg_match('/^[_\.a-z1-9]{2,20}@[-a-z1-9]{3,30}\.[a-z]{2,4}$/', $_POST[$field_name])){ 
				 	$this->errors[$field_name]=ucfirst($field_name). " address is invalid<br />";
				 }
				 //if rule is preg_match and value = username validate here 
				 //	a to z and A to Z, 1 to 9 could repeat min 3 to max 8 times
				 // "^" sign mean begning of the string if it is inside [] it mean "not"    
				 if($rule==="preg_match" && $rule_value=== "username" && !preg_match('/^[a-zA-Z1-9]{3,8}$/', $_POST[$field_name])){ 
				 	$this->errors[$field_name]=ucfirst($field_name). " field need to be min 3 and max 8<br />";
				 }
				 //Textarea validation
				 //allowed character a to z, A to Z, 1 to 9 line break, space, coma, dot,  question mark these could repeat 1 to 1000 times  
				  if($rule==="preg_match" && $rule_value=== "textarea" && !preg_match('/^[a-zA-Z1-9\r?\n? ? ,?.? \?]{1,1000}$/', $_POST[$field_name])){ 
				 	$this->errors[$field_name]="Illegal text in {$field_name} field<br />";
				 }
				 
				 //if rule is min and field value is great than min store errors
				  if($rule==="min" && strlen($_POST[$field_name])<=$rule_value){ 
				 	$this->errors[$field_name]=ucfirst($field_name). " field need to be min 3 <br />";
				 }
			
				 //check max rule 
				 if($rule==="max" && strlen($_POST[$field_name])>$rule_value){ 
				 	$this->errors[$field_name]=ucfirst($field_name). " field need to be max 8<br />";
				 }
				 //check if rule is match with rule match field
				 if($rule==="match" && $_POST[$field_name]!==$_POST[$rule_value]){ 
				 	$this->errors[$field_name]="password didnt matched with<br />";
				 }
				 //check field value is unique or not from database calling check_unique method by passing unique field name and value
				  if($rule==="unique" && $rule_value===true){
					  	if($this->check_unique($field_name, $_POST[$field_name])){
				 			$this->errors[$field_name]=ucfirst($field_name)." is not unique <br />";
						}
				 

				}

			}
			}
		}
		//return object so that we can chain other method after this
		return $this;
	}

	//check unique field using check_unique method, go to database find the unique column and return true or false. 
	 protected function check_unique($column_name, $column_value){

		$sql = "SELECT * FROM {$this->table_name} WHERE {$column_name}=:{$column_name}";
		$stmp = $this->conn->prepare($sql);
		$stmp->execute(array(
			$column_name=>$column_value
			));
		return $stmp->rowCount()>0;

	}

	//return errors array using getter method
	public function formErrors(){
		return $this->errors;
	}

	//if no errors set the passed property as true and return passed property
	public function passed(){
	if(empty($this->errors)):
		$this->passed = true;
	endif;
		return $this->passed;

	} 


}

?>