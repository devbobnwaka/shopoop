<?php 
	session_start();
	require("../db/db_config.php");

	if(array_key_exists('signup', $_POST)){
		$error = [];

		$name = (isset($_POST['name'])) ? $_POST['name'] : NULL;
		$address = (isset($_POST['address'])) ? $_POST['address'] : NULL;
		$number = (isset($_POST['number'])) ? $_POST['number'] : NULL;
		$email = (isset($_POST['email'])) ? $_POST['email'] : NULL;
		$username = (isset($_POST['username'])) ? $_POST['username'] : NULL;
		$password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

		//BUSINESS NAME VALIDATION
		$p_name = new FormValidator($name,"Please Enter your name");
		$r_p_name = $p_name->validateString();
		$error['name'] = $p_name->error($r_p_name);

		//ADDRESS VALIDATION
		$p_address = new FormValidator($address,"Please Enter your address");
		$r_p_address = $p_address->validateString();
		$error['address'] = $p_address->error($r_p_address);

		//NUMBER VALIDATION
		$p_number = new FormValidator($number,"Please Enter your number");
		$r_p_number = $p_number->validateString();
		$error['number'] = $p_number->error($r_p_number);

		//Email VALIDATION
		$p_email = new FormValidator($email,"Please Enter your email");
		$r_p_email = $p_email->validateEmail();
		$error['email'] = $p_email->error($r_p_email);

		//USERNAME VALIDATION
		$p_username = new FormValidator($username,"Please Enter your username");
		$r_p_username = $p_username->validateString();
		$error['username'] = $p_username->error($r_p_username);

		//PASSWORD VALIDATION
		$p_password = new FormValidator($password,"Please Enter your password");
		$r_p_password = $p_password->validateString();
		$sr_p_password = md5($r_p_password);
		$error['password'] = $p_password->error($r_p_password);


		//IF THERE IS NO ERROR MESSAGE
		if(count(array_unique($error)) == 1){
			$query = "INSERT INTO merchant VALUES(NULL,'".$r_p_name."','".$sr_p_password."','".$r_p_number."',
												'".$r_p_email."','".$r_p_username."','".$r_p_password."',
												'".$r_p_address."',NOW())";
			$insert = mysqli_query($db,$query) or die(mysqli_error($db));

			unset($_POST);
			echo $sucess = "SIGN UP SUCCESSFUL!!!";	
		}
	}



 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Sign Up</title>
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
		<div class="container text-dark bg-light col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10 p-3">
		 	<form action="" method="post">
		 		<h3 class="text-center">Sign Up</h3>
				<p><label>Business Name:</label> <input type="text" name="name" class="form-control"
					value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?>"/>
					<span class="text-danger"><?php if(isset($error['name'])) echo $error['name'] ?></span> 
				</p>

				<p><label>Address:</label> <input type="text" name="address" class="form-control"
					value="<?php if(isset($_POST['address'])) echo $_POST['address']?>"/>
					<span class="text-danger"><?php if(isset($error['address'])) echo $error['address'] ?></span>
				</p>

				<p><label>Phone Number:</label> <input type="text" name="number" class="form-control"
					value="<?php if(isset($_POST['number'])) echo $_POST['number']?>"/>
					<span class="text-danger"><?php if(isset($error['number'])) echo $error['number'] ?></span>
				</p>

				<p><label>Email: </label><input type="text" name="email" class="form-control"
					value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/>
					<span class="text-danger"><?php if(isset($error['email'])) echo $error['email'] ?></span>
				</p>

				<p><label>Username: </label><input type="text" name="username" class="form-control"
					value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>"/>
					<span class="text-danger"><?php if(isset($error['username'])) echo $error['password'] ?></span>
				</p>

				<p><label>Password: </label><input type="password" name="password" class="form-control"
					value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>"/>
					<span class="text-danger"><?php if(isset($error['password'])) echo $error['password'] ?></span>
				</p>
				<button type="submit" name="signup" class="btn btn-danger justify-content-center">Sign Up</button>
				<div class="already">
					<p>Already have an account? </p>
					<a href="login.php">Login</a>
				</div>
			</form>
		</div>
	</div>
	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
 </body>
 </html>