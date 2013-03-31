<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

class CurriculumList {
	private $db;
	private $table;

	public function __construct($year, $quarter) {
		$this->db = MyPDO::getDb();

		// Query string
		$str = "SELECT * FROM curriculum ";
		$str .= "WHERE year=:year ";
		$str .= "AND quarter=:quarter";
		$query = $this->db->prepare($str);
		$query->bindParam(':year', $year);
		$query->bindParam(':quarter', $quarter);
		$query->execute();
		
		//create an array of Curriculum objects
		$this->table = $query->fetchAll(PDO::FETCH_CLASS, "Curriculum");
	}

	public function isEmpty() {
		return count($this->table) === 0;
	}

	public function toJSON() {
		return json_encode($this->table);
	}
}

?>