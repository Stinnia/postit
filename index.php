<?php
session_start();
require_once('util.php');
?>

	
<!doctype html>
<html lang="en">
<head>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<meta charset="UTF-8">
<title>Login page</title>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link href="styles/style.css" rel="stylesheet">

</head>
<body id="LoginForm">

<?php 
	$cmd = $_POST['cmd'] ?? null;
	
	switch ($cmd){
		case 'createuser':
			$un = filter_input(INPUT_POST, 'un') or die('Missing or illegal un parameter');	
			$pw = filter_input(INPUT_POST, 'pw') or die('Missing or illegal pw parameter');	
			if (createUser($un, $pw) > 0){
				loginUser($un, $pw);
				echo "<script>";
				echo " alert('New user has been created');      
						window.location.href='postitboard.php';
					  </script>";
			}
			else {
				echo "<script>";
				echo " alert('User already exists');      
						window.location.href='index.php';
					  </script>";
			}
			break;
		case 'login':
			$un = filter_input(INPUT_POST, 'un') or die('Missing or illegal un parameter');	
			$pw = filter_input(INPUT_POST, 'pw') or die('Missing or illegal pw parameter');	
		
			if (loginUser($un, $pw) > 0){
				loginUser($un, $pw);
				echo "<script>";
				echo "window.location.href='postitboard.php';
					  </script>";
			}
			else {
				echo "<script>";
				echo " alert('Wrong user/password combination');      
						window.location.href='index.php';
					  </script>";
			}
			break;
		case 'logout':
			logoutUser();
			break;
		default:
			// ignore
	}
	
?>

<div class="container">
<div class="login-form">
<div class="main-div">
<h1 class="form-heading">Post it board</h1>

	
<form id="Login" action="<?=$_SERVER['PHP_SELF']?>" method="post">	
	<fieldset>
<?php
	if (isset($_SESSION['uid'])){ ?>	
		<legend>Logged in as <?=$_SESSION['uname']?></legend>
		<button type="submit" name="cmd" value="logout">Logout</button>
<?php } else { ?>

	<div class="panel">
		<h2>Login / Create a user</h2>
		</div>
		<div class="form-group">
		<input type="text" class="form-control" name="un" placeholder="Username" required>
		</div>
		<div class="form-group">
		<input type="password" class="form-control" name="pw" placeholder="Password" required>
		</div>
		<button type="submit" class="btn btn-primary" name="cmd" value="login">Login</button>
		<button type="submit" class="btn btn-primary" name="cmd" value="createuser">Create</button>
		
<?php } ?>
	</fieldset>	
</form>
	 </div></div></div>

</body>
</html>