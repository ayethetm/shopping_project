
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Neko Shop</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <?php 
        $link = $_SERVER['PHP_SELF'];
        $linkarray = explode('/',$link); // change into array 
        $page = end($linkarray);
    ?>

    <?php 
      if (($page != 'order_list.php') && ($page != 'order_detail.php')){ ?>
         <form class="form-inline ml-3" method="POST" 
      <?php if ($page == 'index.php') : ?> 
        action="index.php"
      <?php elseif ($page == 'categories.php'):?>  
        action="categories.php"
      <?php elseif ($page == 'users.php'): ?>  
      action="users.php"
      <?php endif; ?>>
      <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
        <div class="input-group input-group-sm">
          <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
      <?php } ?>
    
      <div class="container">
        <a href="logout.php" type="button" class="ml-auto btn btn-danger">Logout</a>
      </div>
  </nav>
  <!-- /.navbar -->