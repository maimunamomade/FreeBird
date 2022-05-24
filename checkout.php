<?php

session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

if (!isset($_POST['add_order']) and !isset($_POST['add_cart']) and !isset($_POST['coupon_submit'])) {

    echo "<script>window.open('index.php','_self')</script>";
}

?>

<?php

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


?>

<?php

if (isset($_POST['add_order']) or isset($_POST['coupon_submit'])) {

    $proposal_id = $_POST['proposal_id'];

    $proposal_qty = $_POST['proposal_qty'];

    $get_proposals = "select * from proposals where proposal_id='$proposal_id'";

    $run_proposals = mysqli_query($con, $get_proposals);

    $row_proposals = mysqli_fetch_array($run_proposals);

    $proposal_price = $row_proposals['proposal_price'];

    $proposal_title = $row_proposals['proposal_title'];

    $proposal_url = $row_proposals['proposal_url'];

    $proposal_img1 = $row_proposals['proposal_img1'];


    $sub_total = $proposal_price * $proposal_qty;


    $total = $processing_fee + $sub_total;


    $get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

    $run_seller_accounts = mysqli_query($con, $get_seller_accounts);

    $row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

    $current_balance = $row_seller_accounts['current_balance'];


    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>FreeBird / Order Details </title>

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


        <!-- container mt-5 mb-5 starts -->
        <div class="container mt-5 mb-5">

            <!-- row starts -->
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

                    <!--- card checkout-details starts --->
                    <div class="card checkout-details">

                        <!--- card-header starts --->
                        <div class="card-header">

                            <!--- h5 starts --->
                            <h5>
                                <i class="fa fa-money fa-fw"></i> Order Summary
                            </h5>
                            <!--- h5 ends --->

                        </div>
                        <!--- card-header ends --->

                        <!--- card-body starts --->
                        <div class="card-body">

                            <!--- row starts --->
                            <div class="row">

                                <!--- col-md-4 mb-3 starts --->
                                <div class="col-md-4 mb-3">

                                    <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">

                                </div>
                                <!--- col-md-4 mb-3 ends --->

                                <!--- col-md-8 starts --->
                                <div class="col-md-8">

                                    <h5> <?php echo $proposal_title; ?> </h5>

                                </div>
                                <!--- col-md-8 ends --->

                            </div>
                            <!--- row ends --->

                            <hr>

                            <h6>
                                Proposal Price :
                                <span class="float-right">
                                    ₹<?php echo $proposal_price; ?>
                                </span>
                            </h6>

                            <hr>

                            <h6>
                                Proposal Qty :
                                <span class="float-right proposal-price">
                                    <?php echo $proposal_qty; ?>
                                </span>
                            </h6>

                            <hr>

                            <h6 class="processing-fee">
                                Processing Fee :
                                <span class="float-right">
                                    ₹<?php echo $processing_fee; ?>
                                </span>
                            </h6>

                            <hr class="processing-fee">

                            <h6>
                                Apply Coupon Code :
                            </h6>


                            <!--- form input-group starts --->
                            <form class="input-group" method="post">

                                <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                                <input type="hidden" name="proposal_qty" value="<?php echo $proposal_qty; ?>">

                                <input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">

                                <button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">
                                    Apply
                                </button>

                            </form>
                            <!--- form input-group ends --->

                            <p class="coupon-response"></p>

                            <?php

                            if (isset($_POST['code'])) {

                                $coupon_code = $_POST['code'];

                                if (!empty($coupon_code)) {

                                    $select_coupon = "select * from coupons where proposal_id='$proposal_id' and coupon_code='$coupon_code'";

                                    $run_coupon = mysqli_query($con, $select_coupon);

                                    $count_coupon = mysqli_num_rows($run_coupon);

                                    if ($count_coupon == 1) {

                                        $row_coupon = mysqli_fetch_array($run_coupon);

                                        $coupon_limit = $row_coupon['coupon_limit'];

                                        $coupon_used = $row_coupon['coupon_used'];

                                        $coupon_price = $row_coupon['coupon_price'];


                                        if ($coupon_limit <= $coupon_used) {

                                            echo "

<script>

$('.coupon-response').html('Your Coupon Code Has Been Expired.').attr('class', 'coupon-response mt-2 p-2 bg-danger text-white');

</script>

";
                                        } else {

                                            $update_coupon = "update coupons set coupon_used=coupon_used+1 where proposal_id='$proposal_id' and coupon_code='$coupon_code'";

                                            $run_update_coupon = mysqli_query($con, $update_coupon);

                                            $proposal_price = $coupon_price;

                                            $proposal_qty = $_POST['proposal_qty'];

                                            $sub_total = $proposal_price * $proposal_qty;

                                            $total = $processing_fee + $sub_total;

                                            echo "

<script>


$('.proposal-price').html('₹$proposal_price');

$('.coupon-response').html('Your Coupon Has Been Applied.').attr('class', 'coupon-response mt-2 p-2 bg-success text-white');

</script>


";
                                        }
                                    } else {

                                        echo "

<script>

$('.coupon-response').html('Your Coupon Code Is Not Valid.').attr('class', 'coupon-response mt-2 p-2 bg-danger text-white');

</script>

";
                                    }
                                }
                            }


                            ?>

                            <hr>

                            <h5 class="font-weight-bold">
                                Proposal Total :
                                <span class="float-right total-price">
                                    ₹<?php echo $total; ?>
                                </span>
                            </h5>

                            <hr>


                            <?php if ($current_balance >= $sub_total) { ?>

                                <!--- shopping-balance-form starts --->
                                <form action="shopping_balance.php" method="post" id="shopping-balance-form">

                                    <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                                    <input type="hidden" name="proposal_qty" value="<?php echo $proposal_qty; ?>">

                                    <input type="hidden" name="amount" value="<?php echo $sub_total; ?>">

                                    <button type="submit" name="checkout_submit_order" class="btn btn-lg btn-success btn-block" onclick="return confirm('Do You Really Want to Order This Proposal Using Your Shopping Balance.')">
                                        Pay With Shopping Balance
                                    </button>

                                </form>
                                <!--- shopping-balance-form ends --->

                            <?php } ?>



                            <?php if ($enable_paypal == "yes") { ?>

                                <!--- paypal-form starts --->
                                <form action="<?php echo $paypal_url; ?>" method="post" id="paypal-form">

                                    <input type="hidden" name="cmd" value="_xclick">

                                    <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">

                                    <input type="hidden" name="tax" value="<?php echo $processing_fee; ?>">

                                    <input type="hidden" name="currency_code" value="<?php echo $paypal_currency_code; ?>">

                                    <input type="hidden" name="cancel_return" value="<?php echo $site_url; ?>/proposals/<?php echo $proposal_url; ?>">

                                    <input type="hidden" name="return" value="<?php echo $site_url; ?>/paypal_order.php?checkout_seller_id=<?php echo $login_seller_id; ?>&proposal_id=<?php echo $proposal_id; ?>&proposal_qty=<?php echo $proposal_qty; ?>&proposal_price=<?php echo $sub_total; ?>">

                                    <input type="hidden" name="item_name" value="<?php echo $proposal_title; ?>">

                                    <input type="hidden" name="item_number" value="1">

                                    <input type="hidden" name="amount" value="<?php echo $proposal_price; ?>">

                                    <input type="hidden" name="quantity" value="<?php echo $proposal_qty; ?>">


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
                                <form action="checkout_charge.php" method="post" id="credit-card-form">

                                    <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                                    <input type="hidden" name="proposal_qty" value="<?php echo $proposal_qty; ?>">

                                    <input type="hidden" name="proposal_price" value="<?php echo $proposal_price; ?>">

                                    <input type="hidden" name="amount" value="<?php echo $stripe_total_amount; ?>">

                                    <input type="submit" class="btn btn-lg btn-success btn-block stripe-submit" value="Pay With Credit Card" data-key="<?php echo $stripe['publishable_key']; ?>" data-amount="<?php echo $stripe_total_amount; ?>" data-currency="<?php echo $stripe['currency_code']; ?>" data-email="<?php echo $login_seller_email; ?>" data-name="FreeBird.com" data-image="images/logo.png" data-description="<?php echo $proposal_title; ?>" data-allow-remember-me="false">

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
                        <!--- card-body ends --->

                    </div>
                    <!--- card checkout-details ends --->

                </div>
                <!--- col-md-5 ends --->

            </div>
            <!-- row ends -->

        </div>
        <!-- container mt-5 mb-5 ends -->


        <script>
            $(document).ready(function() {

                <?php if ($current_balance >= $sub_total) { ?>

                    $('.total-price').html('₹<?php echo $sub_total; ?>');

                    $('.processing-fee').hide();

                <?php } else { ?>

                    $('.total-price').html('₹<?php echo $total; ?>');

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

                    $('.total-price').html('₹<?php echo $sub_total; ?>');

                    $('.processing-fee').hide();

                    $('#credit-card-form').hide();

                    $('#paypal-form').hide();

                    $('#shopping-balance-form').show();

                });



                $('#paypal').click(function() {

                    $('.col-md-5 .card br').hide();

                    $('.total-price').html('₹<?php echo $total; ?>');

                    $('.processing-fee').show();

                    $('#credit-card-form').hide();

                    $('#paypal-form').show();

                    $('#shopping-balance-form').hide();

                });



                $('#credit-card').click(function() {

                    $('.col-md-5 .card br').hide();

                    $('.total-price').html('₹<?php echo $total; ?>');

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

<?php

} elseif (isset($_POST['add_cart'])) {

    $proposal_id = $_POST['proposal_id'];

    $proposal_qty = $_POST['proposal_qty'];

    $select_proposal = "select * from proposals where proposal_id='$proposal_id'";

    $run_proposal = mysqli_query($con, $select_proposal);

    $row_proposal = mysqli_fetch_array($run_proposal);

    $proposal_price = $row_proposal['proposal_price'];

    $proposal_url = $row_proposal['proposal_url'];

    $select_cart = "select * from cart where seller_id='$login_seller_id' AND proposal_id='$proposal_id'";

    $run_cart = mysqli_query($con, $select_cart);

    $count_cart = mysqli_num_rows($run_cart);

    if ($count_cart == 1) {

        echo "

<script>

alert('This Proposal Is Already Added To Your Cart.');

window.open('proposals/$proposal_url','_self');

</script>

";
    } else {

        $insert_cart = "insert into cart (seller_id,proposal_id,proposal_price,proposal_qty) values ('$login_seller_id','$proposal_id','$proposal_price','$proposal_qty')";

        $run_insert_cart = mysqli_query($con, $insert_cart);

        echo " <script> window.open('proposals/$proposal_url','_self'); </script> ";
    }
}


?>