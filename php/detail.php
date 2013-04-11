<?php

$id = $_GET['id'];
// echo "Curriculum id is $id";

include_once("../classes/MyPDO.php");
$db = MyPDO::getDb();
$str = "SELECT * FROM `curriculum`";
$str .= "WHERE `id` = :id ";
$query = $db->prepare($str);
$query->bindParam(':id', $id);
$query->execute();
$result = $query->fetchALL(PDO::FETCH_ASSOC);
$json = array();
$row = $result[0];

echo "<h1>Class name: " . $row['classname'] ."</h1>";
echo "<table class='table table-striped'>";
echo "<tr><td>Curriculum for: </td><td>"."Computer Science"."</td></tr>";
echo "<tr><td>Curriculum year: </td><td>".$row['year']."</td></tr>";
echo "<tr><td>Units: </td><td>".$row['units']."</td></tr>";
echo "<tr><td>Prerequisites: </td><td>".$row['prerequisites']."</td></tr>";
echo "<tr><td>Corequisites: </td><td>".$row['corequisites']."</td></tr>";
echo "</table>";

/*
echo "<form class='form-horizontal'>";
echo "<fieldset>";
echo "<h3>".$row['classname']."</h3>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Curriculum for:</label>";
echo "<div class='controls'>";
echo "<p>Computer Science</p>";
echo "<p class='help-block'></p>";
echo "</div>";
echo "</div>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Curriculum year:</label>";
echo "<div class='controls'>";
echo "<p>".$row['year']."</p>";
echo "<p class='help-block'></p>";
echo "</div>";
echo "</div>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Units:</label>";
echo "<div class='controls'>";
echo "<p>".$row['units']."</p>";
echo "<p class='help-block'></p>";
echo "</div>";
echo "</div>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Prerequisites:</label>";
echo "<div class='controls'>";
echo "<p>".$row['prerequisites']."</p>";
echo "<p class='help-block'></p>";
echo "</div>";
echo "</div>";

echo "<div class='control-group'>";
echo "<label class='control-label'>Corequisites:</label>";
echo "<div class='controls'>";
echo "<p>".$row['corequisites']."</p>";
echo "<p class='help-block'></p>";
echo "</div>";
echo "</div>";
*/

?>