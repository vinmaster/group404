<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

class StudentList {
	private $db;
	private $table;

	public function __construct() {
		$this->db = MyPDO::getDb();

		// Query string
		$str = "SELECT * FROM student ";
		$query = $this->db->prepare($str);
		$query->execute();

		//create an array of Student objects
		$this->table = $query->fetchAll(PDO::FETCH_CLASS, "Student");
	}

	public function toJSON() {
		return json_encode($this->table);
	}
}

?>