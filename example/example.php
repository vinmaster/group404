<?php

$filename = '../data/ITC 2013 Programming Case Study Data Set.txt';
$tsvData = file_get_contents($filename);
$tsvDelim = "\t";

function __autoload($classname) {
    $filename = "../classes/" .$classname .".php";
    include_once($filename);
}
$db = MyPDO::getDb();
// Split the table into rows
$rows = explode("\n", $tsvData);

echo '<head><link rel="stylesheet" href="../css/table.css"></head>';
echo '<table border="1" cellpadding="0" cellspacing="0" class="mytable">'."\n";

foreach ($rows as $i => $row) {
	echo "<tr>";
	// Add table header with the first row
	$sql_insert = "INSERT INTO `curriculum` (`major_id`, `year`, `classname`, `units`, `prerequisites`, `corequisites`) ";
	$sql_insert .= "VALUES ( ";
	$sql_insert .= '1' .", ";
	$sql_insert .= '2013' .", ";
	if ($i == 0) {
		// Split each row by tabs
		$data = str_getcsv($row, $tsvDelim);
		// $data = preg_split("/[\t]/", $row);
		foreach ($data as $colname) {
			echo "<th>$colname</th>";
		}
		
	} else {
		$data = str_getcsv($row, $tsvDelim);
		// foreach ($data as $key => $cell) {
		for ($i = 0; $i < 4; $i++) {
			// if (strlen($data[$i]) === 0) {
			// 	$data[$i] = "''";
			// }
			if (strlen($data[0]) === 0) {
				break;
			}
			echo "<td>$data[$i]</td>";
			// echo $key;
			// if($cell == end($data))
			// {
			// 	$sql_insert .= $cell;
			// 	$sql_insert .= ")";
			// }
			// else {
			// 	$sql_insert .= $cell;
			// 	$sql_insert .= ", ";
			// }
			
			if ($i === 3) {
				$sql_insert .= "'".$data[$i]."')";
			} else {
				$sql_insert .= "'".$data[$i]."', ";
			}
		}
		// echo $sql_insert;
		$query = $db->prepare($sql_insert);
		$result=$query->execute();
	}
	echo "</tr>"."\n";
}

echo "</table><br>";

//insert statement is below this
/*$db = MyPDO::getDb();

foreach ($rows as $i => $row) {
	// Add table header with the first row
	$sql_ins = "INSERT INTO 'curriculum' (`major_id`, `year`, `classname`, `units`, `prerequisites`, `corequisites`)";
	$sql_ins .= "VALUES ( ";
	$sql_ins .= 1 .", ";
	$sql_ins .= 2013 .", ";
	if ($i == 0) {
		//dont get the titles first
	} else {
		$data = str_getcsv($row, $tsvDelim);
		foreach ($data as $cell) {
			if($cell == end($data))
			{
				$sql_insert .= $cell .")";
			}
			else {
				$sql_insert .= $cell .", ";
			}
		}
		echo $sql_ins;
		$query = $db->prepare($str);
		$result=$query->execute();
		$db->commit();
	}
}*/
?>
