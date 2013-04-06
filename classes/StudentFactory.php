<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

class StudentFactory {
	private $db;
	private $curriculum_table;
	private $curriculum_tree;

	public function __construct($curriculum_id) {
		$this->db = MyPDO::getDb();

		// Query string
		$str = "SELECT * FROM curriculum ";
		$str .= "WHERE id = '$curriculum_id' ";
		$query = $this->db->prepare($str);
		$query->execute();

		//create an array of Curriculum objects
		$this->curriculum_table = $query->fetchAll(PDO::FETCH_CLASS, "Curriculum");
		$this->curriculum_tree = new CurriculumNode("root");

		foreach ($curriculum_table as $index => $row) {
			$id = $row['id'];
			$major_id = $row['major_id'];
			$year = $row['year'];
			$classname = $row['classname'];
			$units = $row['units'];
			$prerequisites = $row['prerequisites'];
			$corequisites = $row['corequisites'];
			if ($row['prerequisites'] === '') {
				$this->curriculum_tree->addChildren(new CurriculumNode($classname));
				unset($curriculum_table[$index]);
			}

		}
	}

	public function generateStudents() {
		println("Generating students: 229 Total units");
		// 57 units 1st year
		// 114 units 2nd year
		// 171 units 3rd year
		// 229 units 4th year
		// 57.25 classes total
		for ($i = 0; $i < 10; $i++) {
			
			$r = rand(1,100);
			println($r);
			if ( $r >= 1 && $r < 14) {
				println("first year");
			} else if ( $r >= 4 && $r < 6) {
				println("second year");
			} else if ( $r >= 6 && $r < 7) {
				println("third year");
			} else {
				println("fourth year");
			}
		}

		println("End script");
	}

	private function println($s) {
		echo $s.'<br>';
	}
}

?>