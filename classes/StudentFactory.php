<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

class StudentFactory {
	private $db;
	public $curriculum_tree;
	private $list_id;
	private $starting_id;
	private $max_students;
	private $class_limit;

	public function __construct($major_id, $year, $options) {
		if (isset($options['max_students']) && strlen($options['max_students']) !== 0) {
			$this->max_students = $options['max_students'];
		} else {
			$this->max_students = 10;
		}
		if (isset($options['class_limit']) && strlen($options['class_limit']) !== 0) {
			$this->class_limit = $options['class_limit'];
		} else {
			$this->class_limit = -1;
		}

		$this->db = MyPDO::getDb();

		// Get the starting list_id for this list of students
		$str = "SELECT max(list_id) FROM `student`";
		$query = $this->db->prepare($str);
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$this->list_id = $row['max(list_id)']+1;
		}

		if (isset($options['starting_id']) && strlen($options['starting_id']) !== 0) {
			$this->starting_id = $options['starting_id'];
			echo "+++++++".$this->starting_id;
		} else {
			// Get the starting id for the first student
			$str = "SELECT max(id) FROM `student`";
			$query = $this->db->prepare($str);
			$query->execute();
			$result = $query->fetchALL(PDO::FETCH_ASSOC);

			foreach ($result as $row) {
				$this->starting_id = $row['max(id)']+1;
			}
			
		}
		

		// Query string
		$str = "SELECT * FROM curriculum ";
		$str .= "WHERE major_id = '$major_id' AND year = '$year' ";
		$query = $this->db->prepare($str);
		$query->execute();

		//create an array of Curriculum objects
		$curriculum_table = $query->fetchAll(PDO::FETCH_CLASS, "Curriculum");
		$this->curriculum_tree = new CurriculumNode("root");

		// Put all the classes with no prereq into tree that is not a lab class
		foreach ($curriculum_table as $key => $row) {
			$classname = $row->classname;
			if ($row->prerequisites === '' && $classname[strlen($classname)-1] !== 'L') {
				$this->curriculum_tree->addChildren(new CurriculumNode($row));
				unset($curriculum_table[$key]);
			}
		}

		// Create the objects now because some of them will point to same obj
		$hash = array();
		foreach ($curriculum_table as $row) {
			$hash[$row->classname] = new CurriculumNode($row);
		}

		// Printing classes in tree
		$unvisited = $this->curriculum_tree->children;
		$iterator = reset($unvisited);
		while ($iterator) {
			$node = current($unvisited);
			// echo "$node->classname, ";
			foreach (current($unvisited)->children as $temp) {
				if (!in_array($temp, $unvisited)) {
					// Samething as array_push
					$unvisited []= $temp;
				}
			}
			$iterator = next($unvisited);
		}
		// echo "<br>";

		$unvisited = $this->curriculum_tree->children;
		// Make an iterator
		$iterator = reset($unvisited);
		// Attach all the classes with the prereq taken
		while ($iterator) {
			$node = current($unvisited);
			foreach ($curriculum_table as $key => $row) {

				// Find the position of the classname inside the prereq and class is not lab
				$pos = strpos($row->prerequisites, $node->classname);
				if ($pos !== false && $row->classname[strlen($row->classname)-1] !== 'L') {
					// echo "add $row->classname, ";
					$node->addChildren($hash[$row->classname]);
				}
			}
			// Add the children of current node to iterator, breath first search
			foreach ($node->children as $temp) {
				if (!in_array($temp, $unvisited)) {
					// Samething as array_push
					$unvisited []= $temp;
				}
			}
			$iterator = next($unvisited);
		}
		
