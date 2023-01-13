<?php include('header.php') ?>
	<?php

		if (!empty($_GET['pageno'])) 
		{
			$pageno = $_GET['pageno'];
		}
		else
		{
			$pageno = 1;
		}

		$numOfrecs = 6; // number of records in one one page
		$offset = ($pageno - 1) * $numOfrecs; // offset algorithm

		if (empty($_POST['search']) && empty($_COOKIE['search'])) 
		{
			$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
			$stmt->execute();
			$rawResult = $stmt->fetchAll();

			$total_pages = ceil(count($rawResult)/ $numOfrecs); //to get total pages

			$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
			$stmt->execute();
			$result = $stmt->fetchAll();
		}
		else
		{
			$searchKey = $_POST ? $_POST['search'] : $_COOKIE['search'];

			$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
			$stmt->execute();
			$rawResult = $stmt->fetchAll();

			$total_pages = ceil(count($rawResult)/ $numOfrecs); //to get total pages

			$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
			$stmt->execute();
			$result = $stmt->fetchAll();
		}

	?>
	
		<!-- <div class="filter-bar d-flex flex-wrap align-items-center">
			<div class="pagination">
            <li class="page-item <?php if ($pageno <= 1) {echo 'disabled'; }?>">
                <a class="page-link" href="<?php if($pageno <=1) { echo '#'; } else { 
                echo "?pageno=".($pageno-1); } ?>"><i class="fa fa-long-arrow-left"></i></a>
            </li>
            <li class="page-item">
				<a class="page-link active" href="#"><?php echo $pageno; ?></a>
            </li>
            <li class="page-item <?php if ($pageno >= $total_pages) {echo 'disabled'; }?>">
                <a class="page-link" href="<?php if($pageno >= $total_pages) { echo '#'; } else { 
                echo "?pageno=".($pageno+1); } ?>"><i class="fa fa-long-arrow-right"></i></a>
            </li>
		</div> -->
	<!-- </div> -->
		
		<!-- Start Products -->
		<div class="col-xl-9 col-lg-8 col-md-7">
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php
							if ($result) {
								foreach ($result as $key => $value) { ?>
									<div class="col-lg-4 col-md-6 col-sm-12 mb-5">
									<div class="card h-100" style="margin-top:0px;margin-bottom:20px;padding: 16px;text-align: left;">
										<img src="images/<?php echo escape($value['image']); ?>" alt="cat food image" style="height:160px;width:200px;">
										<div class="card-body p-0">
											<a href="product_detail.php?id=<?php echo $value['id'] ?>"><h5 class="card-title"><?php echo escape($value['name']) ?>
											</h5></a>
											<p style="small text-muted" class="card-text"><?php echo escape(number_format($value['price'])) ?> MMK</p>
											<button class="btn btn-sm" style="background-color:#ff8507;color:white;">Add to cart  <span class="ti-bag"></span></button>
										</div>
											<!-- <h6 class="l-through">$210.00</h6> -->
								</div></div>
						<?php	}
							} ?>
					</div>
				</section>
				</div>
		<!-- End Products -->
		<!-- Start pagination -->		
				<div class="col-xl-3 col-lg-4 col-md-5"></div>
				<div class="col-xl-9 col-lg-8 col-md-7">
                    <ul class="pagination justify-content-end mb-3">
                        <li class="page-item <?php if ($pageno <= 1) {echo 'disabled'; }?>">
                        <a class="page-link" href="<?php if($pageno <=1) { echo '#'; } else { 
                            echo "?pageno=".($pageno-1); } ?>"><i class="fa fa-long-arrow-left"></i></a>
                        </li>
                        <li class="page-item"><a class="page-link active" href="#"><?php echo $pageno; ?></a>
                        </li>
                        <li class="page-item"<?php if ($pageno >= $total_pages) {echo 'disabled'; }?>">
                        <a class="page-link" href="<?php if($pageno >= $total_pages) { echo '#'; } else { 
                            echo "?pageno=".($pageno+1); } ?>"><i class="fa fa-long-arrow-right"></i></a>
                        </li>
                    </ul>
              

					<!-- <li class="page-item <?php if ($pageno <= 1) {echo 'disabled'; }?>">
								<a class="page-link" href="<?php if($pageno <=1) { echo '#'; } else { 
								echo "?pageno=".($pageno-1); } ?>"><i class="fa fa-long-arrow-left"></i></a>
							</li>
							<li class="page-item">
								<a class="page-link active" href="#"><?php echo $pageno; ?></a>
							</li>
							<li class="page-item <?php if ($pageno >= $total_pages) {echo 'disabled'; }?>">
								<a class="page-link" href="<?php if($pageno >= $total_pages) { echo '#'; } else { 
								echo "?pageno=".($pageno+1); } ?>"><i class="fa fa-long-arrow-right"></i></a>
							</li> -->
				</div>
				<!-- End Pagination -->
<?php include('footer.php');?>
