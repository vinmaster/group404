<?php
$page_title = 'Generate Students';
$page_script = 'students.js';
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
        <div class="span5 offset1">
          <h1>Generate Students<h1>
        </div>
      </div>
   </div>
</div>
<div class="container fluid">
	<div class="row-fluid span12">
		<div>
			<h3>View current student lists</h3>
			<select id="list" name='list'>
				<option value='ID'>ID</option>
			</select>
			<button class='btn btn-primary' type="button" onclick="chooseStudentList()">Go</button>
		</div>
		<div id='old_table_div'>

		</div>
		<h3>Generate Students</h3>
		
		<div id="generate">
			<form id='gen_form'>
				<input type='button' id='gen_button' class='btn btn-info' onClick='generate()' value='Generate'/>
				<label>Max students</label>
				<input name='max_students' type="text" placeholder='Default is 10'>
				<label>Starting ID</label>
				<input name='starting_id' type="text" placeholder='ID of the first student'>
				<label>Which curriculum these students have enrolled for</label>
				<select name='class_limit'>
					<option value='-1'>No Limit</option>
					<option value='1'>Freshman Courses</option>
					<option value='2'>Sophomore Courses</option>
					<option value='3'>Junior Courses</option>
					<option value='4'>Senior Courses</option>
				</select>
				<label>Percentage of dropout</label>
				<input name='dropout' type='text' placeholder='Default is 0'>
			</form>
		</div>
		
	</div>
</div>

<?php 

include('php/footer.php');

}

?>