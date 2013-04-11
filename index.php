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
  header( 'Location: classTab.php' );
}

session_start();

// Tries to log user in after pressing the login button
if (isset($_POST['login']) && isset($_POST['password'])) {

  $username = $_POST['login'];
  $password = $_POST['password'];

  if (Auth::authenticate($username.'='.md5($password))) {
    if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
      // Set cookie for 1 year
      setcookie("login", $username."=".md5($password), time() + 86400 * 365);
      // printf("<h1>Login successful</h1>");
    } else {
      $_SESSION['login'] = $username."=".md5($password);
      // printf("<h1>Login successful</h1>");
    }
    // echo '<a href="dashboard.php">Go to dashboard</a>';
  } else {
    printf("<h1>Access Denied</h1>");
	exit();
  }
  header( 'Location: dashboard.php' );
  // printf('cookie: '.$_COOKIE['login'].'<br>');
  // printf('session: '.$_SESSION['login'].'<br>');
}

// User is not logged in and did not submit a post request, let them sign in
else {

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in &middot; group404</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #999966;
		background-image:url('logo.png');
		background-repeat:repeat-x;
		background-attachment:fixed;
		background-position:left;
      }
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body> 
  <div class="well">
	<h1><center><strong>KSU Academic Success Planner</strong></center></h1>
  </div>
    <div class="container">
	<p></p>
      <form class="form-signin" method="post" action="index.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="login" class="input-block-level" placeholder="Username">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" name="remember_me" value="remember-me"> Remember me
        </label>
        <center><button class="btn btn-large btn-primary"  type="submit">Sign in</button></center>
      </form>
	 <p>
		<small>(c) 2013</small>
	</p>
    </div> <!-- /container -->

  </body>
</html>

<?php

}

?>