		// echo "<br>";
		// print_r($curriculum_table);
	}

	public function generateStudents() {
		// print("Generating students: 229 Total units");
		// 57 units 1st year
		// 114 units 2nd year
		// 171 units 3rd year
		// 229 units 4th year
		// 57.25 classes total
		

		for ($i = $this->starting_id; $i < $this->starting_id+$this->max_students; $i++) {
			if ($this->class_limit === -1) {
				$r = rand(1,100);
			} else if ($this->class_limit === 1) {
				$r = rand(1, 20);
			} else if ($this->class_limit === 2) {
				$r = rand(21, 40);
			} else if ($this->class_limit === 3) {
				$r = rand(41, 60);
			} else if ($this->class_limit === 4) {
				$r = rand(61, 80);
			}
			
			// print($r);
			if ( $r >= 1 && $r < 21) {
				// print("first year");
				$s = $this->newStudent($i, 1, rand(100, 400)/100, rand(1, 57), $this->list_id);
			} else if ( $r >= 21 && $r < 41) {
				// print("second year");
				$s = $this->newStudent($i, 1, rand(100, 400)/100, rand(58, 114), $this->list_id);
			} else if ( $r >= 41 && $r < 61) {
				// print("third year");
				$s = $this->newStudent($i, 1, rand(100, 400)/100, rand(115, 171), $this->list_id);
			} else if ( $r >= 61 && $r < 81) {
				// print("fourth year");
				$s = $this->newStudent($i, 1, rand(100, 400)/100, rand(172, 229), $this->list_id);
			} else {
				// print("five+ year");
				$s = $this->newStudent($i, 1, rand(100, 400)/100, rand(172, 229), $this->list_id);
			}

			echo "<tr>";
			echo "<td>$s->id</td>";
			echo "<td>$s->major_id</td>";
			echo "<td>$s->ksu_name</td>";
			echo "<td>$s->name</td>";
			echo "<td>$s->enroll_term</td>";
			echo "<td>$s->enroll_year</td>";
			echo "<td>$s->enroll_quarter</td>";
			echo "<td>$s->dropout</td>";
			echo "<td>$s->gpa</td>";
			echo "<td>$s->units</td>";
			echo "<td id='list_id'>$s->list_id</td>";
			echo "</tr>\n";

			$str = "INSERT INTO student (id, major_id, ksu_name, name, enroll_term, enroll_year, enroll_quarter, dropout, gpa, units, list_id) ";
			$str .= "value (:id, :major_id, :ksu_name, :name, :enroll_term, :enroll_year, :enroll_quarter, :dropout, :gpa, :units, :list_id)";
			$query = $this->db->prepare($str);
			$query->execute((array)$s);
		}
		// var_dump($s);
	}

	private function newStudent($id, $major, $max_gpa, $max_units, $list_id) {
		$units = 0;
		$gpa = $max_gpa;
		$total_gp = 0;
		$unvisited = $this->curriculum_tree->children;
		$visited = array();
		$iterator = reset($unvisited);
		
		while ($iterator) {
			$node = current($unvisited);
			if ($units >= $max_units) {
				break;
			} else {
				$units += $node->units;
				$letter_grades = array("F", "D", "C", "B", "A");
				$temp = $max_gpa*100;
				while ($temp > 350 && $temp < 150) {
					$temp = $max_gpa*100;
				}
				$grade = round(rand($temp-50, $temp+50)/100);
				$gp = $gp + ($node->units * $grade);
				$this->addGrade($id, $letter_grades[$grade], $node);
			}
			foreach (current($unvisited)->children as $temp) {
				if (!in_array($temp, $unvisited)) {
					// Samething as array_push
					$unvisited []= $temp;
				}
			}
			$iterator = next($unvisited);
		}
		$starting_term = $this->currentTerm($units);
		$counting_term = $starting_term[0];
		$counting_year = $starting_term[1];
		$gpa = (round(($gp / $units) * 100)) / 100.0;
		$s = new Student();
		$s->setValue($id, $major, "s".$id, "Student ".$id, 0, $starting_term[1], $starting_term[0], 0, $gpa, $units, $list_id);
		return $s;
	}

	private function addGrade($student_id, $g, $node) {
		$myGrade = new Grades();
		$myGrade->setValue(1, $student_id, 0, $node->classname, $g, 30, $this->list_id);
		
		$str = "INSERT INTO grades (term, student_id, class_id, class_name, grade, seat, list_id) ";
		$str .= "value (:term, :student_id, :class_id, :class_name, :grade, :seat, :list_id)";
		$query = $this->db->prepare($str);
		unset($myGrade->id);
		$query->execute((array)$myGrade);
	}

	private function currentTerm($units) {
		$year = date("Y");
		$month = date("m");
		$quarterStr = array("Fall", "Winter", "Spring", "Summer");
		$quarter = -1;
		
		if ($month >= 10 && $month <= 12) {
			$quarter = 0;
		} else if ($month >= 1 && $month <= 3) {
			$quarter = 1;
		} else if ($month >= 4 && $month <= 6) {
			$quarter = 2;
		} else if ($month >= 7 && $month <= 9) {
			$quarter = 3;
		}
		// Enrollment quarter = current quarter - how many quarters student has taken
		$enroll_term = ($quarter - ($units / 15)) % 4;
		if ($enroll_term < 0) {
			$enroll_term += 4;
		}
		$enroll_year = ($quarter - ($units / 15)) / 4;
		$enroll_year = $year - floor(abs($enroll_year));
		return array($quarterStr[$enroll_term], $enroll_year);
	}
}

?>