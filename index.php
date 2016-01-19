<?php
// User Register and Login system developed by Tej Dahal(dahaltn@gmail.com)

session_start();
require_once("include".DIRECTORY_SEPARATOR."function.php");

$login_a = new Login();
if($login_a->check_login()){ header('Location:welcome.php'); }

if(isset($_POST['register'])){
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	//generate random salt
	$raw_salt = md5(uniqid(rand(),true));
	$salt = substr($raw_salt, 0, 10);
	//hash the password with random salt
	$password = hash('sha256', $password.$salt);

	$email    = trim($_POST['email']);
	$info	  = trim($_POST['info']);
	$info = filter_var($info, FILTER_SANITIZE_STRING);

	//validation setting


	$fields = array(
		"username"=>array(
			"max"=>10,
			"min"=>4,
			"require"=>true,
			"unique"=>true
			),
		"password"=>array(
			"max"=>10,
			"min"=>2,
			"require"=>true
			),
		"email"=>array(
			"require"=>true,
			"preg_match"=>"email",
			"unique"=>true
			),
		"password2"=>array(
			"match"=>"password"
			),

		"info"=>array(
			"require"=>true,
			"preg_match"=>"textarea",

			)
		);

	//validate user 
	$validation = new validation();
	$passed = $validation->form_validate($fields)->passed();

	//if validation pass insert into database
	if($passed){		
	$insert_fields = array(
		"username"=>$username, 
		"password"=>$password,
		"salt"=>$salt, 
		"email"=>$email, 
		"info"=>$info
		);

		$register = new register();
		$reg = $register->insert_user($insert_fields)->result();
		if($reg){
			$reg_msg = "Successfully Register user";
		}	
	}else{
		$errors = $validation->formErrors();
		
	}



}


//check user credentials on login submition
if(isset($_POST['login'])){
	
	$login_user = $login_a->check_users(trim($_POST['loginusername']),trim($_POST['loginpassword']))->login();

	if($login_a->check_login()){
		header('Location:welcome.php');	
	}else{
		$login_msg = " Incorrect username or password";
	}
}


	$fields = array(
		"username"=>array(
			"max"=>10,
			"min"=>4,
			"require"=>true,
			"unique"=>true
			),
		"password"=>array(
			"max"=>10,
			"min"=>2,
			"require"=>true
			)
		);
// max=14|min=3|required=tre|unique
// max=14|min=3|required|unique


// $fld = array();
// foreach ($fields as $key => $value) {
// 	$key
// }

	$fields2 = array(
		'username'=>"max=14|min=3|required=tre|unique",
		'password'=>"max=14|min=3|required|unique"
		);

	$arr  = implode(":", $fields2);

	var_dump($arr);


	// foreach ($fields as $key => $value) {
	// 	$exp = explode("|", $value);
	// 	foreach ($exp as $key => $value) {
			
	// 	}
	// 	$arr[$key] = 

	// }

	// echo "<pre>";
	// print_r($arr);

	// foreach ($arr as $key => $value) {
			
	// }

	// echo "</pre>";

// var_dump($exp);
	// $arr = array();
	// foreach ($fields as $key => $value) {
	// 	$arr[$key]= implode("|", $value);	
	// 	imp
	// 	}

	// echo "<pre>";
	// 	var_dump($arr);
	// echo "</pre>";

	// $rulz = array();
	// foreach ($arr as $rule => $rule_value) {
	// 	$rulez[] = explode("=", $rule_value); 
	// }
	// echo "<pre>";	
	// 	var_dump($rulz);
	// echo "</pre>";	


?>

<?php include('template/header_template.php'); ?>

		<header class="header">
			<h1>User Login/Register</h1>
		</header>
		<sidebar class="left-side">

	<!-- User Login form -->
			<h2>Login</h2>
			<P style="color:red;"><?php if(isset($login_msg)){ echo $login_msg;} ?></P>
			<table>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<tr>
						<td><label for="username">User Name: </label> </td>
						<td>
							<input type="text" name="loginusername" value="" placeholder="please give your username">					
						</td>
					</tr>
					<tr>
						<td><label for="password">Password: </label>  </td>
						<td>
						<input type="password" name="loginpassword" placeholder="please give your Password">
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td><input type="submit" name="login" value="Login"></td>
					</tr>
			</form>
			</table>			
		
		</sidebar>


	<!-- User Register form  -->

	<section class="content">
		<h2>Register</h2>
			<P style="color:green;"> <?php if(isset($reg_msg)){ echo $reg_msg;} ?> </P>
			
			<?php 
				if(isset($errors)){
					display_errors($errors);
				} 

				?>

		<table>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<tr>
					<td><label for="email">Email: </label> :</td>
					<td><input type="text" name="email" value="" placeholder="please give your email"></td>
				</tr>
				<tr>
					<td><label for="username">User Name: </label> </td>
					<td>
					<input type="text" name="username" value="" placeholder="please give your username">
					</td>
				</tr>
				

				<tr>
					<td><label for="password">Password: </label> </td>
					<td>
						<input type="password" name="password" placeholder="please give your Password">
					</td>
				</tr>

				<tr>
					<td><label for="password2">Re Password: </label> </td>
					<td>
						<input type="password" name="password2" placeholder="please retype your Password">
					</td>
				</tr>

					<tr>
					<td><label for="info">Info: </label>  </td>
					<td>
						<textarea name="info" id="info" cols="20" rows="10"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="register" value="Register"></td>
				</tr>
							</form>

			</table>
		</section><!-- /.section -->
		<div class="clearfix"></div>
	<?php include('template/footer_template.php'); ?>

