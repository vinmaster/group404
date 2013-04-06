<?php
$page_title = 'Generate Students';
// $page_script = 'studentTab.js';
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

<h3>Generate Students</h3>
<div>
	<p>
		A drop down for different students table. Selecting one will display the students
	</p>
	<p>
		A button to generate students and able to save to database
	</p>
</div>

<?php 

include('php/footer.php');

}

?>