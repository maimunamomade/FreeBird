<?php

session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "<script>window.open('login.php','_self')</script>";
}

if (isset($_POST['withdraw'])) {


	$get_payment_settings = "select * from payment_settings";

	$run_payment_setttings = mysqli_query($con, $get_payment_settings);

	$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

	$withdrawal_limit = $row_payment_settings['withdrawal_limit'];

	$paypal_email = $row_payment_settings['paypal_email'];

	$paypal_api_username = $row_payment_settings['paypal_api_username'];

	$paypal_api_password = $row_payment_settings['paypal_api_password'];

	$paypal_api_signature = $row_payment_settings['paypal_api_signature'];

	$paypal_app_id = $row_payment_settings['paypal_app_id'];

	$paypal_sandbox = $row_payment_settings['paypal_sandbox'];


	if ($paypal_sandbox == "on") {

		$apiUrl = "https://svcs.sandbox.paypal.com/AdaptivePayments/";
	} elseif ($paypal_sandbox == "off") {

		$apiUrl = "https://svcs.paypal.com/AdaptivePayments/";
	}


	$login_seller_user_name = $_SESSION['seller_user_name'];

	$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

	$run_login_seller = mysqli_query($con, $select_login_seller);

	$row_login_seller = mysqli_fetch_array($run_login_seller);

	$login_seller_id = $row_login_seller['seller_id'];

	$login_seller_paypal_email = $row_login_seller['seller_paypal_email'];


	$get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

	$run_seller_accounts = mysqli_query($con, $get_seller_accounts);

	$row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

	$current_balance = $row_seller_accounts['current_balance'];


	$amount = $_POST['amount'];

	if ($amount > $withdrawal_limit or $amount == $withdrawal_limit) {


		if ($amount < $current_balance or $amount == $current_balance) {


			class pay
			{

				function __construct()
				{

					global $paypal_api_username;

					global $paypal_api_password;

					global $paypal_api_signature;

					global $paypal_app_id;

					$this->headers = array(

						"X-PAYPAL-SECURITY-USERID: " . $paypal_api_username,

						"X-PAYPAL-SECURITY-PASSWORD: " . $paypal_api_password,

						"X-PAYPAL-SECURITY-SIGNATURE: " . $paypal_api_signature,

						"X-PAYPAL-REQUEST-DATA-FORMAT: JSON",

						"X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",

						"X-PAYPAL-APPLICATION-ID: " . $paypal_app_id,

					);
				}

				function paypalSend($data, $call)
				{

					global $apiUrl;

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, $apiUrl . $call);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

					return json_decode(curl_exec($ch), TRUE);
				}

				function payRequest()
				{

					global $con;

					global $paypal_email;

					global $login_seller_id;

					global $login_seller_paypal_email;

					global $amount;

					global $site_url;

					$createPacket = array(

						"actionType" => "PAY",

						"currencyCode" => "INR",

						"senderEmail" => "$paypal_email",

						"receiverList" => array(

							"receiver" => array(

								"email" => "$login_seller_paypal_email",

								"amount" => "$amount.00"

							)

						),

						"returnUrl" => "$site_url/revenue.php",

						"cancelUrl" => "$site_url/revenue.php",

						"requestEnvelope" => array(

							"errorLanguage" => "en_US",

							"detailLevel" => "ReturnAll"

						)

					);

					$response = $this->paypalSend($createPacket, "Pay");

					$response_status = $response["paymentInfoList"]["paymentInfo"]["0"]["transactionStatus"];

					$detailsPacket = array(

						"requestEnvelope" => array(

							"errorLanguage" => "en_US",

							"detailLevel" => "ReturnAll"

						),

						"payKey" => $response["payKey"],

						"receiverOptions" => array(

							"receiver" => array("email" => "$login_seller_paypal_email"),

							"InvoiceData" => array(

								"item" => array("name" => "FreeBird.com Revenues Withdraw Payment.")

							)

						)

					);

					$responseDetails = $this->paypalSend($detailsPacket, "SetPaymentOptions");


					if ($response_status == "COMPLETED") {

						$update_seller_accounts = "update seller_accounts set current_balance=current_balance-$amount,withdrawn=withdrawn+$amount where seller_id='$login_seller_id'";

						$run_seller_accounts = mysqli_query($con, $update_seller_accounts);

						if ($run_seller_accounts) {

							echo "<script>alert('Your Money ₹$amount Has Been Sent To Your Paypal Account Successfully.');</script>";

							echo "<script>window.open('$site_url/revenue.php','_self')</script>";
						}
					} else {

						echo "<script>alert('Sorry An error occurred During Sending Your Money ₹$amount To Your Paypal Account.');</script>";

						echo "<script>window.open('$site_url/revenue.php','_self')</script>";
					}
				}
			}

			$Pay = new pay();

			$Pay->payRequest();
		} else {

			echo "<script>alert('The Entered Amount Is To Higher Then Your Current Balance.');</script>";

			echo "<script>window.open('revenue.php','_self')</script>";
		}
	} else {

		echo "<script>alert('Minimum Withdrawal Amount Is ₹$withdrawal_limit Rupees.');</script>";

		echo "<script>window.open('revenue.php','_self')</script>";
	}
}
