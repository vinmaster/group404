<?php

function __autoload($classname) {
    $filename = $classname .".php";
    include_once($filename);
}

// Represents a class in a curriculum tree
class CurriculumNode {
	public $id; // Class ID
	public $major_id;
	public $year;
	public $classname; // Classname
	public $units;
	public $prerequisites;
	public $corequisites;
	public $taken; // See if this class is taken
	public $children; // Children nodes

	public function __construct($row) {
		$this->id = $row['id'];
		$this->major_id = $row['major_id'];
		$this->year = $row['year'];
		$this->classname = $row['classname'];
		$this->units = $row['units'];
		$this->prerequisites = $row['prerequisites'];
		$this->corequisites = $row['corequisites'];
		$this->taken = false;
		$this->children = array();
	}

	public function addChildren($node) {
		array_push($this->children, $node);
	}
}

?>