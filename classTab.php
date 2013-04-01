<?php
$page_title = 'Class Schedule Tab';
$page_script = 'classTab.js';
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

<h3>Class</h3>
<div>
	<p>
		No class stuff yet
	</p>
</div>

<?php 

include('php/footer.php');

}

?>