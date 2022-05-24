<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "

<script>

window.open('../login.php','_self');

</script>

";
	
}

include("../stripe_config.php");

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_email = $row_login_seller['seller_email'];


$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con,$get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$stripe_currency_code = $row_payment_settings['stripe_currency_code'];


$offer_id = $_POST['offer_id'];

$amount = $_POST['amount'];

$token = $_POST['stripeToken'];


$customer = \Stripe\Customer::create(array(
      'email' => $login_seller_email,
      'card'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $amount,
      'currency' => $stripe_currency_code
  ));

  
$_SESSION['offer_id'] = $offer_id;

$_SESSION['offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "stripe";
	
echo "

<script>

window.open('../order.php','_self');

</script>

";
  

?>