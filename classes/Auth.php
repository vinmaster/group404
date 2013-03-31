<?php

class Auth {

	// Check credentials
	public static function authenticate($login) {
		list($username, $password) = explode("=", $login);

		$db = MyPDO::getDb();

		// Query string
		$query = $db->prepare("SELECT password FROM user WHERE username=:username");
		$query->bindParam(':username', $username);
		$query->execute();
		$result = $query->fetch();

		if($result && $result['password'] === $password) {
			return true;
		} else {
			return false;
		}
	}

	public static function isLoggedIn() {
		session_start();

		if (isset($_COOKIE['login'])) {
		  if (Auth::authenticate($_COOKIE['login'])) {
		    // Correct credientials
		    return true;
		  } else {
		    // Destroy invalid cookie
		    setcookie("login", "", time() - 60);
		    return false;
		  }
		} else if (isset($_SESSION['login'])) {
		  list($username, $password) = explode("=", $_SESSION['login']);

		  if (Auth::authenticate($_SESSION['login'])) {
		    // Correct credientials
		    return true;
		  } else {
		    // Destroy invalid session
		    unset($_SESSION['login']);
		    return false;
		  }
		}
		return false;
	}
}

?>