<?php

session_start();

include("db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "<script> 
	
	alert('Please Login To Your email, And Then Click The Link To Activate Your Account.');
	
	window.open('../login.php','_self'); 
	
	</script>";
}

$seller_user_name = $_SESSION['seller_user_name'];

$select_seller = "select * from sellers where seller_user_name='$seller_user_name'";

$run_seller = mysqli_query($con, $select_seller);

$row_seller = mysqli_fetch_array($run_seller);

$seller_id = $row_seller['seller_id'];

if (isset($_GET['code'])) {

	$verification_code = $_GET['code'];

	$select_seller = "select * from sellers where seller_verification='$verification_code'";

	$run_seller = mysqli_query($con, $select_seller);

	$count_seller = mysqli_num_rows($run_seller);

	if ($count_seller != 0) {

		$update_seller = "update sellers set seller_verification='ok' where seller_id='$seller_id' AND seller_verification='$verification_code'";

		$run_update = mysqli_query($con, $update_seller);

		if ($run_update) {

			echo "
	
	<script>
	
	alert('Your Account Has Been Successfuly Activated.');
	
	window.open('../index.php','_self');
	
	</script>
	
	";
		}
	} else {

		echo "
	
	<script>
	
	alert('Your Account Activation And Email Verification Link Is Invalid.');
	
	window.open('../index.php','_self');
	
	</script>
	
	";
	}
}
 