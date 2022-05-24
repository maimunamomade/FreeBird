<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con,$get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$featured_duration = $row_payment_settings['featured_duration'];

if(isset($_SESSION['proposal_id'])){
	
$proposal_id = $_SESSION['proposal_id'];

$update_featured = "update proposals set proposal_featured='yes' where proposal_id='$proposal_id'";

$run_featured = mysqli_query($con,$update_featured);

if($run_featured){
	
$end_date = date("F d, Y h:i:s", strtotime(" + $featured_duration days"));
	
$insert_featured_proposal = "insert into featured_proposals (proposal_id,end_date) values ('$proposal_id','$end_date')";
	
$run_featured_proposal = mysqli_query($con,$insert_featured_proposal);
	
unset($_SESSION['proposal_id']);
	
echo "<script>alert('Congrats, Your Proposal has been feature listed on this website.')</script>";

 echo "

<script>

window.open('view_proposals.php','_self');

</script>

";
	
}

	
}

?>