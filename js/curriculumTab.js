
// This function is called after changing the dropdown list selection in curriculumTab page
function curriculumChange(select) {
	console.log('curriculum change');
	// Turn the form into a post request format by the name
	// e.g. year=2012&major=Computer+Science
	var postData = $("#curriculumForm").serialize();

	// Added for json.php to check the right database
	postData = postData+'&request=curriculum';
	// console.log('send: '+postData);
	// Issue an ajax request using the post method instead of get
	// json.php will return a database result in json format into data
	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		var table;
		// Check if table already exist
		if ($("#curriculumTable").length > 0) {
			// console.log('table exist');
			table = $("#curriculumTable");
			// Remove everything except row 0, which is the table headers
			table.find("tr:gt(0)").remove();
		} else {
			// Create a new table
			// console.log('creating new table');
			var colArray=["ID", "Class ID", "Units", "Prerequisites", "Companion", "Select", "Detail"];
			var tableHeader = '<tr><th>'+colArray.join("</th><th>")+'</th></tr>';
			table = $('<table id="curriculumTable" class="table table-striped">'+tableHeader+'</table>');
			$('#curriculumTableDiv').append(table);
		}
		// console.log(data);
		// Generate string with html formatting to display the data
		var tableData = '';
		$.each(data, function(index) {
			tableData += '<tr>';
			tableData += '<td>'+data[index].id+'</td>';
			tableData += '<td>'+data[index].classname+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
			tableData += '<td>'+data[index].prerequisites+'</td>';
			tableData += '<td>'+data[index].corequisites+'</td>';
			tableData += '<td><input type="button" class="btn btn-info" onClick="rowSelect(this)" value="Select"/></td>';
			tableData += '<td><a class="btn btn-warning" href="../php/detail.php?id='+data[index].id+'" data-target="#myModal" data-toggle="modal">View</a></td>';
			tableData += '</tr>';
		});
		// Add the rows with data to the table
		table.append(tableData);
	});
	postRequest.fail(function() {
		// If the ajax request failed
		console.log('Failed');
		// Check if table already exist
		if ($("#curriculumTable").length > 0) {
			console.log('table exist');
			table = $("#curriculumTable");
			// Remove everything except row 0, which is the table headers
			table.find("tr:gt(0)").remove();
		}
	});
}

// This highlights the row when you push the select button and change the text
function rowSelect(btn) {
	// btn is the Select button
	if (btn.value === "Select") {
		// Fetch the table row that the button is in
		var row = btn.parentNode.parentNode;
		// Bootstrap way to highlight a row. addClass add the class to tag
		$(row).addClass("success");
		// Change button text
		btn.value = "Unselect";
		// Remove old button color
		$(btn).removeClass("btn-info");
		// Add button color
		$(btn).addClass("btn-danger");
	} else if (btn.value === "Unselect") {
		var row = btn.parentNode.parentNode;
		$(row).removeClass("success");
		btn.value = "Select";
		$(btn).removeClass("btn-danger");
		$(btn).addClass("btn-info");
	}
}

// Called when the html document is finished loading
$(document).ready(function() {
	// Engrave the Curriculum at the navigation bar
	$("#curriculum-nav").addClass("active");

	// Enable tab functionality for Table and Graph tabs
	$('#myTabs').tab();

	// Load content into modal for detail view
	$("a[data-toggle=modal]").click(function (e) {
		var target = $(this).attr('data-target');
		var url = $(this).attr('href');
		$(target).load(url);
	});

	// Make sure to remove old modal or else modal uses the same content each time
	$('#myModal').on('hidden', function () {
	  $(this).removeData('modal');
	});
});