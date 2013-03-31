<?php

header('Content-Type: application/json');

// Auto load the classes needed
function __autoload($classname) {
    $filename = "../classes/". $classname .".php";
    include_once($filename);
}

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

				$db = MyPDO::getDb();

				// Query string
				$str = "SELECT * FROM curriculum ";
				$str .= "WHERE year=:year ";
				$str .= "AND quarter=:quarter";
				$query = $db->prepare($str);
				$query->bindParam(':year', $year);
				$query->bindParam(':quarter', $quarter);
				$query->execute();

				if ($query->rowCount() === 0) {
					header('HTTP/1.0 400 Bad Request');
				}

				$data = array();
				while ($result = $query->fetch()) {
					$row = array();
					foreach ($result as $key => $value) {
						$row[$key] = $value;
					}
					array_push($data, $row);
				}

				echo json_encode($data);
			} else {
				header('HTTP/1.0 400 Bad Request');
			}
		} else if ($request === 'student') {
			$db = MyPDO::getDb();

			// Query string
			$str = "SELECT * FROM student ";
			$query = $db->prepare($str);
			$query->execute();

			if ($query->rowCount() === 0) {
				header('HTTP/1.0 400 Bad Request');
			}

			$data = array();
			while ($result = $query->fetch()) {
				$row = array();
				foreach ($result as $key => $value) {
					$row[$key] = $value;
				}
				array_push($data, $row);
			}

			echo json_encode($data);
		} else {
			header('HTTP/1.0 400 Bad Request');
		}
		
	}
} else {
	header('HTTP/1.0 404 Not Found');
}

?>