<?php 
	session_start();
	require("../db/db_config.php");
	$sess_merchant = $_SESSION['merchant'];

	$check = new Auth($db,"");
	$checker = $check->check($sess_merchant,"login.php");

	$product_id = $_GET['id'];

	$product_detail = new Product($db,"products","date_uploaded");
	$result = $product_detail->productDetails($product_id);

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Product Details</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
 	<div class="mt-5">
		<?php  $row = mysqli_fetch_object($result); ?>

		<h2><?= $row->name ?></h2>
		<img src="<?= $row->uploaded_image  ?>" class="img"/>
		<p><?= $row->description ?></p>
		<p><?= $row->price; ?></p>
		<a href="update.php?id=<?= $row->product_id  ?>">Update</a>
	</div>  		
	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>