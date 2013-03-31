<?php
// Alternative to __autoload
// set_include_path ( "./classes" );
// spl_autoload_register ();

// Auto load the classes needed
function __autoload($classname) {
    $filename = "./classes/". $classname .".php";
    include_once($filename);
}

// Check to see if user is already logged in
if (Auth::isLoggedIn()) {
  // Direct to dashboard
  header( 'Location: dashboard.php' );
}

session_start();

// Tries to log user in after pressing the login button
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['commit'])) {
  if ($_POST['commit'] === 'Login') {

    $username = $_POST['login'];
    $password = $_POST['password'];

    if (Auth::authenticate($username.'='.md5($password))) {
      if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
        // Set cookie for 1 year
        setcookie("login", $username."=".md5($password), time() + 86400 * 365);
        printf("<h1>Login successful</h1>");
      } else {
        $_SESSION['login'] = $username."=".md5($password);
        printf("<h1>Login successful</h1>");
      }
      echo '<a href="dashboard.php">Go to dashboard</a>';
    } else {
      printf("<h1>Access Denied</h1>");
      exit();
    }
    printf('cookie: '.$_COOKIE['login'].'<br>');
    printf('session: '.$_SESSION['login'].'<br>');
  }
}

// User is not logged in and did not submit a post request, let them sign in
else {

?>


<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login</h1>
      <form method="post" action="index.php">
        <p><input type="text" name="login" value="" placeholder="Username or Email"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="index.html">Click here to reset it</a>.</p>
    </div>
  </section>

  <section class="about">
    <p class="about-links">
      <a href="http://www.cssflow.com/snippets/login-form" target="_parent">View Article</a>
      <a href="http://www.cssflow.com/snippets/login-form.zip" target="_parent">Download</a>
    </p>
    <p class="about-author">
      &copy; 2012&ndash;2013 <a href="http://thibaut.me" target="_blank">Thibaut Courouble</a> -
      <a href="http://www.cssflow.com/mit-license" target="_blank">MIT License</a><br>
      Original PSD by <a href="http://www.premiumpixels.com/freebies/clean-simple-login-form-psd/" target="_blank">Orman Clark</a>
  </section>
</body>
</html>


<?php

}

?>