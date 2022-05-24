<?php

@session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];


$receiver_seller_id = $_POST['receiver_id'];

$proposal_id = $_POST['proposal_id'];

$message = mysqli_real_escape_string($con,$_POST['message']);

$file = $_POST['file'];

$description = $_POST['description'];

$delivery_time = $_POST['delivery_time'];

$amount = $_POST['amount'];


$insert_offer = "insert into messages_offers (sender_id,proposal_id,description,delivery_time,amount,status) values ('$login_seller_id','$proposal_id','$description','$delivery_time','$amount','active')";

$run_offer = mysqli_query($con,$insert_offer);

$last_offer_id = mysqli_insert_id($con);

if($run_offer){
	
date_default_timezone_set("Asia/Kolkata");
	
$message_date = date("h:i: F d, Y");
	
$message_status = "unread";
	

$get_inbox_sellers = "select * from inbox_sellers where sender_id='$login_seller_id' and receiver_id='$receiver_seller_id' or sender_id='$receiver_seller_id' and receiver_id='$login_seller_id'";

$run_inbox_sellers = mysqli_query($con,$get_inbox_sellers);

$row_inbox_sellers = mysqli_fetch_array($run_inbox_sellers);

$message_group_id = $row_inbox_sellers['message_group_id'];
	

$insert_message = "insert into inbox_messages (message_sender,message_receiver,message_offer_id,message_group_id,message_desc,message_file,message_date,message_status) values ('$login_seller_id','$receiver_seller_id','$last_offer_id','$message_group_id','$message','$file','$message_date','$message_status')";

$run_message = mysqli_query($con,$insert_message);

$last_message_id = mysqli_insert_id($con);


$update_inbox_sellers = "update inbox_sellers set sender_id='$login_seller_id',receiver_id='$receiver_seller_id',message_status='$message_status',message_id='$last_message_id' where message_group_id='$message_group_id'";

$run_update_inbox_sellers = mysqli_query($con,$update_inbox_sellers);


if($run_update_inbox_sellers){
	
	
$select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$login_seller_id' AND hide_seller_id='$receiver_seller_id'";

$run_hide_seller_messages = mysqli_query($con,$select_hide_seller_messages);

$count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);
	
if($count_hide_seller_messages == 1){
	
$delete_hide_seller_messages = "delete from hide_seller_messages where hider_id='$login_seller_id' and hide_seller_id='$receiver_seller_id'";
	
$run_delete_hide_seller_messages = mysqli_query($con,$delete_hide_seller_messages);
	
	
}
	
$get_general_settings = "select * from general_settings";
	
$run_general_settings = mysqli_query($con,$get_general_settings);

$row_general_settings = mysqli_fetch_array($run_general_settings);

$site_email_address = $row_general_settings['site_email_address'];	


$select_seller = "select * from sellers where seller_id='$receiver_seller_id'";
	
$run_seller = mysqli_query($con,$select_seller);
	
$row_seller = mysqli_fetch_array($run_seller);
	
$seller_user_name = $row_seller['seller_user_name'];

$seller_email = $row_seller['seller_email'];


$subject = "You've received a message from $login_seller_user_name";

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

<img src='$site_url/images/logo.png' width='100'>

<h2> You've received a message from $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $seller_user_name </p>

<p class='lead'> $login_seller_user_name left you a message in your inbox </p>

<p class='lead'> $message </p>

<center>

<a href='$site_url/conversations/insert_message.php?single_message_id=$message_group_id' class='btn'>

View & Reply

</a>

</center>

</div>

</div>

</body>

</html>

";
	
$headers = "From: $site_email_address\r\n";

$headers .= "Content-type: text/html\r\n";
	
mail($seller_email,$subject,$message,$headers);

echo "<script>window.open('insert_message.php?single_message_id=$message_group_id','_self')</script>";

	
}
	
	
	
	
}
