<?php

class Student {
	public $id;
	public $major_id;
	public $ksu_name;
	public $name;
	public $enroll_term;
	public $enroll_year;
	public $enroll_quarter;
	public $dropout;
	public $gpa;
	public $units;
	public $list_id;

	public function setValue($i, $m, $k, $n, $et, $ey, $eq, $d, $g, $u, $l) {
		$this->id = $i;
		$this->major_id = $m;
		$this->ksu_name = $k;
		$this->name = $n;
		$this->enroll_term = $et;
		$this->enroll_year = $ey;
		$this->enroll_quarter = $eq;
		$this->dropout = $d;
		$this->gpa = $g;
		$this->units = $u;
		$this->list_id = $l;
	}
}

?>