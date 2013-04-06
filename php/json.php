<?php

// Declare the type of content in this page is json
header('Content-Type: application/json');

if (isset($_POST['request'])) {//isset($_POST['login']) AND 
	//Make sure not anyone can access this, NOT DONE
	if (!true){//Auth::isLoggedIn()) {
		header('HTTP/1.0 401 Unauthorized');
	} else {
		// $login = $_POST['login'];
		// Get the type of request this is for
		$request = $_POST['request'];

		if ($request === 'curriculum') {
			if (isset($_POST['year']) && isset($_POST['major'])) {
				$year = $_POST['year'];
				$major = $_POST['major'];

				// I need this for creating CurriculumList object, autoload won't work for this
				include_once('../classes/CurriculumList.php');
				$curriculumTable = new CurriculumList($year, $major);
				// The result is empty if query returns nothing
				if (!$curriculumTable->isEmpty()) {
					// data to send
					$data = $curriculumTable->toJSON();
				} else {
					// This will return error on ajax request
					header('HTTP/1.0 400 Bad Request');
				}

				// display data on this page for ajax to fetch
				echo $data;
			} else {
				header('HTTP/1.0 400 Bad Request');
			}
		} else if ($request === 'student') {
			// I need this for creating StudentList object, autoload won't work for this
			include('../classes/StudentList.php');
			$studentTable = new StudentList();
			$data = $studentTable->toJSON();

			// display data on this page for ajax to fetch
			echo $data;
		} else {
			header('HTTP/1.0 400 Bad Request');
		}
		
	}
} else {
	header('HTTP/1.0 404 Not Found');
}

?>