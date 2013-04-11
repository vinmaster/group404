function chooseStudentList() {
	var postData = $("#list").serialize();
	postData = postData + '&request=studentlist';

	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		console.log('success');
		if ($("#old_table").length > 0) {
			$("#old_table").remove();
		}
		var table;
		var colArray=["ID", "Major ID", "KSU Name", "Name", "Enroll Term", "Enroll Year", "Enroll Quarter", "Dropout", "GPA", "Units", "List ID"];
		var tableHeader = '<tr><th>'+colArray.join("</th><th>")+'</th></tr>';
		table = $('<table id="old_table" class="table table-striped">'+tableHeader+'</table>');
		$("#old_table_div").append(table);

		var tableData = '';
		$.each(data, function(index) {
			tableData += '<tr>';
			tableData += '<td>'+data[index].id+'</td>';
			tableData += '<td>'+data[index].major_id+'</td>';
			tableData += '<td>'+data[index].ksu_name+'</td>';
			tableData += '<td>'+data[index].name+'</td>';
			tableData += '<td>'+data[index].enroll_term+'</td>';
			tableData += '<td>'+data[index].enroll_year+'</td>';
			tableData += '<td>'+data[index].enroll_quarter+'</td>';
			tableData += '<td>'+data[index].dropout+'</td>';
			tableData += '<td>'+data[index].gpa+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
			tableData += '<td>'+data[index].list_id+'</td>';
			tableData += '</tr>';
		});
		table.append(tableData);
	});
	postRequest.fail(function() {
		if ($("#old_table").length > 0) {
			$("#old_table").remove();
		}
	});
}

function generate() {
	var getData = $("#gen_form").serialize();
	console.log('getData: '+getData);
	$.get("php/generate.php?"+getData).done(function(data) {
		$("#gen_button").remove();
		$("#generate").html(data);

	}).fail(function() {
		console.log('failed');
	});
}

function delete_button() {
	var list_id = $("#list_id").html();
	$.get("php/generate.php?delete="+list_id).done(function(data) {
		var str = "<input type='button' id='gen_button' class='btn btn-info' onClick='generate()' value='Generate'/>";
		str += "<label>Max students</label>";
		str += "<input name='max_students' type='text' placeholder='Default is 10'>";
		str += "<label>Starting ID</label>";
		str += "<input name='starting_id' type='text' placeholder='ID of the first student'>";
		str += "<label>Which curriculum these students have enrolled for</label>";
		str += "<select name='class_limit'>";
		str += "<option value='-1'>No Limit</option>";
		str += "<option value='1'>Freshman Courses</option>";
		str += "<option value='2'>Sophomore Courses</option>";
		str += "<option value='3'>Junior Courses</option>";
		str += "<option value='4'>Senior Courses</option>";
		str += "</select>";
		str += "<label>Percentage of dropout</label>";
		str += "<input name='dropout' type='text' placeholder='Default is 0'>";

		$("#generate").html(str);
		alert('Deleted');
	})
}

function save() {
	alert('Saved');
}

// Called when the html document is finished loading
$(document).ready(function() {
	// Engrave the Curriculum at the navigation bar
	// $("#settings-nav").addClass("active");
	postData = 'request=studentlist';

	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		console.log('success');
		$.each(data, function(index) {
			$("#list").append("<option value='"+data[index]+"'>"+data[index]+"</option>");
		})
	});
	postRequest.fail(function() {
		console.log('failed');
	});
});