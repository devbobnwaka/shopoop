<?php 
	session_start();
	require("../db/db_config.php");

	if(array_key_exists('login', $_POST)){

		$error = [];

		//GET VALUE FROM USER
		$username = (isset($_POST['username'])) ? $_POST['username'] : NULL;
		$password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

		//USERNAME VALIDATION
		$form_val = new FormValidator($username,"Please Enter your username");
		$return_uname = $form_val->validateString();
		$error['username'] = $form_val->error($return_uname);

		//PASSWORD VALIDATION
		$form_val = new FormValidator($password,"Please Enter your password");
		$return_pword = $form_val->validateString();
		$error['password'] = $form_val->error($return_pword);

		//IF THERE IS NO ERROR MESSAGE
		if(count(array_unique($error)) == 1){
			$auth = new Auth($db,"merchant");
			if($auth->login($return_uname,$return_pword)){
				header("location:view_product.php");
			} else{
				$msg = "Incorrect username or password";
			}
		}
	}

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Merchant login</title>
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
	              <!-- 	<li class="nav-item mr-2">
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
                    <a class="nav-link" href="../public/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../merchants/login.php">Merchants</a>
                </li>
            </ul>
        </div>
	</nav>
	<div class="row mt-5 pt-5">
		<div class="container text-dark bg-light col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10">
			<form action="" method="post">
				<h4 class="p-3 text-center">MERCHANT LOGIN</h4>
				<p><?php if(isset($msg)) echo $msg;  ?></p>
				<p><label>Username: <span class="text-danger"><?php if(isset($error['username'])) echo $error['username'] ?></span></label> 
					<input type="text" name="username" class="form-control" value="<?php if(isset($username)) echo $username ?>" />
				</p>
				<p><label>Password: <span class="text-danger"><?php if(isset($error['password'])) echo $error['password'] ?></span></label>
					<input type="password" name="password" class="form-control" value="<?php if(isset($password)) echo $password ?>" />
				</p>
				<button type="submit" name="login" class="btn btn-danger justify-content-center">Login</button>
				<p>Don't have an account? <a href="signup.php">Sign Up</a></p>
			</form>
		</div>
	</div>
 	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>