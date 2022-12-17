<?php

session_start();
require '../config/config.php';
require '../config/common.php';

//check whether user is logged in or not
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location:login.php');
}
if ($_SESSION['role'] != 1) {
  header('Location:login.php');
}


if ($_POST) 
{
  //fetch get data by $_GET id
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id='.$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();

  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['address']) || empty($_POST['phone']))
  {
    if (empty($_POST['name']))
    {
      $nameError = 'Username cannot be null';
    }
    if (empty($_POST['email']))
    {
      $emailError = 'Email cannot be null';
    }
    if (empty($_POST['address']))
    {
      $addressError = 'Address cannot be null';
    }
    if (empty($_POST['phone']))
    {
      $phoneError = 'Phone cannot be null';
    }
     
  }
  
    elseif (!empty($_POST['password']) && strlen($_POST['password']) < 4)
    {
      $passwordError = 'Password must be 4 characters at least.';
    }
    
  
  else
  {
    //ACCEPT POST REQUEST DATA
   $id = $_POST['id'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $phone = $_POST['phone'];
   $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
   $role = $_POST['role'];

    //FIRST, check EMAIL exists or not in table
    $statement = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    $statement->execute(array('email'=>$email,'id'=>$id));
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) 
    {
      echo '<script>alert("Email address is already taken");</script>';
    }
    else
    {
      if ($password != null) 
      {
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',address='$address',phone='$phone',password='$password',role='$role' WHERE id='$id' ") ;
      }
      else{
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',address='$address',phone='$phone',role='$role' WHERE id='$id' ") ;
      }
        $result = $stmt->execute();
    
        if($result)
            {
                    echo '<script>alert("Successfully updated !");window.location.href="users.php";</script>';
            }
      }
    }
} 
else{
    
    //fetch get data by $_GET id
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id='.$_GET['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();
}

?>

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
    
      <form class="form-inline ml-3" method="POST" action="index.php">
        <div class="input-group input-group-sm">
          <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
      <div class="container">
        <a href="logout.php" type="button" class="ml-auto btn btn-danger">Logout</a>
      </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Neko Shop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="categories.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="users.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Edit User Data</h3>
                </div>
                <div class="card-body">
                  <form method="POST" action="">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                <p style="color:red;"><?php echo empty($nameError)? '' : '*'.$nameError ?></p>
                    <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" 
                    value="<?php echo escape($result[0]['name']) ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-user"></span>
                        </div>
                    </div>
                    </div>
                    <p style="color:red;"><?php echo empty($emailError)? '' : '*'.$emailError ?></p>
                    <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                    value="<?php echo escape($result[0]['email']) ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div> 
                    </div>
                    <p style="color:red;"><?php echo empty($passwordError)? '' : '*'.$passwordError ?></p>
                    <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                      <input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo escape($result[0]['address']) ?>">
                      <div class="input-group-append">
                          <div class="input-group-text">
                          <span class="fas fa-home"></span>
                          </div>
                      </div>
                      </div>
                      <div class="input-group mb-3">
                      <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo escape($result[0]['phone']) ?>">
                      <div class="input-group-append">
                          <div class="input-group-text">
                          <span class="fas fa-phone"></span>
                          </div>
                      </div>
                      </div>
                    <div class="form-group mb-3">
                        <select id="role" class="form-control" name="role">
                            <option selected>Current selected role (
                              <?php if ($result[0]['role'] == 1) {
                                echo 'Admin';
                            } else { echo 'Normal User' ; }?> )</option>
                            <option value="1">Admin</option>
                            <option value="0">Normal User</option>
                        </select>
                    </div>
                    <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                    <div class="col-6">
                        <a href="users.php" type="button" class="btn btn-secondary btn-block">Cancel</a>
                    </div>
                    </div>
                </form>
              </div>
            </div>
            </div>
        </div>
            
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="#">AdminLTE.io</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
