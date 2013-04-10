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
					<div class="span3 offset2"><h1>Students<h1></div>
					<div class="form-horizontal">
					</div>
				</div>
			</div>
		</div>
		<form>
			<div class="container fluid">
				<div class="row-fluid">
					<div class="span10">
						<div id="studentTableDiv">
							<script>listStudents();</script>
						</div>
				</div>
			</div>
		</div>
		</form>
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