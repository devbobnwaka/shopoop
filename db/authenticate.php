<?php 
	function aut_admin(){
		if(empty($_SESSION['administrator_name'])){
			header("location:admin_login.php");
		}
	}

	function aut_merchant(){
		if(empty($_SESSION['username']) && empty($_SESSION['date_registered'])){
			header("location:login.php");
		}
	}

	function aut_public(){
		if(empty($_SESSION['email']) && empty($_SESSION['number'])){
			header('location:index.php');
		}
	}
 ?>