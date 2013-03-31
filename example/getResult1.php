<?php

$_GET['id'] = '24';
$_POST['name'] = 'Jack';
ob_start();
// Get result from another php file
require("getResult2.php");
$out = ob_get_clean();
echo $out;




// Another example
ob_start();

echo "Hello World";

$out = ob_get_clean();
$out = strtolower($out);

var_dump($out);

?>