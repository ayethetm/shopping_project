<?php

session_start();
require 'config/config.php';
require 'config/common.php';

if ($_POST) {
    
        $email = $_POST['email'];
		$password = $_POST['password'];

		//get user data with post email
		$stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email"); 
		$stmt->bindValue(':email',$email);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($result) 
		{
			if (password_verify($password,$result['password'])) 
			{
				$_SESSION['user_id'] = $result['id'];
				$_SESSION['username'] = $result['name'];
				$_SESSION['logged_in'] = time();
				//redirect to home page
				header('Location:index.php');
			}
		}
        
        echo "<script>alert('Incorrect credentials!');</script>";
    
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
					<ul class="nav navbar-nav menu_nav ml-auto">
							<!-- <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li> -->
							
							<!-- <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li> -->
							<li class="nav-item"><a class="nav-link" href="login.php">Login / Register</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							
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
					<h1>Login</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="login.php">Login</a>
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
					<div class="login_form_inner" style="padding-top:50px;">
						<h3>Log in to your account</h3>
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate">
						<input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; 
                        ?>">
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" 
								style="<?php echo empty($emailError) ? '' : 'border:1px solid red';
								?>" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
								 <p style="text-align:left;color:red;"><?php echo empty($emailError) ? '' : $emailError ?></p>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" 
								name="password" style="<?php echo empty($passwordError) ? '' : 'border:1px solid red';?>" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
								<p style="text-align:left;color:red;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
							</div>
							<!-- <div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div> -->
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Log In</button>
								<a class="text-primary" href="register.php">Not a member? Create an account</a>
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
</body>

</html>