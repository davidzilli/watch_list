<?php
	session_start();
	require_once 'classes/Membership.php';
	$membership = new Membership();

	// If the user clicks the "Log Out" link on the index page.
	if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
		$membership->log_User_Out();
	}

	// Did the user enter a password/username and click submit?
	if($_POST['submit'] && !empty($_POST['email']) && !empty($_POST['pwd'])) {
		$response = $membership->validate_User($_POST['email'], $_POST['pwd']);
	}

	// Did the user enter a password/username and click signup?
	if($_POST['signup'] && !empty($_POST['email']) && !empty($_POST['pwd'])) {
		$response = $membership->add_user($_POST['email'], $_POST['pwd']);
	}
?>

<!doctype html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" type="text/css" href="watchlist.css" media="screen" />
<script src="js/json2.js"></script>
<script src="js/jquery-1.9.0.min.js"></script>
<script src="js/watchlist.js"></script>


<title>Watch List: Login</title>
</head>


<body>
	<header>
	</header>

	<div id = "login">
		<form method="post" action="">
	    	<h2>Login <small>enter your credentials</small></h2>
	        <p>
	        	<label for="name">Email: </label>
	            <input type="text" name="email" />
	        </p>
	        
	        <p>
	        	<label for="pwd">Password: </label>
	            <input type="password" name="pwd" />
	        </p>
	        
	        <p>
	        	<input type="submit" id="submit" value="Login" name="submit" />
	        </p>
	        <p>
	        	<input type="submit" id="signup" value="Sign Up" name="signup" />
	        </p>
	    </form>
	</div>
	<?php 
		if(isset($response))
			 echo "<h4 class='alert'>" . $response . "</h4>";
		elseif (!isset($response) && $_POST['signup'])
			 echo "<h4 class='alert'>Thank you for signing up</h4>";
	?>

	<footer>
	</footer>
</body>


</html>