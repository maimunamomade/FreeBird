<?php

@session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

@$order_id = $_GET['order_id'];


$get_orders = "select * from orders where order_id='$order_id'";

$run_orders = mysqli_query($con, $get_orders);

$row_orders = mysqli_fetch_array($run_orders);

$seller_id = $row_orders['seller_id'];

$buyer_id = $row_orders['buyer_id'];

$order_price = $row_orders['order_price'];

$order_status = $row_orders['order_status'];


$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con, $get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$comission_percentage = $row_payment_settings['comission_percentage'];

$days_before_withdraw = $row_payment_settings['days_before_withdraw'];


function getPercentOfNumber($amount, $percentage)
{

    $calculate_percentage = ($percentage / 100) * $amount;

    return $amount - $calculate_percentage;
}


$seller_price = getPercentOfNumber($order_price, $comission_percentage);

date_default_timezone_set("UTC");

$revenue_date = date("F d, Y", strtotime(" + $days_before_withdraw days"));

$end_date = date("F d, Y h:i:s", strtotime(" + $days_before_withdraw days"));



$get_order_conversations = "select * from order_conversations where order_id='$order_id'";

$run_order_conversations = mysqli_query($con, $get_order_conversations);

while ($row_order_conversations = mysqli_fetch_array($run_order_conversations)) {

    $c_id = $row_order_conversations['c_id'];

    $sender_id = $row_order_conversations['sender_id'];

    $message = $row_order_conversations['message'];

    $file = $row_order_conversations['file'];

    $date = $row_order_conversations['date'];

    $status = $row_order_conversations['status'];


    $select_seller = "select * from sellers where seller_id='$sender_id'";

    $run_seller = mysqli_query($con, $select_seller);

    $row_seller = mysqli_fetch_array($run_seller);

    $seller_image = $row_seller['seller_image'];

    $seller_user_name = $row_seller['seller_user_name'];


    if ($seller_id == $sender_id) {

        $receiver_name = "Buyer";
    } else {

        $receiver_name = "Seller";
    }


    if ($seller_id == $login_seller_id) {

        $receiver_id = $buyer_id;
    } else {

        $receiver_id = $seller_id;
    }

    date_default_timezone_set("Asia/Kolkata");

    $last_update_date = date("h:i: M d, Y");


    ?>


    <?php if ($status == "message") { ?>

        <!--- message-div starts --->
        <div class=" <?php if ($sender_id == $login_seller_id) {

                            echo "message-div-hover";
                        } else {

                            echo "message-div";
                        }
                        ?>
                                                                         ">


            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>

            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div ends --->


    <?php } elseif ($status == "delivered") { ?>

        <h3 class="text-center mt-3 mb-3"> Order Delievered </h3>

        <!--- message-div Starts --->

        <div class="

                                                                                                                                                                                                                <?php

                                                                                                                                                                                                                if ($sender_id == $login_seller_id) {

                                                                                                                                                                                                                    echo "message-div-hover";
                                                                                                                                                                                                                } else {

                                                                                                                                                                                                                    echo "message-div";
                                                                                                                                                                                                                }

                                                                                                                                                                                                                ?>

                                                                                                                                                                                                                ">

            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>

            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div-hover ends --->


        <?php

        if ($order_status == "delivered") {

            ?>

            <?php if ($buyer_id == $login_seller_id) { ?>

                <!-- mb-4 mt-4 Starts --->
                <center class="pb-4 mt-4">

                    <form method="post">

                        <button name="complete" type="submit" class="btn btn-success">

                            Accept & Review Order

                        </button>

                        &nbsp;&nbsp;&nbsp;

                        <button type="button" data-toggle="modal" data-target="#revision-request-modal" class="btn btn-success">

                            Request A Revison

                        </button>


                    </form>

                    <?php

                    if (isset($_POST['complete'])) {

                        $recent_delivery_date = date("F d, Y");

                        $update_recent_delivery = "update sellers set seller_recent_delivery='$recent_delivery_date' where seller_id='$seller_id'";

                        $run_update_recent_delivery = mysqli_query($con, $update_recent_delivery);

                        $update_order = "update orders set order_status='completed',order_active='no' where order_id='$order_id'";

                        $run_order = mysqli_query($con, $update_order);

                        $update_messages_status = "update order_conversations set status='message' where order_id='$order_id' and status='delivered'";

                        $run_messages = mysqli_query($con, $update_messages_status);

                        $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$seller_id','$buyer_id','$order_id','order_completed','$last_update_date','unread')";

                        $run_notification = mysqli_query($con, $insert_notification);

                        $update_pending_clearnace = "update seller_accounts set pending_clearance=pending_clearance+$seller_price,month_earnings=month_earnings+$seller_price where seller_id='$seller_id'";

                        $run_pending_clearnace = mysqli_query($con, $update_pending_clearnace);

                        $insert_revenue = "insert into revenue (seller_id,order_id,amount,date,end_date,status) values ('$seller_id','$order_id','$revenue_date','$end_date','pending')";

                        $run_revenue = mysqli_query($con, $insert_revenue);

                        echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                    }

                    ?>

                </center><!-- mb-4 mt-4 Ends --->

            <?php } ?>

        <?php } ?>


    <?php } elseif ($status == "revision") { ?>

        <h3 class="text-center mt-3 mb-3"> Revison Requested By <?php echo $seller_user_name; ?> </h3>

        <!--- message-div Starts --->
        <div class="

                                                                                                                                                                                        <?php

                                                                                                                                                                                        if ($sender_id == $login_seller_id) {

                                                                                                                                                                                            echo "message-div-hover";
                                                                                                                                                                                        } else {

                                                                                                                                                                                            echo "message-div";
                                                                                                                                                                                        }

                                                                                                                                                                                        ?>

                                                                                                                                                                                        ">

            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>

            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div ends --->


    <?php } elseif ($status == "cancellation_request") { ?>

        <h3 class="text-center mt-3 mb-3"> Order Cancellation Requeste By <?php echo $seller_user_name; ?> </h3>

        <!--- message-div Starts --->
        <div class="

                                                                                                                                                                        <?php

                                                                                                                                                                        if ($sender_id == $login_seller_id) {

                                                                                                                                                                            echo "message-div-hover";
                                                                                                                                                                        } else {

                                                                                                                                                                            echo "message-div";
                                                                                                                                                                        }

                                                                                                                                                                        ?>

                                                                                                                                                                        ">

            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>


            <?php if ($sender_id == $login_seller_id) { ?>



            <?php } else { ?>


                <form class="mb-2" method="post">
                    <!--- form mb-2 Starts --->

                    <button name="accept_request" class="btn btn-success btn-sm">

                        Accept Request

                    </button>


                    <button name="decline_request" class="btn btn-success btn-sm">

                        Decline Request

                    </button>


                </form>
                <!--- form mb-2 Ends --->

                <?php

                if (isset($_POST['accept_request'])) {

                    $update_messages_status = "update order_conversations set status='accept_cancellation_request' where order_id='$order_id' and status='cancellation_request'";

                    $run_messages = mysqli_query($con, $update_messages_status);

                    $update_order = "update orders set order_status='cancelled',order_active='no' where order_id='$order_id'";

                    $run_order = mysqli_query($con, $update_order);

                    $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$receiver_id','$login_seller_id','$order_id','accept_cancellation_request','$last_update_date','unread')";

                    $run_notification = mysqli_query($con, $insert_notification);


                    $update_my_buyers = "update my_buyers set completed_orders=completed_orders-1,amount_spent=amount_spent-$order_price where buyer_id='$buyer_id' AND seller_id='$seller_id'";

                    $run_update_my_buyers = mysqli_query($con, $update_my_buyers);


                    $update_my_sellers = "update my_sellers set completed_orders=completed_orders-1,amount_spent=amount_spent-$order_price where seller_id='$seller_id' AND buyer_id='$buyer_id'";

                    $run_update_my_sellers = mysqli_query($con, $update_my_sellers);

                    $purchase_date = date("F d, Y");

                    $insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$buyer_id','$order_id','$order_price','$purchase_date','order_cancellation')";

                    $run_purchase = mysqli_query($con, $insert_purchase);

                    $update_balance = "update seller_accounts set used_purchases=used_purchases-$order_price,current_balance=current_balance+$order_price where seller_id='$buyer_id'";

                    $run_update_balance = mysqli_query($con, $update_balance);

                    echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                }


                if (isset($_POST['decline_request'])) {

                    $update_messages_status = "update order_conversations set status='decline_cancellation_request' where order_id='$order_id' and status='cancellation_request'";

                    $run_messages = mysqli_query($con, $update_messages_status);


                    $update_order = "update orders set order_status='progress' where order_id='$order_id'";

                    $run_order = mysqli_query($con, $update_order);

                    $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$receiver_id','$login_seller_id','$order_id','decline_cancellation_request','$last_update_date','unread')";

                    $run_notification = mysqli_query($con, $insert_notification);

                    echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                }


                ?>


            <?php } ?>

            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div ends --->


    <?php } elseif ($status == "decline_cancellation_request") { ?>


        <h3 class="text-center mt-3 mb-3"> Order Cancellation Request By <?php echo $seller_user_name; ?> </h3>

        <!--- message-div Starts --->
        <div class="

                                                                                                                                                                <?php

                                                                                                                                                                if ($sender_id == $login_seller_id) {

                                                                                                                                                                    echo "message-div-hover";
                                                                                                                                                                } else {

                                                                                                                                                                    echo "message-div";
                                                                                                                                                                }

                                                                                                                                                                ?>

                                                                                                                                                                ">

            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>


            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div ends --->

        <!--- order-status-message Starts --->
        <div class="order-status-message">

            <i class="fa fa-times fa-3x text-danger"></i>


            <h5 class="text-danger">

                Cancellation Request Declined By <?php echo $receiver_name; ?>

            </h5>

        </div>
        <!--- order-status-message Ends --->

    <?php } elseif ($status == "accept_cancellation_request") { ?>


        <h3 class="text-center mt-3 mb-3"> Order Cancellation Request By <?php echo $seller_user_name; ?> </h3>

        <!--- message-div Starts --->
        <div class="

                                                                                                                                                <?php

                                                                                                                                                if ($sender_id == $login_seller_id) {

                                                                                                                                                    echo "message-div-hover";
                                                                                                                                                } else {

                                                                                                                                                    echo "message-div";
                                                                                                                                                }

                                                                                                                                                ?>

                                                                                                                                                ">

            <img src="user_images/<?php echo $seller_image; ?>" class="message-image">

            <h5>

                <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>

            </h5>

            <p class="message-desc">

                <?php echo $message; ?>

                <?php if (!empty($file)) { ?>

                    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>

                        <i class="fa fa-download"></i> <?php echo $file; ?>

                    </a>

                <?php } else { ?>


                <?php } ?>

            </p>


            <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>

        </div>
        <!--- message-div Ends --->


        <?php if ($seller_id == $login_seller_id) { ?>

            <!-- order-status-message Starts --->
            <div class="order-status-message">

                <i class="fa fa-times fa-3x text-danger"></i>

                <h5 class="text-danger"> Order Cancelled By Mutual Agreement. </h5>

                <p>

                    This Order Was Cancelled By Mutual Agreement Between You And Your Buyer &

                    The Order Funds Will Be Returened To Buyer Shortly.

                </p>

            </div><!-- order-status-message Ends --->

        <?php } else { ?>

            <!-- order-status-message Starts --->
            <div class="order-status-message">

                <i class="fa fa-times fa-3x text-danger"></i>

                <h5 class="text-danger"> Order Cancelled By Mutual Agreement. </h5>

                <p>

                    This Order Was Cancelled By Mutual Agreement Between You And Your Seller &

                    The Order Funds Will Be Returened To You Shortly.

                </p>

            </div><!-- order-status-message Ends --->

        <?php } ?>


    <?php } elseif ($status == "cancelled_by_customer_support") { ?>


        <?php if ($seller_id == $login_seller_id) { ?>

            <!-- order-status-message Starts --->
            <div class="order-status-message">

                <i class="fa fa-times fa-3x text-danger"></i>

                <h5 class="text-danger"> Order Cancelled By Customer Support. </h5>

                <p>

                    The Payment of this order was returned to buyer shopping balance <br>

                    For further assistance , Please visit our <a href="contact.php"> Customer Support. </a>

                </p>

            </div><!-- order-status-message Ends --->


        <?php } else { ?>

            <!-- order-status-message Starts --->
            <div class="order-status-message">

                <i class="fa fa-times fa-3x text-danger"></i>

                <h5 class="text-danger"> Order Cancelled By Customer Support. </h5>

                <p>

                    The Payment of this order was returned to Your Shopping Balance.

                </p>

            </div><!-- order-status-message Ends --->

        <?php } ?>


    <?php } ?>


<?php } ?>