<?php

session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "<script>window.open('../login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];


$proposal_id = mysqli_real_escape_string($con, $_POST['proposal_id']);

$request_id = mysqli_real_escape_string($con, $_POST['request_id']);

$description = mysqli_real_escape_string($con, $_POST['description']);

$delivery_time = mysqli_real_escape_string($con, $_POST['delivery_time']);

$amount = mysqli_real_escape_string($con, $_POST['amount']);



$insert_offer = "insert into send_offers (request_id,sender_id,proposal_id,description,delivery_time,amount,status) values ('$request_id','$login_seller_id','$proposal_id','$description','$delivery_time','$amount','active')";

$run_offer = mysqli_query($con, $insert_offer);


$update_seller = "update sellers set seller_offers=seller_offers-1 where seller_id='$login_seller_id'";

$run_seller = mysqli_query($con, $update_seller);


if ($run_offer) {

	echo "<script>alert('Your Offer Has Been Submitted Successfuly')</script>";

	echo "<script>window.open('$site_url/requests/buyer_requests.php','_self')</script>";
}

 