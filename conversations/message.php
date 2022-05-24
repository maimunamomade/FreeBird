<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];


if(isset($_GET['seller_id'])){
	
$get_receiver_id = $_GET['seller_id'];
	
if(isset($_GET['offer_id'])){
	
$offer_id = $_GET['offer_id'];
	
}else{
	
$offer_id = "0";
	
}
	
if($login_seller_id == $get_receiver_id){
	
echo "<script>window.open('../index.php','_self')</script>";
	
}

$get_inbox_sellers = "select * from inbox_sellers where sender_id='$login_seller_id' and receiver_id='$get_receiver_id' or sender_id='$get_receiver_id' and receiver_id='$login_seller_id'";

$run_inbox_sellers = mysqli_query($con,$get_inbox_sellers);
	
$count_inbox_sellers = mysqli_num_rows($run_inbox_sellers);
	
$row_inbox_sellers = mysqli_fetch_array($run_inbox_sellers);
	
$old_message_group_id = $row_inbox_sellers['message_group_id'];
	
if($count_inbox_sellers == 0){
	
$message_status = "empty";

$new_message_group_id = mt_rand();

$insert_inbox_sellers = "insert into inbox_sellers (message_group_id,message_id,offer_id,sender_id,receiver_id,message_status) values ('$new_message_group_id','','$offer_id','$login_seller_id','$get_receiver_id','$message_status')";

$run_inbox_sellers = mysqli_query($con,$insert_inbox_sellers);

if($run_inbox_sellers){
	
echo "<script>window.open('insert_message.php?single_message_id=$new_message_group_id','_self')</script>";
	
}

	
}else{
	
echo "<script>window.open('insert_message.php?single_message_id=$old_message_group_id','_self')</script>";
	
}

	
}else{
	
echo "<script>window.open('../index.php','_self')</script>";
	
}



?>