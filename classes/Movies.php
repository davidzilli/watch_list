<?php

//require 'Mysql.php';

class Movies {
	
	
	function get_Movies($ID) {

		$mysql = New Mysql();

		$mysql->retrieve_Movies($ID);

	}

	function add_Movie($ID, $title, $sources) {
		$mysql = New Mysql();

		$mysql->add_Movie($ID, $title, $sources);

	}

	function delete_Movie($movie_id) {
		$mysql = New Mysql();

		$mysql->remove_Movie($movie_id);
	}

	function update_Movie($un, $title, $sources) {

	}

}