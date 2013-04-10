<?php
$page_title = 'Import Curriculum';
$page_script = 'import.js';
$page_redirect = 'index.php';

function __autoload($classname) {
    $filename = "./classes/". $classname .".php";
    include_once($filename);
}

if (!Auth::isLoggedIn()) {
  header( 'Location: '.$page_redirect );
} else {

include('php/header.php');

  if( isset($_FILES["file"]) ){
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
  } else{

?>



<div id="test" class="span10 offset1">
	<h3>Import Curriculum</h3>
		<form action="import.php" method="post" enctype="multipart/form-data">
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
		</form>
		
	<p>
		import by URL
	</p>
</div>

<?php 

include('php/footer.php');
  }
}

?>