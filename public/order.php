<?php 	
	session_start();
	require("../db/db_config.php");

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Order</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<?php
	//include("cart1.php");
	// if(!isset($_SESSION)){
	// 	session_start();
	// }
	
	if(empty($_SESSION['shopping_cart'])){
		header("location:cart.php");
	}

	if(isset($_POST['signin'])){

		$error = [];
		
		if(empty($_POST['email'])){
			$error['email'] = "*";
		} else{
			$email = mysqli_real_escape_string($db,trim($_POST['email']));
		}
		if(empty($_POST['number'])){
			$error['number'] = "*";
		} else{
			$number = mysqli_real_escape_string($db,trim($_POST['number']));
		}
		

		if(empty($error)){
			$customers = mysqli_query($db,"SELECT * FROM customers WHERE email = '".$email."' AND phone_number = '".$number."' ") or die(mysqli_error($db)); 
			$result = mysqli_fetch_array($customers);
			
			if(mysqli_num_rows($customers) == 1){
				//echo "RED";
				$customer_id = $result[0];
				$email = $result['email'];
				$number = $result['phone_number'];
				$_SESSION['customer_id'] = $customer_id;
				$_SESSION['email'] = $email;
				$_SESSION['number'] = $number;
				header("location:checkout.php");
			} else{
				$msg = "Incorrect username or password!!!";
			}

		}	

	}
 ?>

 <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
	 	<a class="navbar-brand" href="index.php">BOBarket</a>
	 	<div>
			<div class="bg-dark">
				<ul class="navbar-nav flex-row ml-auto ">
	                <?php 
						if(isset($_POST['empty_cart'])){
							unset($_SESSION['shopping_cart']);
							header("location:cart.php");
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
 	<div class="row">
 		<div class="col-12">
		 	
			<form method="post" action="" class="container ">
				<h5>Please Sign In to Complete your order!!!</h5>
				<h5 class="text-danger"><?php if(isset($msg)) echo $msg ?></h5>
				 <div class="form-row">
                    <div class="col-md-5">
						<input type="email" name="email" placeholder="Email" class="form-control is-invalid"
							value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/>
							<span><?php //if(isset($error['email'])) echo $error['email'] ?></span>
							<div class="invalid-feedback">
	                            Email is required!
	                        </div>
					</div>
					<div class="col-md-5">
						<input type="number" name="number" placeholder="Phonenumber" class="form-control is-invalid" maxlength="11"
							value="<?php if(isset($_POST['number'])) echo $_POST['number'] ?>"/>
							<span><?php //if(isset($error['number'])) echo $error['number'] ;?>
								</span>
							<div class="invalid-feedback">
	                            Password is required!
	                        </div>
					</div>
					<div class="col-md-2">
						<button type="submit" name="signin" class="btn btn-block btn-secondary">Sign In</button>
					</div>
				</div>
				<p>Not a Registered user? Click <a href="register.php">here</a> to register</p>
			</form>
		</div>
	</div>
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>