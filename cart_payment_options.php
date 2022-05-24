<?php

session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con, $get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$processing_fee = $row_payment_settings['processing_fee'];

$enable_paypal = $row_payment_settings['enable_paypal'];

$paypal_email = $row_payment_settings['paypal_email'];

$paypal_currency_code = $row_payment_settings['paypal_currency_code'];

$paypal_sandbox = $row_payment_settings['paypal_sandbox'];

if ($paypal_sandbox == "on") {

    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} elseif ($paypal_sandbox == "off") {

    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

$enable_stripe = $row_payment_settings['enable_stripe'];


$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_email = $row_login_seller['seller_email'];


$get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

$run_seller_accounts = mysqli_query($con, $get_seller_accounts);

$row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

$current_balance = $row_seller_accounts['current_balance'];


$select_cart = "select * from cart where seller_id='$login_seller_id'";

$run_cart = mysqli_query($con, $select_cart);

$count_cart = mysqli_num_rows($run_cart);

$sub_total = 0;

while ($row_cart = mysqli_fetch_array($run_cart)) {

    $proposal_price = $row_cart['proposal_price'];

    $proposal_qty = $row_cart['proposal_qty'];

    $cart_total = $proposal_price * $proposal_qty;

    $sub_total += $cart_total;
}

$total = $sub_total + $processing_fee;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Shopping Cart Payment Options </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
    <?php include("includes/header.php"); ?>


    <!--- container mt-5 mb-3 starts --->
    <div class="container mt-5 mb-3">

        <!--- row starts --->
        <div class="row">

            <!--- col-md-12 starts --->
            <div class="col-md-12">

                <!--- card mb-3 starts --->
                <div class="card mb-3">

                    <!--- card-body starts --->
                    <div class="card-body">

                        <h5 class="float-left">
                            Your Cart (<?php echo $count_cart; ?>)
                        </h5>

                        <h5 class="float-right">
                            <a href="index.php">
                                Continue Shopping
                            </a>
                        </h5>

                    </div>
                    <!--- card-body ends --->

                </div>
                <!--- card mb-3 ends --->

            </div>
            <!--- col-md-12 ends --->

        </div>
        <!--- row ends --->


        <!--- row starts --->
        <div class="row">

            <!--- col-md-7 starts --->
            <div class="col-md-7">

                <!--- row starts --->
                <div class="row">

                    <?php if ($current_balance >= $sub_total) { ?>

                        <!--- col-md-12 mb-3 starts --->
                        <div class="col-md-12 mb-3">

                            <!--- card payment-options starts --->
                            <div class="card payment-options">

                                <!--- card-header starts --->
                                <div class="card-header">
                                    <h5>
                                        Available Shopping Balance
                                    </h5>

                                </div>
                                <!--- card-header ends --->


                                <!--- card-body starts --->
                                <div class="card-body">

                                    <!--- row starts --->
                                    <div class="row">

                                        <!--- col-1 starts --->
                                        <div class="col-1">

                                            <input id="shopping-balance" class="form-control radio-input" type="radio" name="method" checked>

                                        </div>
                                        <!--- col-1 ends --->

                                        <!--- col-11 starts --->
                                        <div class="col-11">
                                            <p class="lead mt-2">
                                                Personal Balance - <?php echo $login_seller_user_name; ?>

                                                <span class="text-success font-weight-bold">
                                                    ₹<?php echo $current_balance; ?>
                                                </span>
                                            </p>

                                        </div>
                                        <!--- col-11 ends --->

                                    </div>
                                    <!--- row ends --->

                                </div>
                                <!--- card-body ends --->

                            </div>
                            <!--- card payment-options ends --->

                        </div>
                        <!--- col-md-12 mb-3 ends --->

                    <?php } ?>

                    <!--- col-md-12 mb-3 starts --->
                    <div class="col-md-12 mb-3">

                        <!--- card payment-options starts --->
                        <div class="card payment-options">

                            <!--- card-header starts --->
                            <div class="card-header">

                                <h5> Payment Options </h5>

                            </div>
                            <!--- card-header ends --->

                            <!--- card-body starts --->
                            <div class="card-body">

                                <?php if ($enable_paypal == "yes") { ?>

                                    <!--- row starts --->
                                    <div class="row">

                                        <!--- col-1 starts --->
                                        <div class="col-1">

                                            <input id="paypal" class="form-control radio-input" type="radio" name="method" <?php

                                                                                                                            if ($current_balance < $sub_total) {
                                                                                                                                echo "checked";
                                                                                                                            }

                                                                                                                            ?>>

                                        </div>
                                        <!--- col-1 ends --->

                                        <!--- col-11 starts --->
                                        <div class="col-11">

                                            <img src="images/paypal.png" height="50" class="ml-2 width-xs-100">

                                        </div>
                                        <!--- col-11 ends --->

                                    </div>
                                    <!--- row ends --->

                                <?php } ?>


                                <?php if ($enable_stripe == "yes") { ?>

                                    <?php if ($enable_paypal == "yes") { ?>

                                        <hr>

                                    <?php } ?>

                                    <!--- row starts --->
                                    <div class="row">

                                        <!--- col-1 starts --->
                                        <div class="col-1">

                                            <input id="credit-card" class="form-control radio-input" type="radio" name="method" <?php

                                                                                                                                if ($current_balance < $sub_total) {

                                                                                                                                    if ($enable_paypal == "no") {

                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                }

                                                                                                                                ?>>

                                        </div>
                                        <!--- col-1 ends --->

                                        <!--- col-11 starts --->
                                        <div class="col-11">

                                            <img src="images/credit_cards.jpg" height="50" class="ml-2 width-xs-100">

                                        </div>
                                        <!--- col-11 ends --->

                                    </div>
                                    <!--- row Ends --->

                                <?php } ?>

                            </div>
                            <!--- card-body Ends --->

                        </div>
                        <!--- card payment-options Ends --->

                    </div>
                    <!--- col-md-12 mb-3 Ends --->

                </div>
                <!--- row Ends --->

            </div>
            <!--- col-md-7 Ends --->


            <!--- col-md-5 starts --->
            <div class="col-md-5">

                <!--- card starts --->
                <div class="card">

                    <!---- card-body cart-order-details starts --->
                    <div class="card-body cart-order-details">

                        <p>
                            Cart Subtotal
                            <span class="float-right">
                                ₹<?php echo $sub_total; ?>
                            </span>
                        </p>

                        <hr>

                        <p class="processing-fee">
                            Processing Fee
                            <span class="float-right">
                                ₹<?php echo $processing_fee; ?>
                            </span>
                        </p>

                        <hr class="processing-fee">

                        <p>
                            Total
                            <span class="float-right font-weight-bold total-price">
                                ₹<?php echo $total; ?>
                            </span>
                        </p>

                        <hr>

                        <?php if ($current_balance >= $sub_total) { ?>

                            <!---- shopping-balance-form starts --->
                            <form action="shopping_balance.php" method="post" id="shopping-balance-form">

                                <input type="hidden" name="amount" value="<?php echo $sub_total; ?>">

                                <button type="submit" name="cart_submit_order" class="btn btn-lg btn-success btn-block" onclick="return confirm('Do You Really Want To Order Proposals Using Your Shopping Balance.')">

                                    Pay With Shopping Balance

                                </button>

                            </form>
                            <!---- shopping-balance-form ends --->

                        <?php } ?>

                        <br>

                        <?php if ($enable_paypal == "yes") { ?>

                            <!--- paypal-form starts --->
                            <form action="<?php echo $paypal_url; ?>" method="post" id="paypal-form">

                                <input type="hidden" name="cmd" value="_cart">

                                <input type="hidden" name="upload" value="1">

                                <input type="hidden" name="handling_cart" value="<?php echo $processing_fee; ?>">

                                <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">

                                <input type="hidden" name="currency_code" value="<?php echo $paypal_currency_code; ?>">

                                <input type="hidden" name="cancel_return" value="<?php echo $site_url; ?>/cart_payment_options.php">

                                <input type="hidden" name="return" value="<?php echo $site_url; ?>/paypal_order.php?cart_seller_id=<?php echo $login_seller_id; ?>">


                                <?php

                                $i = 0;

                                $select_cart = "select * from cart where seller_id='$login_seller_id'";

                                $run_cart = mysqli_query($con, $select_cart);

                                while ($row_cart = mysqli_fetch_array($run_cart)) {

                                    $proposal_id = $row_cart['proposal_id'];

                                    $proposal_price = $row_cart['proposal_price'];

                                    $proposal_qty = $row_cart['proposal_qty'];

                                    $select_proposal = "select * from proposals where proposal_id='$proposal_id'";

                                    $run_proposal = mysqli_query($con, $select_proposal);

                                    $row_proposal = mysqli_fetch_array($run_proposal);

                                    $proposal_title = $row_proposal['proposal_title'];

                                    $i++;

                                    ?>

                                    <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $proposal_title; ?>">

                                    <input type="hidden" name="item_number_<?php echo $i; ?>" value="<?php echo $i; ?>">

                                    <input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo $proposal_price; ?>">

                                    <input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $proposal_qty; ?>">

                                <?php } ?>

                                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block">

                                    Pay With Paypal

                                </button>

                            </form>
                            <!--- paypal-form ends --->

                        <?php } ?>


                        <?php if ($enable_stripe == "yes") { ?>


                            <?php

                            include("stripe_config.php");

                            $stripe_total_amount = $total * 100;

                            ?>

                            <!--- credit-card-form starts --->
                            <form action="cart_charge.php" method="post" id="credit-card-form">

                                <input type="hidden" name="amount" value="<?php echo $stripe_total_amount; ?>">

                                <input type="submit" class="btn btn-lg btn-success btn-block stripe-submit" data-key="<?php echo $stripe['publishable_key']; ?>" value="Pay With Credit Card" data-amount="<?php echo $stripe_total_amount; ?>" data-currency="<?php echo $stripe['currency_code']; ?>" data-email="<?php echo $login_seller_email; ?>" data-name="FreeBird.com" data-image="images/logo.png" data-description="All Cart Proposals Payment" data-allow-remember-me="false">

                                <script>
                                    $(document).ready(function() {
                                        $('.stripe-submit').on('click', function(event) {
                                            event.preventDefault();
                                            var $button = $(this),
                                                $form = $button.parents('form');
                                            var opts = $.extend({}, $button.data(), {
                                                token: function(result) {
                                                    $form.append($('<input>').attr({
                                                        type: 'hidden',
                                                        name: 'stripeToken',
                                                        value: result.id
                                                    })).submit();
                                                }
                                            });
                                            StripeCheckout.open(opts);
                                        });
                                    });
                                </script>

                            </form>
                            <!--- credit-card-form ends --->

                        <?php } ?>

                    </div>
                    <!---- card-body cart-order-details ends --->

                </div>
                <!--- card ends --->

            </div>
            <!--- col-md-5 ends --->

        </div>
        <!--- row ends --->

    </div>
    <!--- container mt-5 mb-3 ends --->



    <script>
        $(document).ready(function() {



            <?php if ($current_balance >= $sub_total) { ?>

                $('.total-price').html('$<?php echo $sub_total; ?>');

                $('.processing-fee').hide();

            <?php } else { ?>

                $('.total-price').html('$<?php echo $total; ?>');

                $('.processing-fee').show();

            <?php } ?>


            <?php if ($current_balance >= $sub_total) { ?>

                $('#paypal-form').hide();

                $('#credit-card-form').hide();

            <?php } else { ?>

                $('#shopping-balance-form').hide();

            <?php } ?>


            <?php if ($current_balance < $sub_total) { ?>

                <?php if ($enable_paypal == "yes") { ?>

                <?php } else { ?>

                    $('#paypal-form').hide();

                <?php } ?>

            <?php } ?>


            <?php if ($current_balance < $sub_total) { ?>

                <?php if ($enable_stripe == "yes") { ?>

                    <?php if ($enable_paypal == "yes") { ?>

                        $('#credit-card-form').hide();

                    <?php } else { ?>


                    <?php } ?>

                <?php } ?>

            <?php } ?>

            $('#shopping-balance').click(function() {

                $('.col-md-5 .card br').show();

                $('.total-price').html('$<?php echo $sub_total; ?>');

                $('.processing-fee').hide();

                $('#credit-card-form').hide();

                $('#paypal-form').hide();

                $('#shopping-balance-form').show();

            });



            $('#paypal').click(function() {

                $('.col-md-5 .card br').hide();

                $('.total-price').html('$<?php echo $total; ?>');

                $('.processing-fee').show();

                $('#credit-card-form').hide();

                $('#paypal-form').show();

                $('#shopping-balance-form').hide();

            });



            $('#credit-card').click(function() {

                $('.col-md-5 .card br').hide();

                $('.total-price').html('$<?php echo $total; ?>');

                $('.processing-fee').show();

                $('#credit-card-form').show();

                $('#paypal-form').hide();

                $('#shopping-balance-form').hide();

            });


        });
    </script>

    <?php include("includes/footer.php"); ?>


</body>

</html>