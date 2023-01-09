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

if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']);
    setcookie('search',null,-1,'/');
  }


?>
<?php include('header.php'); ?>

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
              <i class="nav-icon fas fa-tag"></i>
              <p>
                Products 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="categories.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
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
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
              <i class="nav-icon fas fa-list-ol"></i>
              <p>
                Orders List
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
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered mt-3">
                  <thead>                  
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Total Price</th>
                      <th>Order Date(Y/m/d)</th>
                      <th colspan="2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                        if (!empty($_GET['pageno'])) 
                        {
                        $pageno = $_GET['pageno'];
                        }
                        else
                        {
                        $pageno = 1;
                        }

                        $numOfrecs = 5; // number of records in one one page
                        $offset = ($pageno - 1) * $numOfrecs; // offset algorithm

                        
                        $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
                        $stmt->execute();
                        $rawResult = $stmt->fetchAll();

                        $total_pages = ceil(count($rawResult)/ $numOfrecs); //to get total pages

                        $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs");
                        $stmt->execute();
                        $result = $stmt->fetchAll();


                        if ($result) 
                        { 
                            $i = 1;
                            foreach ($result as $value) 
                            { ?>
                            <?php 
                               $userstmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                               $userstmt->execute();
                               $userResult = $userstmt->fetchAll();
                            ?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo escape($userResult[0]['name'])?>
                            <td><?php echo escape($value['total_price']) ?></td>
                            <td><?php echo escape(date('Y-m-d',strtotime($value['order_date']))) ?></td>
                            </td>
                            <td><a href="order_detail.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                            </td>
                            </tr>
                            <?php    
                            $i++;
                            }
                        }
                         
                    ?>
                  </tbody>
                </table>
                <br>
                <!-- for pageno navbar -->
                <!-- First = the first page no  -->
                <!-- Previous( << ) = if current page no is less than or equal to 1, previous button will be disabled -->
                <!-- Next( >> ) = if current page no is greater than or equal to total pages, next button can't be click -->
                <!-- Current page = current page no -->
                <!-- Last = the last page no -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                        <a class="page-link" href="?pageno=1">First</a>
                        </li>
                        <li class="page-item <?php if ($pageno <= 1) {echo 'disabled'; }?>">
                        <a class="page-link" href="<?php if($pageno <=1) { echo '#'; } else { 
                            echo "?pageno=".($pageno-1); } ?>"><<</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a>
                        </li>
                        <li class="page-item"<?php if ($pageno >= $total_pages) {echo 'disabled'; }?>">
                        <a class="page-link" href="<?php if($pageno >= $total_pages) { echo '#'; } else { 
                            echo "?pageno=".($pageno+1); } ?>">>></a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a>
                        </li>
                    </ul>
                </nav>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
