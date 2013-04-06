<?php
$page_title = 'Student Tab';
$page_script = 'studentTab.js';
$page_redirect = 'index.php';

function __autoload($classname) {
    $filename = "./classes/". $classname .".php";
    include_once($filename);
}

if (!Auth::isLoggedIn()) {
  header( 'Location: '.$page_redirect );
} else {

include('php/header.php');

?>

<h3>Student</h3>
<div>
	<p>
	Put stuff here
	</p>
	<div id="studentTableDiv">
	</div>
	<button type="button" onclick="listStudents()">List Students</button>
</div>

<?php 

include('php/footer.php');

}

?>