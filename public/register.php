<?php 
	session_start();
	include('../db/db_config.php');

	if(isset($_POST['register'])){
		$error = [];

		$fname = (isset($_POST['fname'])) ? $_POST['fname'] : NULL;
		$lname = (isset($_POST['lname'])) ? $_POST['lname'] : NULL;
		$add = (isset($_POST['address'])) ? $_POST['address'] : NULL;
		$mail = (isset($_POST['email'])) ? $_POST['email'] : NULL;
		$num = (isset($_POST['number'])) ? $_POST['number'] : NULL;

		//FIRSTNAME VALIDATION
		$f_name = new FormValidator($fname,"Please Enter your first name");
		$r_f_name = $f_name->validateString();
		$error['fname'] = $f_name->error($r_f_name);

		//LASTNAME VALIDATION
		$l_name = new FormValidator($lname,"Please Enter your last name");
		$r_l_name = $l_name->validateString();
		$error['lname'] = $l_name->error($r_l_name);

		//ADDRESS VALIDATION
		$address = new FormValidator($add,"Please Enter your address");
		$r_address = $address->validateString();
		$error['address'] = $address->error($r_address);

		//EMAIL VALIDATION
		$email = new FormValidator($mail,"Please Enter your Email");
		$r_email = $email->validateString();
		$error['email'] = $email->error($r_email);

		//PHONENUMBER VALIDATION
		$number = new FormValidator($num,"Please Enter your number");
		$r_number = $number->validateString();
		$error['number'] = $number->error($r_number);

		//IF THERE IS NO ERROR MESSAGE
		if(count(array_unique($error)) == 1){
			$query = mysqli_query($db,"INSERT INTO customers 
												VALUES(NULL,
													   '".$r_f_name."',
													   '".$r_l_name."',
													   '".$r_address."',
													   '".$r_email."',
													   '".$r_number."'
									)") or die(mysqli_error($db));
			header("location:order.php");
			$msg = "Registeration successful!!!";
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

	<div class="row mt-5 pt-5">
		<div class="container text-dark bg-light col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10">
			<form action="" method="post">
				<h4 class="p-3 text-center">Please fill the form fields below</h4>
				<p><label>Firstname: 
						<span class="text-danger "><?php if(isset($error['fname'])) echo $error['fname'] ?></span>
					</label>
					<input type="text" name="fname" class="form-control"
						value="<?php if(isset($_POST['fname'])) echo $_POST['fname']?>"/>
				</p>
				<p><label>Lastname: 
						<span class="text-danger "><?php if(isset($error['lname'])) echo $error['lname'] ?></span>
					</label>
					<input type="text" name="lname" class="form-control"
						value="<?php if(isset($_POST['lname'])) echo $_POST['lname']?>"/>
				</p>
				<p><label>Address: 
					<span class="text-danger "><?php if(isset($error['address'])) echo $error['address'] ?></span>
				</label>
				<input type="text" name="address" class="form-control"
					value="<?php if(isset($_POST['address'])) echo $_POST['address']?>"/>	
				</p>
				<p><label>E-mail: 
					<span class="text-danger "><?php if(isset($error['email'])) echo $error['email'] ?></span>
					</label>
					<input type="text" name="email" class="form-control"
						value="<?php if(isset($_POST['email'])) echo $_POST['email']?>"/>
				</p>
				<p><label>Phone Number: 
						<span class="text-danger "><?php if(isset($error['number'])) echo $error['number'] ?></span>
					</label>
					<input type="text" name="number" class="form-control" maxlength="11"
						value="<?php if(isset($_POST['number'])) echo $_POST['number']?>"/>
				</p>

				<button type="submit" name="register" class="btn btn-danger justify-content-center">Register</button>
				<p>Have an account? <a href="order.php">Signin</a></p>
			</form>
		</div>
	</div>

	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
</body>
</html>