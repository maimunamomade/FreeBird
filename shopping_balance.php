<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "

<script>

window.open('login.php','_self');

</script>

";
	
}


$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

if(isset($_POST['checkout_submit_order'])){
	
$proposal_id = $_POST['proposal_id'];

$proposal_qty = $_POST['proposal_qty'];

$amount = $_POST['amount'];

$update_buyer_balance = "update seller_accounts set used_purchases=used_purchases+$amount,current_balance=current_balance-$amount where seller_id='$login_seller_id'";

$run_buyer_balance = mysqli_query($con, $update_buyer_balance);

if($run_buyer_balance){

$_SESSION['checkout_seller_id'] = $login_seller_id;

$_SESSION['proposal_id'] = $proposal_id;

$_SESSION['proposal_qty'] = $proposal_qty;

$_SESSION['proposal_price'] = $amount;

$_SESSION['method'] = "shopping_balance";

echo "

<script>

window.open('order.php','_self');

</script>

";
	
	
}

	
	
}


if(isset($_POST['cart_submit_order'])){
	
$amount = $_POST['amount'];
	
$update_balance = "update seller_accounts set used_purchases=used_purchases+$amount,current_balance=current_balance-$amount where seller_id='$login_seller_id'";
	
$run_update_balance = mysqli_query($con,$update_balance);
	
if($run_update_balance){
	
$_SESSION['cart_seller_id'] = $login_seller_id;
	
$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order.php','_self');</script>";
	
}
	
	
}


if(isset($_POST['pay_featured_proposal_listing'])){
	
$proposal_id = $_POST['proposal_id'];

$amount = $_POST['amount'];
	
$update_balance = "update seller_accounts set used_purchases=used_purchases+$amount,current_balance=current_balance-$amount where seller_id='$login_seller_id'";
	
$run_update_balance = mysqli_query($con,$update_balance);
	
if($run_update_balance){
	
$_SESSION['proposal_id'] = $proposal_id;
	
echo "<script>window.open('proposals/featured_proposal.php','_self');</script>";
	
}
	
	
}

if(isset($_POST['view_offers_submit_order'])){
	
$offer_id = $_POST['offer_id'];

$amount = $_POST['amount'];
	
	
$update_balance = "update seller_accounts set used_purchases=used_purchases+$amount,current_balance=current_balance-$amount where seller_id='$login_seller_id'";
	
$run_update_balance = mysqli_query($con,$update_balance);
	
if($run_update_balance){
	
$_SESSION['offer_id'] = $offer_id;

$_SESSION['offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order.php','_self');</script>";
	
}
	
	
}

if(isset($_POST['message_offer_submit_order'])){
	
$offer_id = $_POST['offer_id'];

$amount = $_POST['amount'];
	
	
$update_balance = "update seller_accounts set used_purchases=used_purchases+$amount,current_balance=current_balance-$amount where seller_id='$login_seller_id'";
	
$run_update_balance = mysqli_query($con,$update_balance);
	
if($run_update_balance){
	
$_SESSION['message_offer_id'] = $offer_id;

$_SESSION['message_offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order.php','_self');</script>";
	
	
}
	
	
}
