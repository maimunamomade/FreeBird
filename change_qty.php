<?php

include("includes/db.php");

if(isset($_POST['proposal_id'])){
	
$seller_id = $_POST['seller_id'];

$proposal_id = $_POST['proposal_id'];

$proposal_qty = $_POST['proposal_qty'];
	
$update_cart = "update cart set proposal_qty='$proposal_qty' where seller_id='$seller_id' AND proposal_id='$proposal_id'";
	
$run_update_cart = mysqli_query($con,$update_cart);
	
}


?>