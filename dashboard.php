<?php

$page_title = 'Dashboard';
// $page_script = 'curriculumTab.js';
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

<a href="logout.php">Logout</a>
<a href="curriculumTab.php">Curriculum Tab</a>
<a href="studentTab.php">Student Tab</a>

<?php

include('php/footer.php');

}

?>
