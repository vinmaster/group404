<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title ?></title>
  <!-- <link rel="stylesheet" href="css/styles.css"> -->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css"/>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <?php
  if (isset($page_script)) {
    echo '<script type="text/javascript" src="../js/'.$page_script.'"></script>';
  }
  ?>
</head>
<body>

  <div class="navbar navbar-static">
    <div class="container">
      <div class="row-fluid">
        <div class="span10 offset1">
          <div class="navbar-inner">
            <a class="brand" href="#">group404</a>
            <ul class="nav">
              <li class=""><a href="dashboard.php">Dashboard</a></li>
              <li class="" id="curriculum-nav"><a href="curriculumTab.php">Curriculum</a></li>
              <li class="" id="student-nav"><a href="studentTab.php">Student</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings</a>
                <ul class="dropdown-menu">
                  <li><a href="#">Import from file</a></li>
                  <li><a href="#">Import from external URL</a></li>
                  <li class="divider"></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>
              </li>
              <li class=""><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>