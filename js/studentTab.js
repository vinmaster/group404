function listStudents() {
	postData = 'request=student';
	console.log('send: '+postData);
	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		var table;
		// Check if table already exist
		if ($("#studentTable").length > 0) {
			console.log('table exist');
			table = $("#studentTable")
			table.find("tr:gt(0)").remove();
		} else {
			// Create a new table
			console.log('creating new table');
			var colArray=["Student ID", "Name", "Enroll Year", "Enroll Quarter", "Dropout", "GPA", "Units", "Type"];
			var tableHeader = '<tr><th>'+colArray.join("</th><th>")+'</th></tr>';
			table = $('<table class="table table-striped" id="studentTable">'+tableHeader+'</table>');
			$('#studentTableDiv').append(table);
		}
		console.log(data);
		// console.log(JSON.stringify(data));
		// Add data to table
		var tableData = '';
		$.each(data, function(index) {
			tableData += '<tr>';
			tableData += '<td>'+data[index].id+'</td>';
			tableData += '<td>'+data[index].name+'</td>';
			tableData += '<td>'+data[index].enroll_year+'</td>';
			tableData += '<td>'+data[index].enroll_quarter+'</td>';
			tableData += '<td>'+data[index].dropout+'</td>';
			tableData += '<td>'+data[index].gpa+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
			tableData += '<td>'+data[index].type+'</td>';
			tableData += '<td><a class="btn btn-warning" href="../php/studentsTabDetail.php?id='+data[index].id+'" data-target="#myModal" data-toggle="modal">View</a></td>';
			tableData += '</tr>';
		});
		table.append(tableData);
	});
	postRequest.fail(function() {
		console.log('Failed');
		// Check if table already exist
		if ($("#studentTable").length > 0) {
			console.log('table exist');
			table = $("#studentTable")
			table.find("tr:gt(0)").remove();
		}
	});
}

// Called when the html document is finished loading
$(document).ready(function() {
	// Engrave the student at the navigation bar
	$("#student-nav").addClass("active");
});
// Called when the html document is finished loading
$(document).ready(function() {
	// Engrave the Curriculum at the navigation bar
	$("#student-nav").addClass("active");
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