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
			var tableHeader = '<tr><th>Class ID</th><th>Units</th><th>Prerequisites</th><th>Companion Class</th></tr>';
			table = $('<table border="1" id="curriculumTable">'+tableHeader+'</table>');
			$('#curriculumTableDiv').append(table);
		}
		console.log(data);
		// console.log(JSON.stringify(data));
		// Add data to table
		var tableData = '';
		$.each(data, function(index) {
			tableData += '<tr>';
			tableData += '<td>'+data[index].class+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
			tableData += '<td>'+data[index].prerequisites+'</td>';
			tableData += '<td>'+data[index].corequisites+'</td>';
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