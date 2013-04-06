<?php

setcookie("login", "", time() - 60);

session_start();
session_destroy();
header('Location: index.php');
// echo '<a href="index.php">Home</a>';

?>