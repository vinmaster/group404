<?php
$page_title = 'Curriculum Tab';
$page_script = 'curriculumTab.js';
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

<h3>Curriculum</h3>
<div>
	<p>
	paragraph here
	</p>
	<form id="curriculumForm">
		Year
		<select id="year" name='year' onchange="curriculumChange(this)">
			<option value='Year'>Year</option>
			<option value='2012'>2012</option>
			<option value='2013'>2013</option>
		</select>
		Quarter
		<select id="quarter" name='quarter' onchange="curriculumChange(this)">
			<option value='Quarter'>Quarter</option>
			<option value='Fall'>Fall</option>
			<option value='Winter'>Winter</option>
			<option value='Spring'>Spring</option>
			<option value='Summer'>Summer</option>
		</select>
	</form>
	<div id="curriculumTableDiv">
	</div>
</div>

<?php 

include('php/footer.php');

}

?>