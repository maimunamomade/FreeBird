<?php

session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('../login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_email = $row_login_seller['seller_email'];



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



$get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

$run_seller_accounts = mysqli_query($con, $get_seller_accounts);

$row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

$current_balance = $row_seller_accounts['current_balance'];


$offer_id = $_POST['offer_id'];

$single_message_id = $_POST['single_message_id'];


$select_offer = "select * from messages_offers where offer_id='$offer_id'";

$run_offer = mysqli_query($con, $select_offer);

$row_offer = mysqli_fetch_array($run_offer);

$proposal_id = $row_offer['proposal_id'];

$description = $row_offer['description'];

$delivery_time = $row_offer['delivery_time'];

$amount = $row_offer['amount'];

$total = $amount + $processing_fee;


$select_proposals = "select * from proposals where proposal_id='$proposal_id'";

$run_proposals = mysqli_query($con, $select_proposals);

$row_proposals = mysqli_fetch_array($run_proposals);

$proposal_title = $row_proposals['proposal_title'];

?>

<!-- accpet-offer-modal starts -->
<div id="accept-offer-modal" class="modal fade">

    <!-- modal-dialog starts -->
    <div class="modal-dialog">

        <!-- modal-content starts -->
        <div class="modal-content">

            <!-- modal-header starts -->
            <div class="modal-header">

                <h5> Select A Payment Method To Order </h5>

                <button class="close" data-dismiss="modal">

                    <span> &times; </span>

                </button>

            </div>
            <!-- modal-header ends -->


            <!-- modal-body p-0 starts -->
            <div class="modal-body p-0">

                <!-- order-details starts -->
                <div class="order-details">

                    <!-- request-div starts -->
                    <div class="request-div">

                        <h4 class="mb-3">

                            THIS ORDER IS RELATED TO THE FOLLOWING OFFER:

                            <span class="price float-right d-sm-block d-none"> ₹<?php echo $amount; ?> </span>

                        </h4>

                        <p> "<?php echo $description; ?>" </p>

                        <p> <b> Proposal: </b> <?php echo $proposal_title; ?> </p>

                        <p> <b> Price/Amount: </b> ₹<?php echo $amount; ?> </p>

                        <p> <b> Delivery Time: </b> <?php echo $delivery_time; ?> </p>

                    </div>
                    <!-- request-div ends -->

                </div>
                <!-- order-details ends -->

                <!-- payment-options-list starts -->
                <div class="payment-options-list">

                    <?php if ($current_balance >= $amount) { ?>

                        <!-- payment-option mb-2 starts -->
                        <div class="payment-option mb-2">

                            <input type="radio" name="payment_option" id="shopping-balance" class="radio-custom" checked>

                            <label for="shopping-balance" class="radio-custom-label"></label>

                            <span class="lead font-weight-bold"> Shopping Balance </span>

                            <p class="lead ml-5">

                                Personal Balance - <?php echo $login_seller_user_name; ?>
                                <span class="text-success font-weight-bold"> ₹<?php echo $current_balance; ?> </span>

                            </p>

                        </div><!-- payment-option mb-2 ends -->

                        <?php if ($enable_paypal == "yes" or $enable_stripe == "yes") { ?>

                            <hr>

                        <?php } ?>


                    <?php } ?>


                    <?php if ($enable_paypal == "yes") { ?>


                        <!-- payment-option starts -->
                        <div class="payment-option">

                            <input type="radio" name="payment_option" id="paypal" class="radio-custom">

                            <label for="paypal" class="radio-custom-label"></label>

                            <img src="../images/paypal.png">

                        </div>
                        <!-- payment-option ends -->

                    <?php } ?>


                    <?php if ($enable_stripe == "yes") { ?>

                        <?php if ($enable_paypal == "yes") { ?>

                            <hr>

                        <?php } ?>

                        <!-- payment-option Starts -->
                        <div class="payment-option">

                            <input type="radio" name="payment_option" id="credit-card" class="radio-custom">

                            <label for="credit-card" class="radio-custom-label"></label>

                            <img src="../images/credit_cards.jpg">

                        </div>
                        <!-- payment-option ends -->

                    <?php } ?>

                </div>
                <!-- payment-options-list ends -->

            </div>
            <!-- modal-body p-0 ends -->


            <!-- modal-footer starts -->
            <div class="modal-footer">

                <button class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

                <?php if ($current_balance >= $amount) { ?>

                    <!--- shopping-balance-form starts --->
                    <form action="../shopping_balance.php" method="post" id="shopping-balance-form">

                        <input type="hidden" name="offer_id" value="<?php echo $offer_id; ?>">

                        <input type="hidden" name="amount" value="<?php echo $amount; ?>">

                        <button type="submit" name="message_offer_submit_order" class="btn btn-success" onclick="return confirm('Do You Really Want to Order This Offer Using Your Shopping Balance.')">

                            Pay With Shopping Balance

                        </button>

                    </form>
                    <!--- shopping-balance-form ends --->

                    <br>


                <?php } ?>


                <?php if ($enable_paypal == "yes") { ?>

                    <form action="<?php echo $paypal_url; ?>" method="post" id="paypal-form">
                        <!--- paypal-form Starts --->

                        <input type="hidden" name="cmd" value="_xclick">

                        <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">

                        <input type="hidden" name="tax" value="<?php echo $processing_fee; ?>">

                        <input type="hidden" name="currency_code" value="<?php echo $paypal_currency_code; ?>">

                        <input type="hidden" name="cancel_return" value="<?php echo $site_url; ?>/conversations/insert_message.php?single_message_id=<?php echo $single_message_id; ?>">

                        <input type="hidden" name="return" value="<?php echo $site_url; ?>/paypal_order.php?message_offer_id=<?php echo $offer_id; ?>">

                        <input type="hidden" name="item_name" value="<?php echo $proposal_title; ?>">

                        <input type="hidden" name="item_number" value="1">

                        <input type="hidden" name="amount" value="<?php echo $amount; ?>">

                        <input type="hidden" name="quantity" value="1">


                        <button type="submit" name="submit" class="btn btn-success">

                            Pay With Paypal

                        </button>


                    </form>
                    <!--- paypal-form Ends --->

                <?php } ?>


                <?php if ($enable_stripe == "yes") { ?>

                    <?php

                    include("../stripe_config.php");

                    $stripe_total_amount = $total * 100;

                    ?>

                    <!--- credit-card-form Starts --->
                    <form action="accept_offer_charge.php" method="post" id="credit-card-form">

                        <input type="hidden" name="offer_id" value="<?php echo $offer_id; ?>">

                        <input type="hidden" name="amount" value="<?php echo $stripe_total_amount; ?>">

                        <input type="submit" class="btn btn-success stripe-submit" value="Pay With Credit Card" data-dismiss="modal" data-key="<?php echo $stripe['publishable_key']; ?>" data-amount="<?php echo $stripe_total_amount; ?>" data-currency="<?php echo $stripe['currency_code']; ?>" data-email="<?php echo $login_seller_email; ?>" data-name="FreeBird.com" data-image="../images/logo.png" data-description="<?php echo $proposal_title; ?>" data-allow-remember-me="false">

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
                    <!--- credit-card-form Ends --->

                <?php } ?>

            </div>
            <!-- modal-footer ends -->

        </div>
        <!-- modal-content ends -->

    </div>
    <!-- modal-dialog ends -->

</div>
<!-- accpet-offer-modal ends -->

<script>
    $(document).ready(function() {

        $("#accept-offer-modal").modal('show');

        <?php if ($current_balance >= $amount) { ?>

            $('#paypal-form').hide();

            $('#credit-card-form').hide();

        <?php } else { ?>

            $('#shopping-balance-form').hide();

        <?php } ?>


        <?php if ($current_balance < $amount) { ?>

            <?php if ($enable_paypal == "yes") { ?>

            <?php } else { ?>

                $('#paypal-form').hide();

            <?php } ?>

        <?php } ?>


        <?php if ($current_balance < $amount) { ?>

            <?php if ($enable_stripe == "yes") { ?>

                <?php if ($enable_paypal == "yes") { ?>

                    $('#credit-card-form').hide();

                <?php } else { ?>


                <?php } ?>

            <?php } ?>

        <?php } ?>


        $('#shopping-balance').click(function() {

            $('#credit-card-form').hide();

            $('#paypal-form').hide();

            $('#shopping-balance-form').show();

        });



        $('#paypal').click(function() {

            $('#credit-card-form').hide();

            $('#paypal-form').show();

            $('#shopping-balance-form').hide();

        });



        $('#credit-card').click(function() {

            $('#credit-card-form').show();

            $('#paypal-form').hide();

            $('#shopping-balance-form').hide();

        });

    });
</script>