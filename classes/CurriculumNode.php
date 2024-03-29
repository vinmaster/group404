<?php

// Represents a class in a curriculum tree
class CurriculumNode {
	public $id; // Class ID
	public $classname; // Classname
	public $units;
	public $prerequisites;
	public $corequisites;
	public $taken; // See if this class is taken
	public $children; // Children nodes

	public function __construct($row) {
		$this->id = $row->id;
		$this->classname = $row->classname;
		$this->units = $row->units;
		$this->prerequisites = $row->prerequisites;
		$this->corequisites = $row->corequisites;
		$this->taken = false;
		$this->children = array();
	}

	public function addChildren($node) {
		array_push($this->children, $node);
	}

	public function __toString() {
		return $this->classname;
	}
}

?>