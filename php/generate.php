<?php
	include_once('../classes/StudentFactory.php');

	if (isset($_GET['delete'])) {
		include_once('../classes/MyPDO.php');
		$list_id = $_GET['delete'];
		$db = MyPDO::getDb();

		$str = "DELETE FROM `group404_scheduledb`.`student` WHERE `student`.`list_id` = '$list_id'";
		$query = $db->prepare($str);
		$query->execute();

		$str = "DELETE FROM `group404_scheduledb`.`grades` WHERE `grades`.`list_id` = '$list_id'";
		$query = $db->prepare($str);
		$query->execute();
		
	} else if (isset($_GET['save'])) {

	} else {
		echo "<input type='button' class='btn btn-info' onClick='save()' value='Save'/>";
		echo "<input type='button' class='btn btn-warning' onClick='delete_button()' value='Delete'/>";

		echo "<table id='new_table' class='table table-striped'>";
		$colArray = array("ID", "Major ID", "KSU Name", "Name", "Enroll Term", "Enroll Year", "Enroll Quarter", "Dropout", "GPA", "Units", "List ID");
		$tableHeader = "<tr><th>".implode("</th><th>", $colArray)."</th></tr>";
		echo $tableHeader;

		$options = $_GET;


		$factory = new StudentFactory("1", "2012", $options);
		$factory->generateStudents();

		echo "</table>";
	}
?>