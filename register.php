<?php 
require_once("include".DIRECTORY_SEPARATOR."function.php");


$dBase = register::Inst();

if(isset($_POST['submit'])){
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$email    = trim($_POST['email']);
$info	  = trim($_POST['info']);
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
			"require"=>true
			)
		);


	$validation = new validation();
	$passed = $validation->form_validate($fields)->passed();
	if($passed){
		
	$fields = array("username"=>$username, "password"=>$password, "email"=>$email, "info"=>$info);
	$message =  $dBase->insert($fields)->result();

	}else{
		$errors = $validation->formErrors();
		
	}


}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Tej oop Login and Register</title>
	<link rel="stylesheet" href="include/output/style.css" media="all" />
</head>
<body>
<div class="main">
		<header class="header">
			<h1>User Register</h1>
		</header>
		<sidebar class="left-side">
			<h2>Login</h2>
				<ul>
					<li><a href="login.php">Login</a></li>
				</ul>			
		
		</sidebar>

	<section class="content">
			<?php 		 
			if(isset($errors)){
				display_errors($errors);
			} ?>
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
					<td><input type="submit" name="submit" value="Register"></td>
				</tr>
							</form>

			</table>

		</section><!-- /.section -->
		<div class="clearfix"></div>
	<footer class="footer">
		<p>Copyright 2013 Tej N Dahal, All right reserved</p>
	</footer>

	</div><!--/.main -->
</body>
</html>
