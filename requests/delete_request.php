<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

if(isset($_GET['request_id'])){
	
$request_id = $_GET['request_id'];

$delete_request = "delete from buyer_requests where request_id='$request_id'";

$run_request = mysqli_query($con,$delete_request);	


$delete_send_offers = "delete from send_offers where request_id='$request_id'";
	
$run_delete_send_offers = mysqli_query($con,$delete_send_offers);
	
if($run_request){
	
echo "<script>alert('One Request Has Been Deleted.');</script>";
	
echo "<script>window.open('manage_requests.php','_self')</script>";
	
}
	
}

?>