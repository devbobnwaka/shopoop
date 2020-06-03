<?php 
	require("../Class/E_commerce.php");

	//instantiate database object
	$database = new Database("localhost","root","","e_commerce");
	$db = $database->getConnection();


 ?>