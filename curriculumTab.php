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

<div class="well">
	<div class="container">
		<div class="row-fluid">
			<div class="span3 offset1"><h1>Curriculum<h1></div>
			<div class="form-horizontal">
				<form id="curriculumForm">
					<label>Choose the curriculum to list:</label>
					Year
					<select id="year" name='year' onchange="curriculumChange(this)">
						<option value='Year'>Year</option>
						<option value='2012'>2012</option>
						<option value='2013'>2013</option>
					</select>
					Major
					<select id="major" name='major' onchange="curriculumChange(this)">
						<option value='Major'>Major</option>
						<option value='Computer Science'>Computer Science</option>
					</select>
				</form>
				
			</div>
		</div>
	</div>
</div>



<div class="container fluid">
	<div class="row-fluid">
		<div class="tabbable">
			<ul class="nav nav-tabs" id="myTabs">
				<li class="active">
					<a data-toggle="tab" href="#table">Table</a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#graph">Graph</a>
				</li>
			</ul>

			<div class="tab-content">
				<div id="table" class="tab-pane active">
					<div class="span10" id="curriculumTableDiv">

					</div>
				</div>
				<div id="graph" class="tab-pane">
					Put some graph stuff here
				</div>
			</div>
		</div>
	</div>
</div>

<?php 

include('php/footer.php');

}

?>