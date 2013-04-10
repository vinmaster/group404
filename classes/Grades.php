<?php

class Grades {
	public $id;
	public $term;
	public $student_id;
	public $class_id;
	public $class_name;
	public $grade;
	public $seat;
	public $list_id;

	public function setValue($t, $s, $ci, $cn, $g, $s, $d) {
		// $this->id = $i;
		$this->term = $t;
		$this->student_id = $s;
		$this->class_id = $ci;
		$this->class_name = $cn;
		$this->grade = $g;
		$this->seat = $s;
		$this->list_id = $d;
	}
}

?>