<?php include('header.php') ?>

<?php
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
	$stmt->execute();
	$result = $stmt->fetchAll();

  // if (isset($_SESSION['cart'])) {
  //   print_r($_SESSION['cart']);
  // }
  
  //to get category name 
  $category_id = $result[0]['category_id'];
  $cat_stmt = $pdo->prepare('SELECT name FROM categories WHERE id='.$category_id);
  $cat_stmt->execute();
  $cat_result = $cat_stmt->fetchAll();
?>
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
					<?php
						$catstmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
						$catstmt->execute();
						$catresult = $catstmt->fetchAll();

						if ($result) {
							foreach ($catresult as $key => $value) { ?>
								<li class="main-nav-list"><a href="index.php?category=<?php echo $value['id']; ?>" aria-expanded="false" aria-controls="fruitsVegetable"><span
								 class="lnr lnr-arrow-right"></span><?php echo escape($value['name']) ?>
								 <!-- <span class="number">(53)</span> -->
								</a>
						</li>
					<?php		
						}
					}
					?>
						
					</ul>
				</div>
			</div>
<!--================Single Product Area =================-->
<div class="col-xl-9 col-lg-8 col-md-7">
<div class="product_image_area p-0 mt-3">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-4">
        
          <?php
            if ($result) {
              foreach ($result as $key => $value) { ?>
                <div class="single-prd-item">
                <img class="img-fluid" src="images/<?php echo $value['image']; ?>" alt="">
                </div>
          <?php    }
            } ?>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <?php  if ($result) { 
              foreach ($result as $key => $value) { ?>
                <div class="s_product_text">
                  <h3><?php echo $value['name']; ?></h3>
                  <h2><?php echo escape(number_format($value['price'])) ?> MMK</h2>
                  <ul class="list">
                    <?php if ($cat_result) { ?>
                      <li><a class="active" href="#"><span>Category</span> : <?php echo $cat_result[0]['name']; ?></a></li>
                  <?php  } ?>
                    <li><a href="#"><span>Availibility</span> : In Stock</a></li>
                  </ul>
                  <p style="margin-bottom:30px;"><?php echo $value['description']; ?></p>
                <?php }
                 } ?>
                  <div class="product_count">
                    <!-- add to cart -->
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; 
                        ?>">
                        <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                        <label for="qty">Quantity:</label>
                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                        class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                        class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i>
                        </button>
                      </div>
                      <div class="card_area d-flex align-items-center mb-5">
                        <button class="primary-btn btn" type="submit" style="color:white;">Add to Cart</button>
                        <a class="btn btn-secondary btn" href="index.php">Back</a>
                      </div>
                    </form>
                    
                </div>
              </div>
    </div>
  </div>
</div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
