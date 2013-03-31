<?php

$filename = '../data/ITC 2013 Programming Case Study Data Set.txt';
$tsvData = file_get_contents($filename);
$tsvDelim = "\t";

// Split the table into rows
$rows = explode("\n", $tsvData);

echo '<head><link rel="stylesheet" href="../css/table.css"></head>';
echo '<table border="1" cellpadding="0" cellspacing="0" class="mytable">'."\n";

foreach ($rows as $i => $row) {
	echo "<tr>";
	// Add table header with the first row
	if ($i == 0) {
		// Split each row by tabs
		$data = str_getcsv($row, $tsvDelim);
		// $data = preg_split("/[\t]/", $row);
		foreach ($data as $colname) {
			echo "<th>$colname</th>";
		}
		
	} else {
		$data = str_getcsv($row, $tsvDelim);
		foreach ($data as $cell) {
			echo "<td>$cell</td>";
		}
	}
	echo "</tr>"."\n";
}

echo "</table><br>";

?>