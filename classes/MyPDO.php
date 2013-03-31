<?php

class MyPDO {
	public static $hostname = "mysql.group404.com";
	public static $username = "yvho99";
	public static $password = "my404itcgroup";
	public static $database = "group404_scheduledb";

	// Create pdo object and send back for quering, return false if cannot connect
	public static function getDb() {
		$hostname = self::$hostname;
		$username = self::$username;
		$password = self::$password;
		$database = self::$database;

		try {
			$pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
		} catch (PDOException $e) {
			printf("Error!: " . $e->getMessage() . "<br/>");
			exit();
		}

		return $pdo;
	}
}

?>
