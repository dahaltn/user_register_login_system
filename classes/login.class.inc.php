<?php
class Login extends databaseObject{
	public $found_user_row=null;
	private $logged_in =false;
	private $login_user_id=null;
	protected $user_session;

	//get parent constructor and call is_login() method upon object creation 
	function __construct(){
		parent::__construct();
		$this->is_login();
	}


	//check if user found and set the user session
	public function login(){
		if($this->found_user_row){
			$this->user_session = $_SESSION['user'] = $this->found_user_row['id'];
			$this->logged_in = true;
		}
		return $this;
	}

	//check if user session isset and validate user
	public function is_login(){
		if(isset($_SESSION['user'])){
			$this->user_session = $_SESSION['user'];
			$this->logged_in = true;
		}else{
			unset($this->user_session);
			$this->logged_in = false;
		}
		return $this;		
	}

	//logout method
	public function logout(){
		unset($this->user_session);
		unset($_SESSION['user']);
		$_SESSION['user']=null;
		$this->logged_in = false;
		return $this;
	}

	//return the logged_in property 
	public function check_login(){
		return $this->logged_in;
	}
	



}


?>