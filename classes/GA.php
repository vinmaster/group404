<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}
// Use the MyPDO class inside classes folder to connect to MySQL
$this->db = MyPDO::getDb();

$classneeds=array();
//Get number of students needing each class
//-----------------------------------------------------------------//
// Query string to get class listing and prerequisites
$str = "SELECT DISTINCT `classname`, `prerequisites`  FROM `curriculum`";
$str .= "WHERE major=1 ORDER BY `classname` DESC";
$query = $this->db->prepare($str);
$result=$query->execute();

while(($row = mysql_fetch_assoc($result))) {
	$classneeds[$row[`classname`]] = 0;
}

// Query string to get student listing
$str2 = "SELECT `id`  FROM `student`";
$query2 = $this->db->prepare($str2);
$result2=$query2->execute();

while(($student = mysql_fetch_assoc($result2))) {
	// Query string to get classes a student has taken
	$str1 = "SELECT `classname`  FROM `curriculum`";
	$str1 .= "INNER JOIN `student` ON `year` = `year_enrolled'";
	$str1 .= "WHERE `classname` NOT IN (";
	$str1 .= "SELECT `classname` FROM `grades`";
	$str1 .= "INNER JOIN `student` ON `student_id` = `student`.`id`";
	$str1 .= "WHERE `student_id` = ";
	$str1 .= $student;
	$str4 = "SELECT `classname` FROM `curriculum` ";
	$str4 .= "WHERE major=1 ";
	$str4 .= "AND NOT IN ";
	$str4 .= str1;
	$query1 = $this->db->prepare($str4);
	$result1=$query1->execute();
	
	while(($row = mysql_fetch_assoc($result1))) {
		$classneeds[$row[`classname`] += 1;
	}
	sort($classneeds);
}
//subtracts classneeds value for each prereq needed.
//query to get class list with prere

while(($row = mysql_fetch_assoc($result))) {
	$prereqs = 0;
	$string = $row[`prerequisites`];
	$prereq = "";
	for ($i = 1; $i < strlen($string); $i++) {
		if($string{$i}==',') {
			$classneeds[$row[`classname`]] -= $classneeds[$row[`prerequisites`]];
			$prereq = "";
			continue;
		}
		else {
			$prereq += $i;
		}
		
	}
}
//----------------------------------------------------------------//

$professors=array();
$rooms=array();

//initilize professors list with time schedule
$strprof = "SELECT `id`  FROM `professor`";
$queryprof = $this->db->prepare($str);
$resultprof=$queryprof->execute();
while(($row = mysql_fetch_assoc($resultprof))) {
	$professors[$row[`id`]] = array(new TimeBlock, 0)
}

//initialize rooms list with sizes and time schedules
$str = "SELECT `id`, `class_size`  FROM `rooms`";
$query = $this->db->prepare($str);
$result=$query2->execute();
while(($row = mysql_fetch_assoc($result))) {
	$rooms[$row[`id`]] = array(new TimeBlock, $row[`class_size`], 0);
}
$flag = 0;
$roomcnt = 0;
$breakflag = 0;
$schedule = array();
rsort($classneeds);
while(flag==0) {
	$maxed = 1;
	//if all classneeds are handled exit
	if($classneeds[0] <= 0) {
		break;
	}
	//if a teacher is worked to the max set flag to 1
	for($i=0; i< sizeof($professors); i++) {
		$count=0;
		for($j=0; j< sizeof($professors[i][0]->$times); i++) {
			if ( $professors[i][0]->$times[j] == 1) {
				$count += 1;
			}
		}
		if ($count == sizeof($professors[i][0]->$times) {
			$professors[i][1] = 1;
		}
	}
	//if a room are used to the max set flag to 1
	for($i=0; i< sizeof($rooms); i++) {
		$count=0;
		for($j=0; j< sizeof($rooms[i][1]->$times); i++) {
			if ( $rooms[i][1]->$times[j] == 1) {
				$count += 1;
			}
		}
		if ($count == sizeof($rooms[i][1]->$times) {
			$rooms[i][2] = 1;
		}
	}
	
	for($i=0; i< sizeof($rooms); i++) {
		if ($rooms[i][2] == 0) {
			$maxed = 0;
			break;
		}
	}
	
	for($i=0; i< sizeof($professors); i++) {
		if ($rooms[i][1] == 0) {
			$maxed = 0;
			break;
		}
	}
	
	if($maxed == 1) {
		break;
	}
	$class = new GAClass;
	$class->classname = key(classneeds[0]);
	//give class a room depending on needs and size
	while(true) {
		if ($classneeds[0] <= $rooms[roomcnt][1]) {
			$classneeds[0]-= $rooms[roomcnt][1];
			$class->room = key($rooms[roomcnt])
			for($i=0; i< sizeof($rooms[roomcnt][0]->$times); i++ {
				if ( $rooms[$roomcnt][0]->$times[i] == 0) {
					$rooms[$roomcnt][0]->$times[i] = 1;
					$class->time = i;
				}
			}
			//find an available professor and assign
			for($i=0; i< sizeof($professors); i++) {
				if($breakflag==1) {
					break;
				}
				for($j=0; j< sizeof($professors[i]->$times); i++) {
					if ( $professors[i]->$times[j] == 0) {
						$class->professor = i;
						$professors[i]->$times[j] = 1;
						$breakflag=1;
						break;
					}
				}
			}
			$roomcnt=0;
			break;
		}
		else {
			roomcnt++;
		}
	}
	array_push($schedule, $class);
	rsort($classneeds);
}

$class->classname = $classneeds[rand(0,sizeof($classneeds))]



?>