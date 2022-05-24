<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

if(isset($_GET['request_id'])){
	
$request_id = $_GET['request_id'];

$update_request = "update buyer_requests set request_status='pause' where request_id='$request_id'";

$run_request = mysqli_query($con,$update_request);	
	
if($run_request){
	
echo "<script>alert('One Request Has Been Paused.');</script>";
	
echo "<script>window.open('manage_requests.php','_self')</script>";
	
}
	
}

?>