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


if(isset($_GET['checkout_seller_id'])){
	
$seller_id = $_GET['checkout_seller_id'];

$proposal_id = $_GET['proposal_id'];

$proposal_qty = $_GET['proposal_qty'];

$proposal_price = $_GET['proposal_price'];

$_SESSION['checkout_seller_id'] = $seller_id;

$_SESSION['proposal_id'] = $proposal_id;

$_SESSION['proposal_qty'] = $proposal_qty;

$_SESSION['proposal_price'] = $proposal_price;

$_SESSION['method'] = "paypal";

echo "

<script>

window.open('order.php','_self');

</script>

";
	
}


if(isset($_GET['cart_seller_id'])){
	
$seller_id = $_GET['cart_seller_id'];
	
$_SESSION['cart_seller_id'] = $seller_id;

$_SESSION['method'] = "paypal";

echo "

<script>

window.open('order.php','_self');

</script>

";
	
}


if(isset($_GET['featured_listing'])){
	
$proposal_id = $_GET['proposal_id'];
	
$_SESSION['proposal_id'] = $proposal_id;

echo "

<script>

window.open('proposals/featured_proposal.php','_self');

</script>

";
	
}


if(isset($_GET["view_offers"])){
	
$offer_id = $_GET["offer_id"];

$_SESSION['offer_id'] = $offer_id;

$_SESSION['offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "paypal";
	
echo "

<script>

window.open('order.php','_self');

</script>

";
	
}

if(isset($_GET['message_offer_id'])){
	
$offer_id = $_GET['message_offer_id'];
	
$_SESSION['message_offer_id'] = $offer_id;

$_SESSION['message_offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "paypal";
	
echo "

<script>

window.open('order.php','_self');

</script>

";
	
}




?>