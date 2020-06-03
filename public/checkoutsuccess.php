<?php 
	session_start();
	include('../db/authenticate.php');
	aut_public();

	session_unset();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout Success</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	 <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark ">
	 	<a class="navbar-brand" href="index.php">BOBarket</a>
	 	<!--  -->
	</nav>
	<h1 class="mt-5">Your Order Was Successful, Payment should be made on delivery!!!</h1>
	<script src="../jQuery3.2.1/jquery-3.2.1.js"></script>
    <script src="../bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
</body>
</html>