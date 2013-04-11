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
<script>
	$(document).ready(function() {
		$('.table > tr').click(function() {
			// row is clicked
			console.log('row clicked');
		});
	});
	function rowSelect(btn) {
		if (btn.value === "Select") {
			var row = btn.parentNode.parentNode;
			$(row).addClass("success");
			btn.value = "Unselect";
			$(btn).removeClass("btn-info");
			$(btn).addClass("btn-danger");
		} else if (btn.value === "Unselect") {
			var row = btn.parentNode.parentNode;
			$(row).removeClass("success");
			btn.value = "Select";
			$(btn).removeClass("btn-danger");
			$(btn).addClass("btn-info");
		}
	}
</script>
<div>
	<div class="well">
		<div class="container">
			<div class="row-fluid">
				<div class="span3 offset1"><h1>Students<h1>
				</div>
				<div class="form-horizontal">
					<label>Choose the student list to display:</label>
					<div>
						<select id="list" name='list'>
							<option value='ID'>ID</option>
						</select>
						<button class='btn btn-primary' type="button" onclick="chooseStudentList()">Go</button>
					</div>
				</div>
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
					<a data-toggle="tab" href="#pie1">Pie chart of student years</a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#stat">Student Statistics</a>
				</li>
			</ul>

			<div class="tab-content">
				<div id="table" class="tab-pane active">
					<div class="span10" id="old_table_div">

					</div>
				</div>
				<div id="pie1" class="tab-pane">
					
				</div>
				<div id="stat" class="tab-pane">
					
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="myModalLabel">Student Detail</h3>
	</div>
	<div class="modal-body">
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
<?php 

include('php/footer.php');

}

?>