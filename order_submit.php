<?php

session_start();
require 'config/config.php';
require 'config/common.php';

	//check whether user is logged in or not
	if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
		header('Location:login.php');
	}
	
	if ( !empty($_SESSION['cart'])) 
	{
		
		$user_id = $_SESSION['user_id']; //logged in user
		$total = 0;
		foreach ($_SESSION['cart'] as $key => $value) 
		{
			$id = str_replace('id','',$key);//remove 'id'
			$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$total += $result['price'] * $value;
		}
			// add ordersubmit data(all cart data) to 'Sale_Orders table' (user_id,total_price,order_date)
		
			$order_stmt = $pdo->prepare("INSERT INTO sale_orders(user_id,total_price,order_date) VALUES(:user_id,:total_price,:order_date)");
			$order_result = $order_stmt->execute(array(':user_id' => $user_id , ':total_price' => $total,':order_date' => date('Y-m-d H:i:s')));
				
		
		// add ordersubmit data(all cart data) to 'Sale_Order_Detail table' (sale_order_id,product_id,quantity,order_date)
		if ($result) 
		{
			$sale_order_id = $pdo->lastInsertId(); // last inserted id
			foreach ($_SESSION['cart'] as $key => $value) 
			{
				$id = str_replace('id','',$key);//remove 'id'
				$order_detail_stmt = $pdo->prepare("INSERT INTO sale_order_detail(sale_order_id,product_id,quantity,order_date) VALUES(:sale_order_id,:product_id,:quantity,:order_date)");
				$order_detail_result = $order_detail_stmt->execute(array(':sale_order_id' => $sale_order_id , ':product_id' => $id,':quantity' => $value,':order_date' => date('Y-m-d H:i:s')));

				// reduce product quantity for each order submit product
				$qty_stmt = $pdo->prepare("SELECT quantity FROM products WHERE id=".$id);
				$qty_stmt->execute();
				$qty_result = $qty_stmt->fetch(PDO::FETCH_ASSOC);

				$update_qty = $qty_result['quantity'] - $value;
				$stmt = $pdo->prepare("UPDATE products SET quantity=:update_qty  WHERE id=:id");
				$stmt->execute(array(":update_qty"=>$update_qty,":id"=>$id));
			} 
		}
		unset($_SESSION['cart']);
		
	}
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Neko Shop</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>Neko Shop<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"></span></a></li>
							<!-- <li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li> -->
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<!-- <div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div> -->
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Order Confirmation</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="order_submit.php">Order Confirm</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
			<div class="row order_d_inner">
				<div class="col-lg-6 mb-5">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
						<?php
						 $total = 0;
						 $stmt = $pdo->prepare('SELECT total_price FROM sale_orders WHERE user_id='.$_SESSION['user_id']);
						 $stmt->execute();
						 $result = $stmt->fetchAll();
						 foreach ($result as $key => $value) {
							$total += $value['total_price'];
						 }
						
						 ?>
						<li><a href="#"><span>Total</span> : <?php echo escape(number_format($total)) ?> MMK</a></li>
						<li><a href="#"><span>Payment method</span> : Check payments</a></li> 
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="details_item">
						<h4>Shipping Address</h4>
						<ul class="list">
						<?php
						 $stmt = $pdo->prepare('SELECT * FROM users WHERE id='.$_SESSION['user_id']);
						 $stmt->execute();
						 $result = $stmt->fetchAll();
						 if ($result) {
							foreach ($result as $key => $value) { ?>
								<li><a href="#"><span>Name</span> : <?php echo escape($value['name']); ?></a></li>
								<li><a href="#"><span>Address</span> : <?php echo escape($value['address']); ?></a></li>
							<li><a href="#"><span>Phone</span> : <?php echo escape($value['phone']); ?></a></li>
						<?php	}
						 } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Order Details Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
			</div>
		</div>
	</footer>
	<!-- End footer Area -->




	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
