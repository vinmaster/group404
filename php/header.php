<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title ?></title>
  <!-- <link rel="stylesheet" href="css/styles.css"> -->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <?php
  if (isset($page_script)) {
    echo '<script type="text/javascript" src="../js/'.$page_script.'"></script>';
  }
  ?>
</head>
<body>