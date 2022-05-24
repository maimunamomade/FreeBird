<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

if(isset($_GET['proposal_id'])){
	
$proposal_id = $_GET['proposal_id'];

$update_proposal  = "update proposals set proposal_status='pending' where proposal_id='$proposal_id'";	

$run_proposal = mysqli_query($con,$update_proposal);
	
if($run_proposal){
	
$delete_modifications = "delete from proposal_modifications where proposal_id='$proposal_id'";
	
$run_modifications = mysqli_query($con,$delete_modifications);
	
echo "<script>alert('your proposal has been sent to pending approval.');</script>";
	
echo "<script>window.open('view_proposals.php','_self');</script>";
	
}
	
}
