<?php 
	//ob_start();
	include("cart1.php"); 	
	if(isset($_POST['order'])){
		header("location:order.php");
	}	
	//ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
</head>
<body>
	<?php if(!empty($_SESSION['shopping_cart'])){  ?>
		<div class="container text-left ">
	 		<form method="post" action="" class="ml-5">
	 			<button type="submit" name="order" class="btn btn-block btn-secondary">Order</button>
	 		</form>
	 	</div>
	 <?php } ?>
</body>
</html>