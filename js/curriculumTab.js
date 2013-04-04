function curriculumChange(select) {
	console.log('curriculum change');
	var postData = $("#curriculumForm").serialize();
	// $.post("php/json.php", $postData, function(data, status) {
	// 	console.log(status);
	// 	console.log(data);
	// }, "json");
	postData = postData+'&request=curriculum';
	console.log('send: '+postData);
	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		var table;
		// Check if table already exist
		if ($("#curriculumTable").length > 0) {
			console.log('table exist');
			table = $("#curriculumTable")
			table.find("tr:gt(0)").remove();
		} else {
			// Create a new table
			console.log('creating new table');
			var colArray=["Class ID", "Units", "Prerequisites", "Companion", "Select", "Detail"];
			var tableHeader = '<tr><th>'+colArray.join("</th><th>")+'</th></tr>';
			table = $('<table id="curriculumTable" class="table table-striped">'+tableHeader+'</table>');
			$('#curriculumTableDiv').append(table);
		}
		console.log(data);
		// console.log(JSON.stringify(data));
		// Add data to table
		var tableData = '';
		$.each(data, function(index) {
			tableData += '<tr>';
			tableData += '<td>'+data[index].classname+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
			tableData += '<td>'+data[index].prerequisites+'</td>';
			tableData += '<td>'+data[index].corequisites+'</td>';
			tableData += '<td><input type="button" class="btn btn-info" onClick="rowSelect(this)" value="Select"/></td>';
			tableData += '<td><button class="btn btn-warning" data-toggle="modal">View</button></td>';
			tableData += '</tr>';
		});
		table.append(tableData);
	});
	postRequest.fail(function() {
		console.log('Failed');
		// Check if table already exist
		if ($("#curriculumTable").length > 0) {
			console.log('table exist');
			table = $("#curriculumTable")
			table.find("tr:gt(0)").remove();
		}
	});
}

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

$(document).ready(function() {
	$("#curriculum-nav").addClass("active");
	$('#myTabs').tab();
});