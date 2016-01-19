<?php session_start(); 
	require_once("include".DIRECTORY_SEPARATOR."function.php");
	
	$login_a = new Login();
	if(!$login_a->is_login()->check_login()){ header('Location:index.php'); } 
		if(isset($_GET['logout'])&& $_GET['logout']==1){
			$login_a->logout();
			header('Location:index.php');
		}

		if(isset($_POST['edit'])){

		$fields = array(
		"username"=>array(
			"max"=>10,
			"min"=>4,
			"require"=>true,
			"unique"=>true
			),
		
		"email"=>array(
			"require"=>true,
			"preg_match"=>"email",
			"unique"=>true

			),
	

		"info"=>array(
			"require"=>true,
			"preg_match"=>"textarea"
			)
		);
		
		$validation = new validation();
		$pass = $validation->form_validate($fields)->passed();
		if($pass){
		$edituser = new editUser();
		$update = $edituser->edit_user(array(
			"id"=>trim($_POST['id']),
			"username"=>trim($_POST['username']),
			"email"=>trim($_POST['email']),
			"info"=>trim($_POST['info'])
			));
		if($update){
			$message = "Successfully Updated user info";
		}
		
		}else{
					$errors = $validation->formErrors();

		}
	}
		
		
?>

	<?php include('template/header_template.php'); ?>

		<header class="header">
			<h1>Welcome to Profile Page</h1>
		</header>
		<sidebar class="left-side">
					<h1>Profile Detail</h1>	
					<p>You can edit your proile detail here</p>
		<?php 
		if($login_a->find_by_id()):
			$user = $login_a->find_by_id(); ?>
	<h3><span style="color:green">Hello</span> <?php echo htmlentities($user['username']);?></h3>
	<p class="error"><?php 
			if(isset($errors)){
				foreach($errors as $error){
					echo $error;
				}
			}
			?>
			</p>
		<p class="msg">
			<?php echo isset($message)?$message:null; ?>
		
		</p>	
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="background:#999;">
		
				<p class="user-profile"><span>Username: </span>
					<input type="text" name="username" value="<?php echo htmlentities($user['username']); ?>">
				</p>

				<p class="user-profile"><span>Email: </span>
				<input type="text" name="email" value="<?php echo htmlentities($user['email']); ?>">
				</p>

				<p class="user-profile"><span>Info: </span>
				<textarea name="info" id="info" cols="10" rows="8"><?php echo htmlentities($user['info']); ?></textarea>
				<input type="hidden" name="id" value="<?php echo $user['id']; ?>">	
				</p>

			<p><input type="submit" name="edit" value="Save Edit"></p>
			<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout=1">Logout</a></p>
	</form>
		<?php endif; ?>

		</sidebar>
				<div class="clearfix"></div>




	<?php include('template/footer_template.php'); ?>
