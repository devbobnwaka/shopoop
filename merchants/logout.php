<?php 
	require("../db/db_config.php");
	$logout = new Auth($db,"");
	$r_logout = $logout->logout('login.php');

 ?>