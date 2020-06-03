<?php 
	session_start();
	require("../db/db_config.php");
	$sess_merchant = $_SESSION['merchant'];

	//PAGINATING
	$display = 8;
	// $offset = 0;
	//	Determine	how	many	pages	there	are... 
	if(isset($_GET['p']) && is_numeric($_GET['p'])) {
		 // Already been   determined.
		$pages = $_GET['p'];
	} else {    // Need to determine.
		//	Count	the	number	of	records: 
		$q = "SELECT COUNT(product_id) FROM products";

		$r = mysqli_query($db, $q) or die(mysqli_error($db));
		$row = mysqli_fetch_array($r);
		$records = $row[0];

		//	Calculate	the	number	of	pages... 

		if($records > $display){  //more than one page
			$pages = ceil($records/$display);
			//echo $pages;
		}  else { 
				$pages = 1; 
		}
	}  // End of p IF. 

	//	Determine where	in	the	database	to	start	returning	results... 
	if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	 	$start = $_GET['s']; 
	} else {
		 $start = 0; 
	}

	//INSTANTIATE OBJECT
	$check = new Auth($db,"");
	$checker = $check->check($sess_merchant,"login.php");
	//instantiate Object
	$merchant_p = new Product($db,"products","date_uploaded");
	$result = $merchant_p->merchantPro($sess_merchant['id'],$start,$display);

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>View Product</title>
 	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 </head>
 <body>
 	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
	 	<a class="navbar-brand" href="../public/index.php">BOBarket</a>
	 	<div>
			<div class="bg-dark">
				<ul class="navbar-nav flex-row ml-auto ">
	                <?php 
						// if(isset($_POST['empty_cart'])){
						// 	unset($_SESSION['shopping_cart']);
						// }

						// if(!empty($_SESSION['shopping_cart'])){
						// 		$cart_count = count(array_keys($_SESSION['shopping_cart']));
					?>
	              	<!-- <li class="nav-item mr-2">
		                <a class="nav-link" href="cart.php">Cart <span class="badge badge-light"><?php //$cart_count; ?></span></a>
		            </li>
	                <form method="post" action="" style="display: inline-block;">
						<button type="submit" name="empty_cart" class="btn btn-danger text-light p-1">Empty Cart</button>
					</form> -->
	                <?php //}	?>	
	            </ul>
	            </div>
	        </div>
		</div>
	 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="view_product.php">View products <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Upload products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_order.php">View orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
	</nav>
 
 	<section class="container-fluid mt-5">
 		<div class="row">
		<?php 
			while($row = mysqli_fetch_object($result)): ?>
				<div class="col-sm-6 col-md-4 col-lg-3 col- my-3">
					<div class="card">
						<a href="details.php?id=<?= $row->product_id ?>">
							<figure>
						 		<img src="<?= $row->uploaded_image ?>" class="card-img-top" width="200" height="250"/>
						 		<div class="card-body">
							 		<h3 class='card-text text-dark'><?=  $row->description ?></h3>
							 		<p class='card-text text-dark'>N<?= $row->price ?></p>
							 		<a href="details.php?id=<?= $row->product_id ?> ">Edit</a>
							 	</div>
						 	</figure>
						</a>
					</div>
				</div>
			<?php endwhile ?>
	</section>

 	<section class="container-fluid" aria-label="Page navigation example">
		<ul class="pagination justify-content-center">
			<?php if($pages > 1){
				$current_page = ($start/$display) + 1;
				if ($current_page != 1) {   ?>
			<li class="page-item"><a class="page-link text-dark" href="view_product.php?s=<?= ($start - $display)?>&p=<?= $pages?>">Previous</a></li>
			<?php } ?>
			<?php for ($i = 1; $i <= $pages; $i++) {
					if ($i != $current_page) {
		   ?>
			<li class="page-item"><a class="page-link text-dark" href="view_product.php?s=<?= (($display*($i - 1))) ?>&p=<?= $pages ?>"><?= $i ?></a></li>
			<?php } else { 
		 		echo "<li class='page-item'><a class='page-link bg-dark text-light' href=''>$i</li></a>"; 
		 		}
		 	}
			?>
			<?php if($current_page != $pages){ ?>
			<li class="page-item"><a class="page-link text-dark" href="view_product.php?s=<?= ($start + $display) ?>&p=<?= $pages ?>">Next</a></li>
			<?php }
			} ?>
		</ul>
	</section>
	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </body>
 </html>