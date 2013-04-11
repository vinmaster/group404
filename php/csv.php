<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=csv.csv");

if (isset($_GET['request'])) {
	$request = $_GET['request'];
	if ($request === 'studentsYearPie') {
		// Make flowchart for curriculum
		include_once('../classes/MyPDO.php');
		$db = MyPDO::getDb();
		$str = "SELECT * FROM `student`";
		$query = $db->prepare($str);
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		$first_years = 0;
		$second_years = 0;
		$third_years = 0;
		$fourth_years = 0;
		foreach ($result as $row) {
			$units = $row['units'];
			if ($units <= 57) {
				$first_years += 1;
			} else if ($units <= 114) {
				$second_years += 1;
			} else if ($units <= 171) {
				$third_years += 1;
			} else {
				$fourth_years += 1;
			}
		}
		
		echo "years,population\n";
		echo "Freshman,$first_years\n";
		echo "Sophomore,$second_years\n";
		echo "Junior,$third_years\n";
		echo "Senior,$fourth_years\n";
	} else if ($request === 'studentsLeft') {
		include_once('../classes/MyPDO.php');
		$db = MyPDO::getDb();
		$str = "SELECT * FROM `student`";
		$query = $db->prepare($str);
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		$first_years = 0;
		$second_years = 0;
		$third_years = 0;
		$fourth_years = 0;
		foreach ($result as $row) {
			$units = $row['units'];
			if ($units <= 57) {
				$first_years += 1;
			} else if ($units <= 114) {
				$second_years += 1;
			} else if ($units <= 171) {
				$third_years += 1;
			} else {
				$fourth_years += 1;
			}
		}
		
		echo "years,population\n";
		echo "Freshman,$first_years\n";
		echo "Sophomore,$second_years\n";
		echo "Junior,$third_years\n";
		echo "Senior,$fourth_years\n";
	}
} else {
	header('HTTP/1.0 404 Not Found');
}

?>