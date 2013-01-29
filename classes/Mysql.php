<?php

require_once 'includes/constants.php';

class Mysql {
	private $conn;
	
	function __construct() {
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or 
					  die('There was a problem connecting to the database.');
	}
	
	function verify_Username_and_Pass($un, $pwd) {
				
		$query = "SELECT User_ID
				FROM WL_users
				WHERE username = ? AND password = ?
				LIMIT 1";
				
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->bind_result($user_id);
			$stmt->execute();
			
			if($stmt->fetch()) {
				$ID = $user_id;
				$stmt->close();
				return $ID;
			}
		}
	}

	function find_Username($un) {
		$query = "SELECT *
				FROM WL_users
				WHERE username = ?
				LIMIT 1";
		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('s', $un);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}

	function register_User($un, $pwd) {

		$query = "INSERT 
				INTO WL_users (username, password)
				VALUES (?, ?)";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();
			$stmt->close();
		}
	}

	function retrieve_Movies($ID) {
		
		/*This function will retrieve all the movie
		titles and sources from the DB. In the future
		it should be changed to only get a single
		user's titles. Perhaps also made more of a
		template function which can be reused*/

		//Select ALL movies
		$query_mov = "SELECT *
				FROM WL_titles
				WHERE User_ID = ?";

		$query_link = "SELECT *
				FROM WL_links
				WHERE Movie_ID = ?";
		/*conn is the mysqli object in this class
		Normal workflow is create a query var,
		prepare it with the mysqli object member
		function, bind params (if there are any),
		and execute the query. If there are return
		values, use bind_result() to bind ALL
		columns to a variable.*/

		$movie_results = array();

		if($stmt_mov = $this->conn->prepare($query_mov)) {
			$stmt_mov->bind_param('i', $ID);
			$stmt_mov->execute();
			$stmt_mov->bind_result($movie_id, $user_id, $title, $source);
			
			//fetches one row at a time
			while ($stmt_mov->fetch()){
				$row = array();
				array_push($row, $movie_id, $user_id, $title, $source);
				$movie_results[] = $row;
				}
			}
			$stmt_mov->close();

			foreach($movie_results as $row){

				echo 
					"<li>"
					."<a href='' class='title'>"
					. $row[2]
					. "</a>"
					. "<ul>"
					."<form method='post' action='' id = 'delete_movie'><input type='submit' value = '"
					.$row[0]
					. "' name='delete' /></form>";

				if($stmt_link = $this->conn->prepare($query_link)) {
					$stmt_link->bind_param('i', $row[0]);
					$stmt_link->execute();
					$stmt_link->bind_result($movie_id2, $link, $link_seen);

				//Now get all the links and generate their html
					while ($stmt_link->fetch()){
						echo
							"<li>"
							.$link
							."</li>";
					}
				}//End Link calls

				echo
					"</ul></li>";	
		}
		$stmt_link-close();			

	}

	function add_Movie($ID, $title, $sources) {
		//params are username, title, and sources
		//create query to insert
		$query = "INSERT
				INTO WL_titles (User_ID, Title, Source)
				VALUES (?, ?, ?)";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('iss', $ID, $title, $sources);
			$stmt->execute();
			$stmt->close();
		}
	}

	function update_Movie() {
		/*params are username, title, and sources
		create query to update based on change
		to sources.
		If a title is changed, perhaps we'll
		delete the old one and add a new one.*/
	}

	function remove_Movie($movie_id) {
		/*param is movie id*/
		$query_movies = "DELETE
				FROM WL_titles
				WHERE Movie_ID = ?";

		$query_links = "DELETE 
				FROM WL_links
				WHERE Movie_ID = ?";

		if($stmt = $this->conn->prepare($query_movies)) {
			$stmt->bind_param('i', $movie_id);
			$stmt->execute();
			//$stmt->close();
		}
		if($stmt = $this->conn->prepare($query_links)) {
			$stmt->bind_param('i', $movie_id);
			$stmt->execute();
			//$stmt->close();
		}
	}

}