<?php
$page_title = 'Import Curriculum';
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

<h3>Import Curriculum</h3>
<div>
	<p>
		import by local file system
	</p>
	<p>
		import by URL
	</p>
</div>

<?php 

include('php/footer.php');

}

?>