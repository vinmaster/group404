

<?php
include_once("../classes/MyPDO.php");
$id = $_GET['id'];
$db = MyPDO::getDb();
$str = "SELECT * FROM `student`";
$str .= "WHERE id=:id";
$query = $db->prepare($str);
$query->bindParam(':id', $id);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$results=array(count($result));
$i=0;
foreach($result as $x)
{
	$results[$i]=$x;
	$i=$i+1;
}
$leftOver=(int)((229-$results[9])/20);
if((229-$results[9])%20!=0)
{
	$leftOver=$leftOver+1;
}
echo "<h1>Name: " . $results[3] ."</h1>";
echo "<table class='table table-striped'>";
echo "<tr><td>KSU Name </td><td>".$results[2]."</td></tr>";
echo "<tr><td>KSU Id </td><td>".$results[0]."</td></tr>";
echo "<tr><td>Enrollment Year </td><td>".$results[5]."</td></tr>";
echo "<tr><td>Enrollment Quarter </td><td>".$results[6]."</td></tr>";
echo "<tr><td>GPA </td><td>".$results[8]."</td></tr>";
echo "<tr><td>Units Completed </td><td>".$results[9]."</td></tr>";
echo "<tr><td>Quarters Left </td><td>".$leftOver."</td></tr>";
echo "</table>";

?>