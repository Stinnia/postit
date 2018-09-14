<?php session_start(); 
require_once('util.php');
$cmd = $_POST['cmd'] ?? null;
	
	switch ($cmd){
				
		case 'logout':
			logoutUser();
			break;
		
		case 'create_postit':
			create_postit();
			break;
			
		case 'delete_postit':
			delete_postit();
			break;
			
		case 'choose_color':
			choose_color();
			break;
			
		default:
			// ignore
			
	}
	
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Post whatever you want</title>

	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Coming+Soon" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- main style - stays the last because it overrides the themes of jquery -->
	<link rel="stylesheet" href="styles/style.css">


	<script>
	$( function() {
		$( ".draggable" ).draggable();
	} );
	</script>
</head>

<body>

	
	<div class=" container sidebar">

		<h2>Make a new Post-it</h2>
		
		<div>
			<form action="new_post_it.php" method="post">
				
				<input class="textfield-small" type="text" name="headertext"  placeholder="Title" autocomplete="off" required><br/>
				
				<textarea class="textfield-large" name="bodytext" placeholder="What do you need?" autocomplete="off" required></textarea>
			
					
				
				<?php
		  require_once('dbcon.php');
		    $sql = 'select id, colorname from color';
		    $stmt = $link->prepare($sql);
		    $stmt->execute();
		    $stmt->bind_result($colorid, $colorname);
		    while($stmt->fetch()){
					echo '<input class="radio" type="radio" name="colorid" value="'.$colorid.'">'.$colorname.PHP_EOL;
		    }
		  ?>

				<br/>
				<button class="submit-button" name="submit" type="submit" value="submit-true"> Post it!</button>
				<button class="reset-button" name="reset" type="reset" value="reset">Reset</button>

			</form>
			
			
	<hr>
	<?php
	
	if(isset($_SESSION['uid'])){ ?>
	Currently logged in as <?=$_SESSION['uname']?> 
	<?php	}
	else {
		echo 'Not logged in';
	}
	
?>
	
<form action="logout.php" method="post">
			<button class="logout_button" type="submit">Logout</button>
		</form>
		
		</div>
	</div>
	
	<div class="container whiteboard">
		<!--		good code-->
		<?php
		require_once('dbcon.php');
    $sql = 'select postit.id AS pid, date(createdate), headertext, bodytext, cssclass, users.id AS uid, username, cssclass 
	FROM postit, users, color 
WHERE users_id = users.id AND color_id=color.id;';
		
    $stmt = $link->prepare($sql);
		$stmt->execute();
	$stmt->bind_result($pid, $createdate, $htext, $btext, $cssclass, $uid, $username, $cssclass);
	while ($stmt->fetch()) { ?>
	<div class="draggable postit <?=$cssclass?>">

<?php if($_SESSION['uid']==$uid or $_SESSION['uid']===71 ) { ?>
		
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return confirm('Are you sure that you want to delete?')">
		
	<input type="hidden" name="pid" value="<?=$pid?>">
		
	<button type="submit"  name="cmd"  value="delete_postit"><i class="fa fa-trash-o"></i></button>

	</form>
		
	<?php }	
	 
	?>	

		<h2><?=$htext?></h2>
		<p><?=$btext?></p>
		<p class="name"><?=$username?></p>
		<time datetime="2018" ><?=$createdate?></time>
	</div>
	

<?php } ?>
</div>
</body>
</html>