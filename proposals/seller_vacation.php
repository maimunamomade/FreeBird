<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

if($_POST['turn_on'] == "on"){
	
$seller_id = $_POST['seller_id'];

$turn_on = $_POST['turn_on'];
	
$update_seller = "update sellers set seller_vacation='$turn_on' where seller_id='$seller_id'";
	
$run_seller = mysqli_query($con,$update_seller);
	
}

if($_POST['turn_off'] == "off"){
	
$seller_id = $_POST['seller_id'];

$turn_off = $_POST['turn_off'];
	
$update_seller = "update sellers set seller_vacation='$turn_off' where seller_id='$seller_id'";
	
$run_seller = mysqli_query($con,$update_seller);
	
}

?>