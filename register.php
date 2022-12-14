<?php

session_start();
require 'config/config.php';
require 'config/common.php';

if ($_POST) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || 
    empty($_POST['address']) || empty($_POST['password']) || strlen($_POST['password']) < 4) 
    {
        if (empty($_POST['name'])) 
        {
            $nameError = "Name cannot be empty";
        }
        if (empty($_POST['email'])) 
        {
            $emailError = "Email cannot be empty";
        }
        if (empty($_POST['phone'])) 
        {
            $phoneError = "Phone cannot be empty";
        }
        if (empty($_POST['address'])) 
        {
            $addressError = "Address cannot be empty";
        }
        if (empty($_POST['password'])) 
        {
            $passwordError = "Password cannot be empty";
        }
        if (strlen($_POST['password']) < 4) 
        {
            $passwordError = "Password length must be at least 4";
        }

    }
    else
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT); //pwd hashing

        // to check duplicate user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        //bind value
        $stmt->bindValue(':email',$email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) 
        {
            echo "<script>alert('User is already exists');</script>";
        }
        else
        {
            $stmt = $pdo->prepare("INSERT INTO users(name,email,phone,address,password) VALUES(:name,:email,:phone,:address,:password)");
            $result = $stmt->execute(array(':name'=>$name,':email'=>$email,':phone'=>$phone,':address'=>$address,':password'=>$password));

            if ($result) 
            {
                echo "<script>alert('Registration successful!');window.location.href='login.php';
                </script>";
            }
        }
    }
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
	<title>Neko Shop | Register</title>

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
					<a class="navbar-brand logo_h" href="index.html"><img src="img/logo.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">

					</div>
				</div>
			</nav>
		</div>
		
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="register.php">Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-12">
					<div class="login_form_inner" style="padding-top:100px;">
						<h3>Register to connect with Us</h3>
						<form class="row login_form" action="register.php" method="post" id="contactForm" novalidate="novalidate">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; 
                        ?>">
                            <div class="col-md-12 form-group">
								<input type="name" class="form-control" id="name" name="name" 
                                style="<?php echo empty($nameError) ? '' : 'border:1px solid red';?>"
                                placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
                                <p style="text-align:left;color:red;"><?php echo empty($nameError) ? '' : $nameError ?></p>
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" 
                                style="<?php echo empty($emailError) ? '' : 'border:1px solid red';?>"
                                placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                                <p style="text-align:left;color:red;"><?php echo empty($emailError) ? '' : $emailError ?></p>
							</div>
                            <div class="col-md-12 form-group">
								<input type="phone" class="form-control" id="phone" name="phone" 
                                style="<?php echo empty($phoneError) ? '' : 'border:1px solid red';?>"
                                placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'">
                                <p style="text-align:left;color:red;"><?php echo empty($phoneError) ? '' : $phoneError ?></p>
							</div>
                            <div class="col-md-12 form-group">
								<input type="address" class="form-control" id="address" 
                                name="address" 
                                style="<?php echo empty($addressError) ? '' : 'border:1px solid red';?>"
                                placeholder="Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'">
                                <p style="text-align:left;color:red;"><?php echo empty($addressError) ? '' : $addressError ?></p>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" 
                                style="<?php echo empty($passwordError) ? '' : 'border:1px solid red';?>"
                                placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                                <p style="text-align:left;color:red;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
							</div>
							<!-- <div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>  -->
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
								<a href="login.php" class="text-primary">Already have an account?</a>
							</div> 
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

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