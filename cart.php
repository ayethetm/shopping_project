<?php
session_start();
require 'config/config.php';
require 'config/common.php';

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
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
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
					<a class="navbar-brand logo_h" href="index.html"><h4>Neko Shop<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="cart.php">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php
                        if (!empty($_SESSION['cart'])) { ?>
                            <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                            <?php

                                $total = 0;
                                foreach ($_SESSION['cart'] as $key => $value) :
                               
                                    $id = str_replace('id','',$key);//remove 'id'
                                    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                    $stmt->execute();
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $total += $result['price'] * $value;
                            ?>
                            <tbody>
                           <tr>
                           <td>
                               <div class="media">
                                   <div class="d-flex">
                                       <img src="images/<?php echo $result['image']; ?>" alt="product img" style="width:50px;height:50px;">
                                   </div>
                                   <div class="media-body">
                                       <p><?php echo $result['name']; ?></p>
                                   </div>
                               </div>
                           </td>
                           <td>
                               <h5><?php echo escape(number_format($result['price'])); ?> MMK</h5>
                           </td>
                           <td>
                              
                               <div class="product_count">
                                   <?php echo $value; ?>
                                   <!-- <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                       class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                   <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                       class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button> -->
                               </div>
                           </td>
                           <td>
                               <h5><?php echo escape(number_format($result['price'] * $value)); ?> MMK</h5>
                           </td>
                           <td>
                            <a class="primary-btn" href="clear_cart_item.php?pid=<?php echo $result['id']; ?>">Clear</a>
                           </td>
                       </tr>
                      
                       
                       <!-- <tr class="bottom_button">
                           <td>
                               <a class="gray_btn" href="#">Update Cart</a>
                           </td>
                           <td>

                           </td>
                           <td>

                           </td>
                           <td>
                               <div class="cupon_text d-flex align-items-center">
                                   <input type="text" placeholder="Coupon Code">
                                   <a class="primary-btn" href="#">Apply</a>
                                   <a class="gray_btn" href="#">Close Coupon</a>
                               </div>
                           </td>
                       </tr> -->
                       <?php endforeach; ?>
                       <tr>
                           <td>

                           </td>
                           <td>

                           </td>
                           
                           <td>
                               <h5>Subtotal</h5>
                           </td>
                           <td>
                               <h5><?php echo escape(number_format($total)); ?> MMK</h5>
                           </td>
                           <td></td>
                       </tr>
                       <!-- <tr class="shipping_area">
                           <td>

                           </td>
                           <td>

                           </td>
                           <td>
                               <h5>Shipping</h5>
                           </td>
                           <td>
                               <div class="shipping_box">
                                   <ul class="list">
                                       <li><a href="#">Flat Rate: $5.00</a></li>
                                       <li><a href="#">Free Shipping</a></li>
                                       <li><a href="#">Flat Rate: $10.00</a></li>
                                       <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                   </ul>
                                   <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                   <select class="shipping_select">
                                       <option value="1">Bangladesh</option>
                                       <option value="2">India</option>
                                       <option value="4">Pakistan</option>
                                   </select>
                                   <select class="shipping_select">
                                       <option value="1">Select a State</option>
                                       <option value="2">Select a State</option>
                                       <option value="4">Select a State</option>
                                   </select>
                                   <input type="text" placeholder="Postcode/Zipcode">
                                   <a class="gray_btn" href="#">Update Details</a>
                               </div>
                           </td>
                       </tr> -->
                       
                       <tr class="out_button_area">
                           <td>

                           </td>
                           <td>

                           </td>
                           <td>

                           </td>
                           <td></td>
                           
                           <td>
                               <div class="checkout_btn_inner d-flex align-items-center">
                                   <a class="gray_btn" href="clear_all.php">Clear All</a>
                                   <a class="primary-btn" href="checkout.php">Proceed to checkout</a>
                                   <a class="gray_btn" href="index.php">Continue Shopping</a>
                               </div>
                           </td>
                           <td></td>
                       </tr>
                   </tbody>
                           
                                
                              
                    </table>
                    <?php    } else { echo '<h4 class="text-center">Your Cart is empty now! <a href="index.php">Continue Shopping</h4>'; }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
    <?php include('footer.php');?>
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
