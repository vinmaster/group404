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
			var colArray=["Student ID", "Name", "Enroll Year", "Enroll Quarter", "GPA", "Units", "Detail"];
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
			tableData += '<td>'+data[index].gpa+'</td>';
			tableData += '<td>'+data[index].units+'</td>';
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
		var colArray=["ID", "Major ID", "KSU Name", "Name", "Enroll Term", "Enroll Year", "Enroll Quarter", "Dropout", "GPA", "Units", "List ID", "Detail"];
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
			tableData += '<td><a class="btn btn-warning" href="../php/studentsTabDetail.php?id='+data[index].id+'" data-target="#myModal" data-toggle="modal">View</a></td>';
			tableData += '</tr>';
		});
		table.append(tableData);
	});
	postRequest.fail(function() {
		if ($("#old_table").length > 0) {
			$("#old_table").remove();
		}
	});

	// Fill pie chart
	var width = 960,
	    height = 500,
	    radius = Math.min(width, height) / 2;

	var color = d3.scale.ordinal()
	    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

	var arc = d3.svg.arc()
	    .outerRadius(radius - 10)
	    .innerRadius(0);

	var pie = d3.layout.pie()
	    .sort(null)
	    .value(function(d) { return d.population; });

	var svg = d3.select("#pie1").append("svg")
	    .attr("width", width)
	    .attr("height", height)
	  .append("g")
	    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

	d3.csv("php/csv.php?request=studentsYearPie", function(error, data) {
	  console.log("---"+data);
	  
	  data.forEach(function(d) {
	    d.population = +d.population;
	  });

	  var g = svg.selectAll(".arc")
	      .data(pie(data))
	    .enter().append("g")
	      .attr("class", "arc");

	  g.append("path")
	      .attr("d", arc)
	      .style("fill", function(d) { return color(d.data.years); });

	  g.append("text")
	      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
	      .attr("dy", ".35em")
	      .style("text-anchor", "middle")
	      .text(function(d) { return d.data.years; });

	});

	// --------------Donut chart 1
	// var width = 960,
	//     height = 500,
	//     radius = Math.min(width, height) / 2;

	// var color = d3.scale.ordinal()
	//     .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

	// var arc = d3.svg.arc()
	//     .outerRadius(radius - 10)
	//     .innerRadius(radius - 70);

	// var pie = d3.layout.pie()
	//     .sort(null)
	//     .value(function(d) { return d.population; });

	// var svg = d3.select("#pie1").append("svg")
	//     .attr("width", width)
	//     .attr("height", height)
	//   .append("g")
	//     .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

	// d3.csv("csv.php?request=studentsLeft", function(error, data) {

	//   data.forEach(function(d) {
	//     d.population = +d.population;
	//   });

	//   var g = svg.selectAll(".arc")
	//       .data(pie(data))
	//     .enter().append("g")
	//       .attr("class", "arc");

	//   g.append("path")
	//       .attr("d", arc)
	//       .style("fill", function(d) { return color(d.data.age); });

	//   g.append("text")
	//       .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
	//       .attr("dy", ".35em")
	//       .style("text-anchor", "middle")
	//       .text(function(d) { return d.data.age; });

	// });

	// Load statistics
	// postData from last request
	var index = postData.indexOf('&');
	postData = postData.substring(0, index);
	postData += "&request=studentStats";
	console.log('stats = '+postData);
	var postRequest = $.post("php/json.php", postData);
	postRequest.done(function(data) {
		var output = '';
		output += "<table id='stat_table' class='table table-striped'>";
		output += "<tr><td>Average remaining units to graduate: </td><td>"+data['avgRemaining']+"</td></tr>";
		output += "<tr><td>Average units taken: </td><td>"+data['avgTaken']+"</td></tr>";
		output += "<tr><td>Maximum units total: </td><td>"+data['maxUnits']+"</td></tr>";
		output += "<tr><td>Minimum units total: </td><td>"+data['minUnits']+"</td></tr>";
		output += "<tr><td>Number of Undergrad students: </td><td>"+data['students']+"</td></tr>";
		output += "<tr><td>Number of Graduate students: </td><td>"+data['grad']+"</td></tr>";
		output += "</table>";
		$("#stat").html(output);
	});
}

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

	// Populate dropdown
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