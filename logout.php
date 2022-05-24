<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
	echo "<script> window.open('index.php','_self') </script>";
	
}


$seller_user_name = $_SESSION['seller_user_name'];


$get_seller = "select * from sellers where seller_user_name='$seller_user_name'";
	
$run_seller = mysqli_query($con,$get_seller);
	
$row_seller = mysqli_fetch_array($run_seller);
	
$seller_status = $row_seller['seller_status'];


if($seller_status != "block-ban"){

$update_seller_status = "update sellers set seller_status='away' where seller_user_name='$seller_user_name'"; 

$run_seller_status = mysqli_query($con,$update_seller_status); 

}

unset($_SESSION['seller_user_name']);

echo "<script> window.open('index.php','_self') </script>";

?>