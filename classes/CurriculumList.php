<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

class CurriculumList {
	private $db;
	private $table;
	private $empty;

	// Constructor
	public function __construct($year, $major) {
		$this->empty = false;
		// Use the MyPDO class inside classes folder to connect to MySQL
		$this->db = MyPDO::getDb();

		// Query string
		$str = "SELECT id FROM `majors`";
		$str .= "WHERE major=:major";
		$query = $this->db->prepare($str);
		$query->bindParam(':major', $major);
		$query->execute();
		$majorArray = $query->fetchAll(PDO::FETCH_CLASS, "Major");

		// Continue only if major id is found from major name
		if (count($majorArray) === 0) {
			$this->empty = true;
		} else {
			// Get the major id
			$major_id = $majorArray[0]->id;

			// Query string
			$str = "SELECT * FROM curriculum ";
			$str .= "WHERE year=:year ";
			$str .= "AND major_id=:major_id ";
			$query = $this->db->prepare($str);
			$query->bindParam(':year', $year);
			$query->bindParam(':major_id', $major_id);
			$query->execute();
			
			//create an array of Curriculum objects
			$this->table = $query->fetchAll(PDO::FETCH_CLASS, "Curriculum");
			if (count($this->table) === 0) {
				// empty variable is checked before fetching json format of this table
				$this->empty = true;
			}
		}
	}

	// This is called to make sure result query is not empty
	public function isEmpty() {
		return $this->empty;
	}

	// Return result query in json format
	public function toJSON() {
		return json_encode($this->table);
	}
}

?>