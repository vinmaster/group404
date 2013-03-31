<?php

header('Content-Type: application/json');

if (isset($_POST['request'])) {//isset($_POST['login']) AND 
	//Make sure not anyone can access this
	if (!true){//Auth::isLoggedIn()) {
		// printf('Not already logged in');
		header('HTTP/1.0 401 Unauthorized');
	} else {
		// $login = $_POST['login'];
		$request = $_POST['request'];

		if ($request === 'curriculum') {
			if (isset($_POST['year']) && isset($_POST['quarter'])) {
				$year = $_POST['year'];
				$quarter = $_POST['quarter'];

				include_once('../classes/CurriculumList.php');
				$curriculumTable = new CurriculumList($year, $quarter);
				if (!$curriculumTable->isEmpty()) {
					$data = $curriculumTable->toJSON();
				} else {
					header('HTTP/1.0 400 Bad Request');
				}

				echo $data;
			} else {
				header('HTTP/1.0 400 Bad Request');
			}
		} else if ($request === 'student') {
			include('../classes/StudentList.php');
			$studentTable = new StudentList();
			$data = $studentTable->toJSON();

			echo $data;
		} else {
			header('HTTP/1.0 400 Bad Request');
		}
		
	}
} else {
	header('HTTP/1.0 404 Not Found');
}

?>