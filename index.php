<?php
	session_start();
	require_once 'classes/Membership.php';
	require_once 'classes/Movies.php';

	$membership = New Membership();
	$membership->confirm_Member();

	$movies = New Movies();

	// Did the user enter add a new movie and click save?
	if($_POST['saveMovie'] && !empty($_POST['titleInput'])) {
		$source = "";
		if (isset($_POST['source']) && is_array($_POST['source'])) {	
			$length = count($_POST['source']);
			for ($i = 0; $i < $length; $i++){
				$source .= $_POST['source'][$i];
				if ($i != $length-1)
					$source .= '|';
			} 
		}
		$movies->add_Movie($_SESSION['ID'],
			 $_POST['titleInput'], $source);
	}
	
	// Did the user click the delete button for a movie?
	if($_POST['delete']) {
		$movies->delete_Movie($_POST['delete']);
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


<title>Watch List</title>
</head>


<body>
	<header>
    <h1>Watch List</h1>
	</header>
	<?php
		echo 
			"<div id = 'username'>"
				. $_SESSION['username'] .
			"</div>";
	?>
	<a href="login.php?status=loggedout">Log Out</a>
	<div id="pages">
	 
	 	   <div id="addnew">
	    	<form method="post" action="" id="add_new_form">
		    	Title: <input type="text" name = "titleInput" id="titleInput" /><br />
		    	Apply filters by source:<br />
		    	Default is no filter<br />
		    	<ul id="filters">
		    		<li><input type="checkbox" name ="source[]" value="720p">720p</li>
		    		<li><input type="checkbox" name ="source[]" value="1080p">1080p</li>
		    		<li><input type="checkbox" name ="source[]" value="BLURAY">BLURAY</li>
		    		<li><input type="checkbox" name ="source[]" value="DVDRIP">DVDRIP</li>
		    		<li><input type="checkbox" name ="source[]" value="DVDSCR">DVDSCR</li>
		    		<li><input type="checkbox" name ="source[]" value="HDTV">HDTV</li>
		    		<li><input type="checkbox" name ="source[]" value="CAM">CAM</li>
		    		<li><input type="checkbox" name ="source[]" value="TS">TS</li>
		    	</ul>
		    	<input type="submit" value="save" id="saveMovie" name="saveMovie"/>
		    	<div class = "nav">
		    		<!--<a href="#movie-main" id="savemovie">Save</a>-->
		    		<a href="#movie-main" id="cancelmovie">Cancel</a>
		    	</div>
	    	</form>
	    </div>  

	    <div id="movie-main" class="current">
	    	<div class = "nav">
	    		<a href="#addnew">Add a movie</a>
	    	</div>


	    	<div id = "movielist">
		    	<ul>

		    		<?php
	    				//populates the movie list
						$movies->get_Movies($_SESSION['ID']);	
					?>
				</ul>
		    </div>

	    </div>

	</div>
	
	<footer>
	</footer>
</body>


</html>