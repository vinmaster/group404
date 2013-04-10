
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
			var colArray=["ID", "Class ID", "Units", "Prerequisites", "Companion", "Detail"];
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
			//tableData += '<td><input type="button" class="btn btn-info" onClick="rowSelect(this)" value="Select"/></td>';
			tableData += '<td><a class="btn btn-warning" href="../php/detail.php?id='+data[index].id+'" data-target="#myModal" data-toggle="modal">View</a></td>';
			tableData += '</tr>';
		});
		// Add the rows with data to the table
		table.append(tableData);

		// flow chart
		d3.json("../php/json.php?request=curriculumGraph&year=2012", function(data) {
		  var links = data;
		  var nodes = {};

		  // Compute the distinct nodes from the links.
		  links.forEach(function(link) {
		    link.source = nodes[link.source] || (nodes[link.source] = {name: link.source});
		    link.target = nodes[link.target] || (nodes[link.target] = {name: link.target});
		  });

		  var width = 960,
		      height = 960;

		  var force = d3.layout.force()
		      .nodes(d3.values(nodes))
		      .links(links)
		      .size([width, height])
		      .linkDistance(60)
		      .charge(-300)
		      .on("tick", tick)
		      .start();

		  var svg = d3.select("#flow").append("svg")
		      .attr("width", width)
		      .attr("height", height);

		  var link = svg.selectAll(".link")
		      .data(force.links())
		    .enter().append("line")
		      .attr("class", "link");

		  var node = svg.selectAll(".node")
		      .data(force.nodes())
		    .enter().append("g")
		      .attr("class", "node")
		      .on("mouseover", mouseover)
		      .on("mouseout", mouseout)
		      .call(force.drag);

		  node.append("circle")
		      .attr("r", 8);

		  node.append("text")
		      .attr("x", 12)
		      .attr("dy", ".35em")
		      .text(function(d) { return d.name; });

		  function tick() {
		    link
		        .attr("x1", function(d) { return d.source.x; })
		        .attr("y1", function(d) { return d.source.y; })
		        .attr("x2", function(d) { return d.target.x; })
		        .attr("y2", function(d) { return d.target.y; });

		    node
		        .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
		  }

		  function mouseover() {
		    d3.select(this).select("circle").transition()
		        .duration(750)
		        .attr("r", 16);
		  }

		  function mouseout() {
		    d3.select(this).select("circle").transition()
		        .duration(750)
		        .attr("r", 8);
		  }
		});
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