<?php

session_start();

include("db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "<script> window.open('../login.php','_self'); </script>";
}

$seller_user_name = $_SESSION['seller_user_name'];

$select_seller = "select * from sellers where seller_user_name='$seller_user_name'";

$run_seller = mysqli_query($con, $select_seller);

$row_seller = mysqli_fetch_array($run_seller);

$seller_email = $row_seller['seller_email'];

$seller_verification = $row_seller['seller_verification'];


$from = "maimunamomade@gmail.com";

$subject = "FreeBird: Activate Your New Account";

$message = "

<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
}

.box {
	background: #fff;
	margin: 0px 0px 30px;
	padding: 8px 20px 20px 20px;
	border:1px solid #e6e6e6;
	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	
}

.lead {
	font-size:16px;
	
}

.btn{
	background:green;
	margin-top:20px;
	color:white;
	text-decoration:none;
	padding:10px 16px;
	font-size:18px;
	border-radius:3px;
	
}

hr{
	margin-top:20px;
	margin-bottom:20px;
	border:1px solid #eee;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img class='logo' src='$site_url/images/logo.png' width='100' >

<h2> Hi $seller_user_name, Welcome To FreeBird </h2>

<p class='lead'> Are you ready to get started? </p>

<br>

<a href='$site_url/includes/verify-email.php?code=$seller_verification' class='btn'>
 Click Here To Activate Your Account 
</a>

<hr>

<p class='lead'>
If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/includes/verify-email.php?code=$seller_verification
</p>

</center>

</div>

</div>

</body>

</html>

";

$headers = "From: $from\r\n";

$headers .= "content-type: text/html\r\n";

mail($seller_email, $subject, $message, $headers);
 