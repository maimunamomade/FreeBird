<?php


session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "

<script>

window.open('login.php','_self');

</script>

";
}

if (isset($_SESSION['seller_user_name'])) {


	$login_seller_user_name = $_SESSION['seller_user_name'];

	$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

	$run_login_seller = mysqli_query($con, $select_login_seller);

	$row_login_seller = mysqli_fetch_array($run_login_seller);

	$login_seller_id = $row_login_seller['seller_id'];


	$get_payment_settings = "select * from payment_settings";

	$run_payment_setttings = mysqli_query($con, $get_payment_settings);

	$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

	$processing_fee = $row_payment_settings['processing_fee'];


	/// Single Proposal Checkout Order Code Starts ///

	if (isset($_SESSION['checkout_seller_id'])) {

		$buyer_id = $_SESSION['checkout_seller_id'];

		$proposal_id = $_SESSION['proposal_id'];

		$order_price = $_SESSION['proposal_price'];

		$proposal_qty = $_SESSION['proposal_qty'];

		$payment_method = $_SESSION['method'];


		$select_proposal = "select * from proposals where proposal_id='$proposal_id'";

		$run_proposal = mysqli_query($con, $select_proposal);

		$row_proposal = mysqli_fetch_array($run_proposal);

		$proposal_title = $row_proposal['proposal_title'];

		$proposal_seller_id = $row_proposal['proposal_seller_id'];

		$delivery_id = $row_proposal['delivery_id'];


		$select_delivery_time = "select * from delivery_times where delivery_id='$delivery_id'";

		$run_delivery_time = mysqli_query($con, $select_delivery_time);

		$row_delivery_time = mysqli_fetch_array($run_delivery_time);

		$delivery_proposal_title = $row_delivery_time['delivery_proposal_title'];

		$add_days = substr($delivery_proposal_title, 0, 1);

		date_default_timezone_set("UTC");

		$order_date = date("F d, Y");

		$date_time = date("M d, Y h:i:s");

		$order_time = date("M d, Y h:i:s", strtotime($date_time . " + $add_days days"));

		$order_number = mt_rand();

		if ($payment_method == "shopping_balance") {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_proposal_title','$order_time','$order_date','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','','yes','pending')";
		} else {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_proposal_title','$order_time','$order_date','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','$processing_fee','yes','pending')";
		}

		$run_order = mysqli_query($con, $insert_order);

		$insert_order_id = mysqli_insert_id($con);


		if ($run_order) {

			$select_proposal_seller = "select * from sellers where seller_id='$proposal_seller_id'";

			$run_proposal_seller = mysqli_query($con, $select_proposal_seller);

			$row_proposal_seller = mysqli_fetch_array($run_proposal_seller);

			$proposal_seller_user_name = $row_proposal_seller['seller_user_name'];

			$proposal_seller_email = $row_proposal_seller['seller_email'];

			$select_general_settings = "select * from general_settings";

			$run_general_settings = mysqli_query($con, $select_general_settings);

			$row_general_settings = mysqli_fetch_array($run_general_settings);

			$site_email_address = $row_general_settings['site_email_address'];


			$subject = "FreeBird: Congrats! You Have A New Order From $login_seller_user_name";

			$email_message = "

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

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/logo.png' width='100' >

<h2> You Have Been Just Received An Order From $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, Orer Details </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_proposal_title</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>

<center>

<a href='$site_url/order_details.php?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

			$headers = "From: FreeBird.com\r\n";

			$headers .= "Reply-To: $site_email_address\r\n";

			$headers .= "Content-type: text/html\r\n";

			mail($proposal_seller_email, $subject, $email_message, $headers);


			$select_my_buyer = "select * from my_buyers where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

			$run_my_buyer = mysqli_query($con, $select_my_buyer);

			$count_my_buyer = mysqli_num_rows($run_my_buyer);

			if ($count_my_buyer == 1) {

				$update_my_buyer = "update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

				$run_my_buyer = mysqli_query($con, $update_my_buyer);
			} else {

				$insert_my_buyer = "insert into my_buyers (seller_id,buyer_id,completed_orders,amount_spent,last_order_date) values ('$proposal_seller_id','$login_seller_id','1','$order_price','$order_date')";

				$run_my_buyer = mysqli_query($con, $insert_my_buyer);
			}


			$select_my_seller = "select * from my_sellers where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

			$run_my_seller = mysqli_query($con, $select_my_seller);

			$count_my_seller = mysqli_num_rows($run_my_seller);

			if ($count_my_seller == 1) {

				$update_my_seller = "update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

				$run_my_seller = mysqli_query($con, $update_my_seller);
			} else {

				$insert_my_seller = "insert into my_sellers (buyer_id,seller_id,completed_orders,amount_spent,last_order_date) values ('$login_seller_id','$proposal_seller_id','1','$order_price','$order_date')";

				$run_my_seller = mysqli_query($con, $insert_my_seller);
			}

			$total_amount = $order_price + $processing_fee;

			if ($payment_method == "shopping_balance") {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$order_price','$order_date','$payment_method')";
			} else {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$total_amount','$order_date','$payment_method')";
			}

			$run_purchase = mysqli_query($con, $insert_purchase);

			$insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$proposal_seller_id','$login_seller_id','$insert_order_id','order','$order_date','unread')";

			$run_notification = mysqli_query($con, $insert_notification);


			unset($_SESSION['checkout_seller_id']);

			unset($_SESSION['proposal_id']);

			unset($_SESSION['proposal_qty']);

			unset($_SESSION['proposal_price']);

			unset($_SESSION['method']);

			echo "

<script>

alert('Your Order Has Been Successsfully Submitted, Thanks.');

window.open('order_details.php?order_id=$insert_order_id','_self');

</script>


";
		}
	}

	/// Single Proposal Checkout Order Code Ends ///


	/// Cart Proposals Order Code Starts ///

	if (isset($_SESSION['cart_seller_id'])) {

		$buyer_id = $_SESSION['cart_seller_id'];

		$payment_method = $_SESSION['method'];


		$sel_cart = "select * from cart where seller_id='$buyer_id'";

		$run_cart = mysqli_query($con, $sel_cart);

		while ($row_cart = mysqli_fetch_array($run_cart)) {

			$proposal_id = $row_cart['proposal_id'];

			$proposal_price = $row_cart['proposal_price'];

			$proposal_qty = $row_cart['proposal_qty'];

			$sub_total = $proposal_price * $proposal_qty;

			$order_price = $sub_total;


			$select_proposal = "select * from proposals where proposal_id='$proposal_id'";

			$run_proposal = mysqli_query($con, $select_proposal);

			$row_proposal = mysqli_fetch_array($run_proposal);

			$proposal_title = $row_proposal['proposal_title'];

			$proposal_seller_id = $row_proposal['proposal_seller_id'];

			$delivery_id = $row_proposal['delivery_id'];


			$select_delivery_time = "select * from delivery_times where delivery_id='$delivery_id'";

			$run_delivery_time = mysqli_query($con, $select_delivery_time);

			$row_delivery_time = mysqli_fetch_array($run_delivery_time);

			$delivery_proposal_title = $row_delivery_time['delivery_proposal_title'];

			$add_days = substr($delivery_proposal_title, 0, 1);

			date_default_timezone_set("UTC");

			$order_date = date("F d, Y");

			$date_time = date("M d, Y h:i:s");

			$order_time = date("M d, Y h:i:s", strtotime($date_time . " + $add_days days"));

			$order_number = mt_rand();



			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_proposal_title','$order_time','$order_date','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','','yes','pending')";



			$run_order = mysqli_query($con, $insert_order);

			$insert_order_id = mysqli_insert_id($con);


			if ($run_order) {

				$select_proposal_seller = "select * from sellers where seller_id='$proposal_seller_id'";

				$run_proposal_seller = mysqli_query($con, $select_proposal_seller);

				$row_proposal_seller = mysqli_fetch_array($run_proposal_seller);

				$proposal_seller_user_name = $row_proposal_seller['seller_user_name'];

				$proposal_seller_email = $row_proposal_seller['seller_email'];

				$select_general_settings = "select * from general_settings";

				$run_general_settings = mysqli_query($con, $select_general_settings);

				$row_general_settings = mysqli_fetch_array($run_general_settings);

				$site_email_address = $row_general_settings['site_email_address'];


				$subject = "FreeBird: Congrats! You Have A New Order From $login_seller_user_name";

				$email_message = "

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

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/logo.png' width='100' >

<h2> You Have Been Just Received An Order From $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, Orer Details </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_proposal_title</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>

<center>

<a href='$site_url/order_details.php?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

				$headers = "From: FreeBird.com\r\n";

				$headers .= "Reply-To: $site_email_address\r\n";

				$headers .= "Content-type: text/html\r\n";

				mail($proposal_seller_email, $subject, $email_message, $headers);


				$select_my_buyer = "select * from my_buyers where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

				$run_my_buyer = mysqli_query($con, $select_my_buyer);

				$count_my_buyer = mysqli_num_rows($run_my_buyer);

				if ($count_my_buyer == 1) {

					$update_my_buyer = "update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

					$run_my_buyer = mysqli_query($con, $update_my_buyer);
				} else {

					$insert_my_buyer = "insert into my_buyers (seller_id,buyer_id,completed_orders,amount_spent,last_order_date) values ('$proposal_seller_id','$login_seller_id','1','$order_price','$order_date')";

					$run_my_buyer = mysqli_query($con, $insert_my_buyer);
				}


				$select_my_seller = "select * from my_sellers where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

				$run_my_seller = mysqli_query($con, $select_my_seller);

				$count_my_seller = mysqli_num_rows($run_my_seller);

				if ($count_my_seller == 1) {

					$update_my_seller = "update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

					$run_my_seller = mysqli_query($con, $update_my_seller);
				} else {

					$insert_my_seller = "insert into my_sellers (buyer_id,seller_id,completed_orders,amount_spent,last_order_date) values ('$login_seller_id','$proposal_seller_id','1','$order_price','$order_date')";

					$run_my_seller = mysqli_query($con, $insert_my_seller);
				}





				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$order_price','$order_date','$payment_method')";


				$run_purchase = mysqli_query($con, $insert_purchase);

				$insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$proposal_seller_id','$login_seller_id','$insert_order_id','order','$order_date','unread')";

				$run_notification = mysqli_query($con, $insert_notification);
			}
		}

		$delete_cart = "delete from cart where seller_id='$buyer_id'";

		$run_delete = mysqli_query($con, $delete_cart);

		unset($_SESSION['cart_seller_id']);

		unset($_SESSION['method']);

		echo "<script>alert('Your Order Has Been Submitted, Thanks');</script>";

		echo "<script>window.open('buying_orders.php','_self')</script>";
	}

	/// Cart Proposals Order Code Ends ///


	/// Single Offer Order Code Starts ///


	if (isset($_SESSION['offer_id'])) {

		$buyer_id = $_SESSION['offer_buyer_id'];

		$offer_id = $_SESSION['offer_id'];

		$payment_method = $_SESSION['method'];


		$select_offers = "select * from send_offers where offer_id='$offer_id'";

		$run_offers = mysqli_query($con, $select_offers);

		$row_offers = mysqli_fetch_array($run_offers);

		$proposal_id = $row_offers['proposal_id'];

		$description = $row_offers['description'];

		$delivery_time = $row_offers['delivery_time'];

		$order_price = $row_offers['amount'];

		$proposal_qty = "1";


		$select_proposal = "select * from proposals where proposal_id='$proposal_id'";

		$run_proposal = mysqli_query($con, $select_proposal);

		$row_proposal = mysqli_fetch_array($run_proposal);

		$proposal_title = $row_proposal['proposal_title'];

		$proposal_seller_id = $row_proposal['proposal_seller_id'];



		$add_days = substr($delivery_time, 0, 1);

		date_default_timezone_set("UTC");

		$order_date = date("F d, Y");

		$date_time = date("M d, Y h:i:s");

		$order_time = date("M d, Y h:i:s", strtotime($date_time . " + $add_days days"));

		$order_number = mt_rand();

		if ($payment_method == "shopping_balance") {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,order_description,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_time','$order_time','$order_date','$description','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','','yes','pending')";
		} else {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,order_description,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_time','$order_time','$order_date','$description','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','$processing_fee','yes','pending')";
		}

		$run_order = mysqli_query($con, $insert_order);

		$insert_order_id = mysqli_insert_id($con);


		if ($run_order) {

			$update_offer_status = "update send_offers set status='send' where offer_id='$offer_id'";

			$run_update_offer_status = mysqli_query($con, $update_offer_status);


			$select_proposal_seller = "select * from sellers where seller_id='$proposal_seller_id'";

			$run_proposal_seller = mysqli_query($con, $select_proposal_seller);

			$row_proposal_seller = mysqli_fetch_array($run_proposal_seller);

			$proposal_seller_user_name = $row_proposal_seller['seller_user_name'];

			$proposal_seller_email = $row_proposal_seller['seller_email'];

			$select_general_settings = "select * from general_settings";

			$run_general_settings = mysqli_query($con, $select_general_settings);

			$row_general_settings = mysqli_fetch_array($run_general_settings);

			$site_email_address = $row_general_settings['site_email_address'];


			$subject = "Computerfever: Congrats! You Have A New Order From $login_seller_user_name";

			$email_message = "

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

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/logo.png' width='100' >

<h2> You Have Just Received An Order From $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, Orer Details </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_time</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>

<center>

<a href='$site_url/order_details.php?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

			$headers = "From: FreeBird.com\r\n";

			$headers .= "Reply-To: $site_email_address\r\n";

			$headers .= "Content-type: text/html\r\n";

			mail($proposal_seller_email, $subject, $email_message, $headers);


			$select_my_buyer = "select * from my_buyers where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

			$run_my_buyer = mysqli_query($con, $select_my_buyer);

			$count_my_buyer = mysqli_num_rows($run_my_buyer);

			if ($count_my_buyer == 1) {

				$update_my_buyer = "update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

				$run_my_buyer = mysqli_query($con, $update_my_buyer);
			} else {

				$insert_my_buyer = "insert into my_buyers (seller_id,buyer_id,completed_orders,amount_spent,last_order_date) values ('$proposal_seller_id','$login_seller_id','1','$order_price','$order_date')";

				$run_my_buyer = mysqli_query($con, $insert_my_buyer);
			}


			$select_my_seller = "select * from my_sellers where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

			$run_my_seller = mysqli_query($con, $select_my_seller);

			$count_my_seller = mysqli_num_rows($run_my_seller);

			if ($count_my_seller == 1) {

				$update_my_seller = "update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

				$run_my_seller = mysqli_query($con, $update_my_seller);
			} else {

				$insert_my_seller = "insert into my_sellers (buyer_id,seller_id,completed_orders,amount_spent,last_order_date) values ('$login_seller_id','$proposal_seller_id','1','$order_price','$order_date')";

				$run_my_seller = mysqli_query($con, $insert_my_seller);
			}

			$total_amount = $order_price + $processing_fee;

			if ($payment_method == "shopping_balance") {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$order_price','$order_date','$payment_method')";
			} else {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$total_amount','$order_date','$payment_method')";
			}

			$run_purchase = mysqli_query($con, $insert_purchase);

			$insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$proposal_seller_id','$login_seller_id','$insert_order_id','order','$order_date','unread')";

			$run_notification = mysqli_query($con, $insert_notification);

			unset($_SESSION['offer_id']);

			unset($_SESSION['offer_buyer_id']);

			unset($_SESSION['method']);

			echo "

<script>

alert('Your Order Has Been Successsfully Submitted, Thanks.');

window.open('order_details.php?order_id=$insert_order_id','_self');

</script>


";
		}
	}


	/// Single Offer Order Code Ends ///


	/// Message Offer Code Starts ///

	if (isset($_SESSION['message_offer_id'])) {

		$message_offer_id = $_SESSION['message_offer_id'];

		$buyer_id = $_SESSION['message_offer_buyer_id'];

		$payment_method = $_SESSION['method'];


		$select_offer = "select * from messages_offers where offer_id='$message_offer_id'";

		$run_offer = mysqli_query($con, $select_offer);

		$row_offer = mysqli_fetch_array($run_offer);

		$proposal_id = $row_offer['proposal_id'];

		$description = $row_offer['description'];

		$delivery_time = $row_offer['delivery_time'];

		$order_price = $row_offer['amount'];

		$proposal_qty = "1";


		$select_proposal = "select * from proposals where proposal_id='$proposal_id'";

		$run_proposal = mysqli_query($con, $select_proposal);

		$row_proposal = mysqli_fetch_array($run_proposal);

		$proposal_title = $row_proposal['proposal_title'];

		$proposal_seller_id = $row_proposal['proposal_seller_id'];



		$add_days = substr($delivery_time, 0, 1);

		date_default_timezone_set("UTC");

		$order_date = date("F d, Y");

		$date_time = date("M d, Y h:i:s");

		$order_time = date("M d, Y h:i:s", strtotime($date_time . " + $add_days days"));

		$order_number = mt_rand();

		if ($payment_method == "shopping_balance") {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,order_description,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_time','$order_time','$order_date','$description','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','','yes','pending')";
		} else {

			$insert_order = "insert into orders (order_number,order_duration,order_time,order_date,order_description,seller_id,buyer_id,proposal_id,order_price,order_qty,order_fee,order_active,order_status) values ('$order_number','$delivery_time','$order_time','$order_date','$description','$proposal_seller_id','$buyer_id','$proposal_id','$order_price','$proposal_qty','$processing_fee','yes','pending')";
		}

		$run_order = mysqli_query($con, $insert_order);

		$insert_order_id = mysqli_insert_id($con);


		if ($run_order) {

			$update_message_offer_status = "update messages_offers set order_id='$insert_order_id',status='accepted' where offer_id='$message_offer_id'";

			$run_update_message_offer_status = mysqli_query($con, $update_message_offer_status);


			$select_proposal_seller = "select * from sellers where seller_id='$proposal_seller_id'";

			$run_proposal_seller = mysqli_query($con, $select_proposal_seller);

			$row_proposal_seller = mysqli_fetch_array($run_proposal_seller);

			$proposal_seller_user_name = $row_proposal_seller['seller_user_name'];

			$proposal_seller_email = $row_proposal_seller['seller_email'];

			$select_general_settings = "select * from general_settings";

			$run_general_settings = mysqli_query($con, $select_general_settings);

			$row_general_settings = mysqli_fetch_array($run_general_settings);

			$site_email_address = $row_general_settings['site_email_address'];


			$subject = "Computerfever: Congrats! You Have A New Order From $login_seller_user_name";

			$email_message = "

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

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/logo.png' width='100' >

<h2> You Have Just Received An Order From $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, Orer Details </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_time</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>

<center>

<a href='$site_url/order_details.php?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

			$headers = "From: FreeBird.com\r\n";

			$headers .= "Reply-To: $site_email_address\r\n";

			$headers .= "Content-type: text/html\r\n";

			mail($proposal_seller_email, $subject, $email_message, $headers);


			$select_my_buyer = "select * from my_buyers where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

			$run_my_buyer = mysqli_query($con, $select_my_buyer);

			$count_my_buyer = mysqli_num_rows($run_my_buyer);

			if ($count_my_buyer == 1) {

				$update_my_buyer = "update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'";

				$run_my_buyer = mysqli_query($con, $update_my_buyer);
			} else {

				$insert_my_buyer = "insert into my_buyers (seller_id,buyer_id,completed_orders,amount_spent,last_order_date) values ('$proposal_seller_id','$login_seller_id','1','$order_price','$order_date')";

				$run_my_buyer = mysqli_query($con, $insert_my_buyer);
			}


			$select_my_seller = "select * from my_sellers where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

			$run_my_seller = mysqli_query($con, $select_my_seller);

			$count_my_seller = mysqli_num_rows($run_my_seller);

			if ($count_my_seller == 1) {

				$update_my_seller = "update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'";

				$run_my_seller = mysqli_query($con, $update_my_seller);
			} else {

				$insert_my_seller = "insert into my_sellers (buyer_id,seller_id,completed_orders,amount_spent,last_order_date) values ('$login_seller_id','$proposal_seller_id','1','$order_price','$order_date')";

				$run_my_seller = mysqli_query($con, $insert_my_seller);
			}

			$total_amount = $order_price + $processing_fee;

			if ($payment_method == "shopping_balance") {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$order_price','$order_date','$payment_method')";
			} else {

				$insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$login_seller_id','$insert_order_id','$total_amount','$order_date','$payment_method')";
			}

			$run_purchase = mysqli_query($con, $insert_purchase);

			$insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$proposal_seller_id','$login_seller_id','$insert_order_id','order','$order_date','unread')";

			$run_notification = mysqli_query($con, $insert_notification);

			unset($_SESSION['message_offer_id']);

			unset($_SESSION['message_offer_buyer_id']);

			unset($_SESSION['method']);

			echo "

<script>

alert('Your Order Has Been Successsfully Submitted, Thanks.');

window.open('order_details.php?order_id=$insert_order_id','_self');

</script>


";
		}
	}


	/// Message Offer Code Ends ///





}
