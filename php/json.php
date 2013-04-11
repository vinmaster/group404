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
		} else if ($request === 'studentlist') {
			if (isset($_POST['list'])) {
				if ($_POST['list'] == "ID") {
					header('HTTP/1.0 400 Bad Request');
				}
				// include('../classes/StudentList.php');
				// $studentTable = new StudentList();
				// $data = $studentTable->toJSON();
				$list = $_POST['list'];

				include_once("../classes/MyPDO.php");
				$db = MyPDO::getDb();
				$str = "SELECT * FROM `student` WHERE `list_id` = $list";
				$query = $db->prepare($str);
				$query->execute();
				$result = $query->fetchALL(PDO::FETCH_ASSOC);
				$json = array();
				foreach ($result as $row) {
					$temp = array();
					foreach ($row as $key => $col) {
						$temp[$key] = $col;
					}
					array_push($json, $temp);
				}
				echo json_encode($json);

				// display data on this page for ajax to fetch
				echo $data;
			} else {
				include_once("../classes/MyPDO.php");
				$db = MyPDO::getDb();
				$str = "SELECT list_id FROM `student`";
				$str .= "GROUP BY list_id ";
				$query = $db->prepare($str);
				$query->execute();
				$result = $query->fetchALL(PDO::FETCH_ASSOC);
				$json = array();
				foreach ($result as $row) {
					$json []= $row['list_id'];
				}
				echo json_encode($json);
			}
		} else if ($request === 'studentStats') {
			$list = $_POST['list'];
			include_once("../classes/MyPDO.php");
			$db = MyPDO::getDb();
			$str = "SELECT * FROM `student` WHERE `list_id` = $list ";
			$query = $db->prepare($str);
			$query->execute();
			$result = $query->fetchALL(PDO::FETCH_ASSOC);
			$totalStudents = 0;
			$totalUnits = 0;
			$totalRemaining = 0;
			$avgRemaining = 0;
			$avgTaken = 0;
			$maxUnits = 0;
			$minUnits = 999;
			$grad = 0;
			$under = 0;
			foreach ($result as $row) {
				$units= $row['units'];
				$totalStudents += 1;
				$totalUnits += $units;
				if ($units > $maxUnits) {
					$maxUnits = $units;
				}
				if ($units < $minUnits) {
					$minUnits = $units;
				}
				if ($units === 229) {
					$grad += 1;
				} else {
					$under += 1;
				}
				$totalRemaining += (229 - $units);
			}
			$avgRemaining = $totalRemaining / $totalStudents;
			$avgTaken = $totalUnits / $totalStudents;
			$json = array('avgRemaining'=>$avgRemaining, 'avgTaken'=>$avgTaken, 'maxUnits'=>$maxUnits, 'minUnits'=>$minUnits, 'students'=>$under, 'grad'=>$grad);
			echo json_encode($json);
		} else {
			header('HTTP/1.0 400 Bad Request');
		}
		
	}
} else if (isset($_GET['request'])) {
	$request = $_GET['request'];
	if ($request === 'curriculumGraph') {
		// Make flowchart for curriculum
		include_once('../classes/StudentFactory.php');
		$factory = new StudentFactory("1", $_GET['year'], '');
		$tree = $factory->curriculum_tree;
		$jsonArray = array();
		// connect root to the children
		foreach ($tree->children as $node) {
			$jsonArray []= array('source'=>'Start', 'target'=>$node->classname);
		}

		$unvisited = $tree->children;
		$iterator = reset($unvisited);
		while ($iterator) {
			$node = current($unvisited);
			// echo "$node->classname, ";
			foreach (current($unvisited)->children as $temp) {
				$jsonArray []= array('source'=>$node->classname, 'target'=>$temp->classname);
				if (!in_array($temp, $unvisited)) {
					// Samething as array_push
					$unvisited []= $temp;
				}
			}
			$iterator = next($unvisited);
		}
		echo json_encode($jsonArray);
	}
} else {
	header('HTTP/1.0 404 Not Found');
}

?>