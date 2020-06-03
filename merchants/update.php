<?php 
	session_start();
	require("../db/db_config.php");
	$sess_merchant = $_SESSION['merchant'];

	$check = new Auth($db,"");
	$checker = $check->check($sess_merchant,"login.php");
	
	$product_id = $_GET['id'];
	//sql QUERY
	$product_detail = new Product($db,"products","date_uploaded");
	$result = $product_detail->productDetails($product_id);
	$row = mysqli_fetch_object($result); 

	if(isset($_POST['update'])){
		echo "RED";
		$error = [];
		$err = [];

		$name = (isset($_POST['name'])) ? $_POST['name'] : NULL;
		$desc = (isset($_POST['desc'])) ? $_POST['desc'] : NULL;
		$price = (isset($_POST['price'])) ? $_POST['price'] : NULL;
		$cat = (isset($_POST['cat'])) ? $_POST['cat'] : NULL;
		$image = (isset($_FILES['image'])) ? $_FILES['image'] : NULL;

		//PRODUCT NAME VALIDATION
		$p_name = new FormValidator($name,"Please Enter your name");
		$r_p_name = $p_name->validateString();
		$error['name'] = $p_name->error($r_p_name);

		//DESCRIPTION VALIDATION
		$p_desc = new FormValidator($desc,"Please Enter your product description");
		$r_p_desc = $p_desc->validateString();
		$error['desc'] = $p_desc->error($r_p_desc);

		//PRICE VALIDATION
		$p_price = new FormValidator($price,"Please Enter your product price");
		$r_p_price = $p_price->validateString();
		$error['price'] = $p_price->error($r_p_price);

		//CATEGORY VALIDATION
		$p_cat = new FormValidator($cat,"Please Enter your product category");
		$r_p_cat = $p_cat->validateString();
		$error['cat'] = $p_cat->error($r_p_cat);

		//IMAGE VALIDATION
		$image_name = new FormValidator($image,"This field cannot be empty");
		$r_image_name = $image_name->validateImageName();
		$e_image_name = $image_name->error($r_image_name);

		$image_size = new FormValidator($image,"File too large, Image should be within 4mb");
		$r_image_size = $image_size->validateImagesize();
		$e_image_size = $image_size->error($r_image_size);

		$image_type = new FormValidator($image,"File type not supported");
		$r_image_type = $image_type->validateImageType();
		$e_image_type = $image_type->error($r_image_type);

		if(isset($error['image_name'])){
			$err['image'] = $e_image_name;
		} elseif(isset($error['image_size'])){
			$err['image'] = $e_image_name;
		} else{
			$err['image'] = $e_image_name;
		}
		var_dump($error);
		if(count(array_unique($error)) == 1){
			$result = $product_detail->productUpdate("name","$r_p_name","$product_id");
			$result = $product_detail->productUpdate("description","$r_p_desc","$product_id");
			$result = $product_detail->productUpdate("price","$r_p_price","$product_id");
			//$result = $product_detail->productUpdate("date_uploaded","NOW()","$product_id");
			$result = $product_detail->productUpdate("category_id","$r_p_cat","$product_id");

			if($err){
				$image_name = str_replace(" ", "_", $r_image_name);
				$destination = '../images/'.$image_name; 
				if($res = move_uploaded_file($_FILES['image']['tmp_name'], $destination)){
					$result = $product_detail->productUpdate("uploaded_image","$destination","$product_id");
				}
			}
			
		}
		$update = mysqli_query($db, "UPDATE products SET date_uploaded = NOW() WHERE product_id = '$product_id'  ") or die(mysqli_error($db));
		header("Refresh:0");
	}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Update Product</title>
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
	 <section class="upload mt-5">
	 	<form action="" method="post" enctype="multipart/form-data">
 			<?php if(isset($msg)){ ?>
 				<h2><?php echo $msg; ?></h2>
 			<?php } ?>
 			<img src="<?= $row->uploaded_image ?>"/>
 			<p><label>Change Product Image</label>
  				<input type="file" name="image">
  				<?php if(isset($error['image'])) echo "<span>*".$err['image']."</span>" ?>
  			</p>

 			<p><label>Product Name</label> <?php if(isset($error['name'])) echo $error['name'] ?>
 				<input type="text" name="name" 
 				value="<?= $row->name ?>"/>
 			</p>
 			<p><label>Description</label> <?php if(isset($error['desc'])) echo $error['desc'] ?>
 				<input type="text" name="desc" 
 				value="<?= $row->description ?>" /> 
 			</p>
 			<p><label>Price </label><?php if(isset($error['price'])) echo $error['price'] ?>
 				<input type="number" name="price" 
 				value="<?= $row->price ?>" />
 			</p>

 			<p><label>Categories </label><span><?php if(isset($error['cat'])) echo $error['cat']; ?></span> 
 					<select name="cat"/>

 							<?php 
 								$category_id = $row->category_id;
			 					$cat = mysqli_query($db,"SELECT * FROM categories WHERE category_id = $category_id") or die(mysqli_error($db));
			 					$cat_result = mysqli_fetch_array($cat);
			 				?>

			 				<option value="<?php echo $cat_result['category_id'] ?>"><?php echo $cat_result['category_name'] ?></option>
			 				<?php 
			 					$cat = mysqli_query($db,"SELECT * FROM categories") or die(mysqli_error($db));
			 					while ($row = mysqli_fetch_array($cat)){ 
			 				?>
			 				<option value="<?php echo $row['category_id'] ?>">
			 					<?php echo $row['category_name'] ?>
			 				</option>
			 			<?php } ?>
 					</select>
 			</p>
 			<input type="submit" name="update" value="Update">
 		</form>
 	</section>
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>