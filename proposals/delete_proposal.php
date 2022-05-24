<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

if(isset($_GET['proposal_id'])){
	
$proposal_id = $_GET['proposal_id'];

$delete_proposal = "delete from proposals where proposal_id='$proposal_id'";

$run_proposal = mysqli_query($con,$delete_proposal);
	
if($run_proposal){
	
echo "<script>alert('One proposal has been deleted.');</script>";
	
echo "<script>window.open('view_proposals.php','_self');</script>";
	
}
	
}

?>