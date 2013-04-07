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

<div class="container fluid">
	<div class="row-fluid span12">
		<h3>Generate Students</h3>
		<?php
			$factory = new StudentFactory("1", "2012");

		?>
	</div>
</div>

<?php 

include('php/footer.php');

}

?>