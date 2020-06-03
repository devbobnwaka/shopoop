<?php 
	session_start();
	include("../db/db_config.php");

	$status="";
	if(isset($_POST['action']) && $_POST['action'] == "remove"){
		if(!empty($_SESSION['shopping_cart'])){
			foreach($_SESSION['shopping_cart'] as $key => $value){
				if($_POST['p_key'] == $key){
					unset($_SESSION["shopping_cart"][$key]);
					$status = "<div class='box' style='color:red;'>Product is removed from your cart!</div>";
				}
				if(empty($_SESSION["shopping_cart"])) unset($_SESSION["shopping_cart"]);
			}
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == "change"){
		foreach ($_SESSION["shopping_cart"] as &$value) {
			if($value['pro_id'] === $_POST['p_key']){
				$value['quantity'] = $_POST["quantity"];
				break; //Stop the loop afterwe've found the product
			}
		}
	}

	if(isset($_POST['order'])){
		header("location:order.php");
	}	
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Cart</title>
 	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
 </head>
 <body>
 	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
	 	<a class="navbar-brand" href="index.php">BOBarket</a>
	 	<div>
			<div class="bg-dark">
				<ul class="navbar-nav flex-row ml-auto ">
	                <?php 
						if(isset($_POST['empty_cart'])){
							unset($_SESSION['shopping_cart']);
						}

						if(!empty($_SESSION['shopping_cart'])){
								$cart_count = count(array_keys($_SESSION['shopping_cart']));
					?>
	              	<li class="nav-item mr-2">
		                <a class="nav-link" href="cart.php">Cart <span class="badge badge-light"><?= $cart_count; ?></span></a>
		            </li>
	                <form method="post" action="" style="display: inline-block;">
						<button type="submit" name="empty_cart" class="btn btn-danger text-light p-1">Empty Cart</button>
					</form>
	                <?php }	?>	
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
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../merchants/login.php">Merchants</a>
                </li>
            </ul>
        </div>
	</nav>

 	<div class="container ">
 		<div class="pt-5 pl-5 pr-5 mt-5 pb-0 mx-auto">
 		<?php 
 		if(!isset($_SESSION["shopping_cart"])){
	 		echo "<h3>Your cart is empty!</h3>";
	 	} else {
 				$total_price = 0;
 		 ?>
 		 <table class="table">
 		 	<thead class="thead-dark">
 		 		<tr>
 		 			<th scope="col" width="110">IMAGE</th>
 		 			<th scope="col">ITEM NAME</th>
 		 			<th scope="col">QUANTITY</th>
 		 			<th scope="col">UNIT PRICE</th>
 		 			<th scope="col">ITEMS TOTAL</th>
 		 		</tr>
 		 	</thead>
 		 	<tbody>
 		 		<?php 
 		 		foreach ($_SESSION["shopping_cart"] as $key => $product) {
 		 		 ?>
 		 		 <tr>
 		 		 	<td>
 		 		 		<img src='<?= $product["image"] ?>' width="50" height="40" />
 		 		 	</td>
 		 		 	<td><?= $product["name"]; ?><br>
 		 		 		<form method="post" action="">
 		 		 			<input type="hidden" name="p_key" value="<?= $key; ?>" />
 		 		 			<input type="hidden" name="action" value="remove" />
 		 		 			<button type='submit' class='remove btn btn-danger btn-sm'>Remove</button>
 		 		 		</form>
 		 		 	</td>
 		 		 	<td>
 		 		 	  <form method="post" action="">
 		 		 		<input type="hidden" name="p_key" value="<?php echo $product["pro_id"]; ?>" />
 		 		 		<input type="hidden" name="action" value="change" />
 		 		 		<select name='quantity' class="quantity" onChange="this.form.submit()">
 		 		 		  <option value="1" <?php if($product["quantity"] == 1) echo "selected"; ?> >1</option>
 		 		 		  <option value="2" <?php if($product["quantity"] == 2) echo "selected"; ?> >2</option>
 		 		 		  <option value="3" <?php if($product["quantity"] == 3) echo "selected"; ?> >3</option>
 		 		 		  <option value="4" <?php if($product["quantity"] == 4) echo "selected"; ?> >4</option>
 		 		 		  <option value="5" <?php if($product["quantity"] == 5) echo "selected"; ?> >5</option>
 		 		 		</select>
 		 		 	  </form>
 		 		 	</td>

 		 		 	<td><?= "N".$product['price']; ?></td>
 		 		 	<td><?= "N".$product['price']*$product["quantity"]; ?></td>
 		 		 </tr>

 		 		 <?php 
	 		 			$total_price += ($product['price']*$product["quantity"]);
	 		 		}
 		 		  ?>
 		 		 <tr>
 		 		 	<td colspan="5" align="right">
 		 		 		<strong>TOTAL: <?= "N".number_format($total_price,2); ?></strong>	
 		 		 	</td>
 		 		 </tr>
 		 	</tbody>
 		</table>
 	</div>

	<?php }  ?>
 	</div>
 	<?php if(!empty($_SESSION['shopping_cart'])){  ?>
		<div class="container text-left ">
	 		<form method="post" action="" class="ml-5">
	 			<button type="submit" name="order" class="btn btn-block btn-secondary">Order</button>
	 		</form>
	 	</div>
	 <?php } ?>
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>