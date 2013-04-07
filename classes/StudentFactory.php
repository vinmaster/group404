<?php

class StudentFactory {
	private $db;
	private $curriculum_table;
	private $curriculum_tree;

	public function __construct($major_id, $year) {
		$this->db = MyPDO::getDb();

		// Query string
		$str = "SELECT * FROM curriculum ";
		$str .= "WHERE major_id = '$major_id' AND year = '$year' ";
		$query = $this->db->prepare($str);
		$query->execute();

		//create an array of Curriculum objects
		$this->curriculum_table = $query->fetchAll(PDO::FETCH_CLASS, "Curriculum");
		$this->curriculum_tree = new CurriculumNode("root");

		// Put all the classes with no prereq into tree
		foreach ($this->curriculum_table as $key => $row) {

			if ($row->prerequisites === '') {
				$this->curriculum_tree->addChildren(new CurriculumNode($row));
				unset($this->curriculum_table[$key]);
			}
		}

		// Connect the classes with the prereq needed
		$unvisited = $this->curriculum_tree->children;
		foreach ($unvisited as $node) {

		}
		// foreach ($this->curriculum_table as $key => $row) {
		// 	$unvisited = $this->curriculum_tree->children;
		// 	$new_node = new CurriculumNode($row);
		// 	foreach ($unvisited as $course) {
		// 		if ($new_node->prerequisites === $course->classname) {
		// 			$course->addChildren($new_node);
		// 		}
		// 		// Breath-first search
		// 		array_merge($unvisited, $course->children);
		// 	}
		// }
		print_r($this->curriculum_tree);
		$this->println("");
		$this->println("");
		print_r($this->curriculum_table);
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

	function println($s) {
		echo $s.'<br>';
	}
}

?>