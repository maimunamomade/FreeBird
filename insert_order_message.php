<?php

@session_start();

include("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$order_id = $_POST['order_id'];


$get_orders = "select * from orders where order_id='$order_id'";

$run_orders = mysqli_query($con,$get_orders);

$row_orders = mysqli_fetch_array($run_orders);

$seller_id = $row_orders['seller_id'];

$buyer_id = $row_orders['buyer_id'];

$order_status = $row_orders['order_status'];

$order_duration = substr($row_orders['order_duration'],0,1);

$date_time = date("M d, Y h:i:s");

$order_time = date("M d, Y h:i:s", strtotime($date_time . " + $order_duration days"));


$message = mysqli_real_escape_string($con,$_POST['message']);

$file = $_POST['file'];

date_default_timezone_set("Asia/Karachi");

$last_update_date = date("h:i: M d, Y");


$get_order_conversations = "select * from order_conversations where order_id='$order_id' and sender_id='$buyer_id'";

$run_order_conversations = mysqli_query($con,$get_order_conversations);

$count_order_conversations = mysqli_num_rows($run_order_conversations);


if($buyer_id == $login_seller_id AND $order_status == "pending"){
	
	
if($count_order_conversations == 0){
	
	
	$update_order = "update orders set order_status='progress',order_time='$order_time' where order_id='$order_id'";
	
	$run_update = mysqli_query($con,$update_order);
	
	echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
	
}
	
	
}


if($seller_id == $login_seller_id){
	
	$receiver_id = $buyer_id;
	
}else{
	
		$receiver_id = $seller_id;
	
}

$insert_order_conversations = "insert into order_conversations (order_id,sender_id,message,file,date,reason,status) values ('$order_id','$login_seller_id','$message','$file','$last_update_date','','message')";

$run_order_conversations = mysqli_query($con,$insert_order_conversations);

if($run_order_conversations){
	
$insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$receiver_id','$login_seller_id','$order_id','order_message','$last_update_date','unread')";	

$run_notification = mysqli_query($con,$insert_notification);
	
}


?>