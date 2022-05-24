<?php

session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_rating = $row_login_seller['seller_rating'];

$login_seller_recent_delivery = $row_login_seller['seller_recent_delivery'];

$login_seller_country = $row_login_seller['seller_country'];

$login_seller_register_date = $row_login_seller['seller_register_date'];

$login_seller_image = $row_login_seller['seller_image'];


$get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

$run_seller_accounts = mysqli_query($con, $get_seller_accounts);

$row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

$current_balance = $row_seller_accounts['current_balance'];

$month_earnings = $row_seller_accounts['month_earnings'];


if (isset($_GET['n_id'])) {

    $notification_id = $_GET['n_id'];

    $get_notification = "select * from notifications where notification_id='$notification_id'";

    $run_notification = mysqli_query($con, $get_notification);

    $row_notification = mysqli_fetch_array($run_notification);

    $order_id = $row_notification['order_id'];

    $update_notification = "update notifications set status='read' where notification_id='$notification_id'";

    $run_update = mysqli_query($con, $update_notification);

    if ($run_update) {

        echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
    }
}


if (isset($_GET['delete_notification'])) {

    $delete_id = $_GET['delete_notification'];

    $delete_notification = "delete from notifications where notification_id='$delete_id'";

    $run_delete = mysqli_query($con, $delete_notification);

    if ($run_delete) {

        echo "<script>alert('One Notification Has Been Deleted.')</script>";

        echo "<script>window.open('dashboard.php','_self')</script>";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Dashboard </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>

    <?php include("includes/user_header.php"); ?>


    <!--- container mt-4 mb-5 starts --->
    <div class="container mt-4 mb-5">

        <!--- row starts --->
        <div class="row">

            <!--- col-md-4 starts --->
            <div class="col-md-4">
                <?php include("includes/dashboard_sidebar.php"); ?>
            </div>
            <!--- col-md-4 ends --->


            <!--- col-md-8 starts --->
            <div class="col-md-8">

                <!--- card rounded-0 starts --->
                <div class="card rounded-0">

                    <!--- card-body p-0 starts --->
                    <div class="card-body p-0">

                        <!-- row p-2 starts --->
                        <div class="row p-2">

                            <!--- col-lg-3 col-sm-12 text-center starts --->
                            <div class="col-lg-3 col-sm-12 text-center">

                                <?php if (!empty($login_seller_image)) { ?>

                                    <img src="user_images/<?php echo $login_seller_image; ?>" class="rounded-circle img-thumbnail" width="130">

                                <?php } else { ?>

                                    <img src="user_images/empty-image.png" class="rounded-circle img-thumbnail" width="130">

                                <?php } ?>

                            </div>
                            <!--- col-lg-3 col-sm-12 text-center ends --->


                            <!--- col-lg-9 col-sm-12 text-lg-left text-center starts -->
                            <div class="col-lg-9 col-sm-12 text-lg-left text-center">

                                <!--- row mb-2 starts --->
                                <div class="row mb-2">

                                    <!--- col-6 col-lg-4 mt-3 starts --->
                                    <div class="col-6 col-lg-4 mt-3">

                                        <h6 class="text-muted"> Positive Ratings </h6>

                                        <h6> <?php echo $login_seller_rating; ?>% </h6>

                                    </div>
                                    <!--- col-6 col-lg-4 mt-3 ends --->

                                    <!--- col-6 col-lg-8 mt-3 starts --->
                                    <div class="col-6 col-lg-8 mt-3">

                                        <h6 class="text-muted"> Country </h6>

                                        <h6> <?php echo $login_seller_country; ?> </h6>

                                    </div>
                                    <!--- col-6 col-lg-8 mt-3 ends --->

                                </div>
                                <!--- row mb-2 ends --->

                                <!--- row starts --->
                                <div class="row">

                                    <!--- col-6 col-lg-4 starts --->
                                    <div class="col-6 col-lg-4">

                                        <h6 class="text-muted"> Recent Delivery </h6>

                                        <h6> <?php echo $login_seller_recent_delivery; ?> </h6>

                                    </div>
                                    <!--- col-6 col-lg-4 ends --->

                                    <!--- col-6 col-lg-8 starts --->
                                    <div class="col-6 col-lg-8">

                                        <h6 class="text-muted"> Member Since </h6>

                                        <h6> <?php echo $login_seller_register_date; ?> </h6>

                                    </div>
                                    <!--- col-6 col-lg-8 ends --->

                                </div>
                                <!--- row ends --->

                            </div>
                            <!--- col-lg-9 col-sm-12 text-lg-left text-center ends -->

                        </div><!-- row p-2 ends --->

                        <hr>

                        <!--- row pl-3 pr-3 pb-2 pt-3 mt-4 starts --->
                        <div class="row pl-3 pr-3 pb-2 pt-3 mt-4">

                            <!--- col-md-4 text-center border-box starts --->
                            <div class="col-md-4 text-center border-box">

                                <?php

                                $sel_orders = "select * from orders where seller_id='$login_seller_id' AND order_status='completed'";

                                $run_orders = mysqli_query($con, $sel_orders);

                                $count_orders = mysqli_num_rows($run_orders);

                                ?>

                                <h5 class="text-muted"> Orders Completed </h5>

                                <h3 class="text-success"> <?php echo $count_orders; ?> </h3>

                            </div>
                            <!--- col-md-4 text-center border-box ends --->

                            <!--- col-md-4 text-center border-box starts --->
                            <div class="col-md-4 text-center border-box">

                                <?php

                                $sel_orders = "select * from orders where seller_id='$login_seller_id' AND order_status='delivered'";

                                $run_orders = mysqli_query($con, $sel_orders);

                                $count_orders = mysqli_num_rows($run_orders);

                                ?>

                                <h5 class="text-muted"> Delivered Orders </h5>

                                <h3 class="text-success"> <?php echo $count_orders; ?> </h3>

                            </div>
                            <!--- col-md-4 text-center border-box ends --->

                            <!--- col-md-4 text-center border-box starts --->
                            <div class="col-md-4 text-center border-box">

                                <?php

                                $sel_orders = "select * from orders where seller_id='$login_seller_id' AND order_status='cancelled'";

                                $run_orders = mysqli_query($con, $sel_orders);

                                $count_orders = mysqli_num_rows($run_orders);

                                ?>

                                <h5 class="text-muted"> Orders Cancelled </h5>

                                <h3 class="text-success"> <?php echo $count_orders; ?> </h3>

                            </div>
                            <!--- col-md-4 text-center border-box ends --->

                        </div>
                        <!--- row pl-3 pr-3 pb-2 pt-3 mt-4 ends --->

                        <hr>

                        <!---- row pl-3 pr-3 pb-2 pt-2 starts --->
                        <div class="row pl-3 pr-3 pb-2 pt-2">

                            <!--- col-md-3 text-center border-box starts --->
                            <div class="col-md-3 text-center border-box">

                                <?php

                                $sel_orders = "select * from orders where seller_id='$login_seller_id' AND order_active='yes'";

                                $run_orders = mysqli_query($con, $sel_orders);

                                $count_orders = mysqli_num_rows($run_orders);

                                ?>

                                <h5 class="text-muted"> Sales In Queue </h5>

                                <h3> <?php echo $count_orders; ?> </h3>

                            </div>
                            <!--- col-md-3 text-center border-box ends --->

                            <!--- col-md-3 text-center border-box starts --->
                            <div class="col-md-3 text-center border-box">

                                <?php

                                $sel_orders = "select * from orders where buyer_id='$login_seller_id' AND order_active='yes'";

                                $run_orders = mysqli_query($con, $sel_orders);

                                $count_orders = mysqli_num_rows($run_orders);

                                ?>

                                <h5 class="text-muted"> Open Purchases </h5>

                                <h3> <?php echo $count_orders; ?> </h3>

                            </div>
                            <!--- col-md-3 text-center border-box ends --->

                            <!--- col-md-3 text-center border-box starts --->
                            <div class="col-md-3 text-center border-box">

                                <h5 class="text-muted"> Balance </h5>

                                <h3 class="text-success"> ₹<?php echo $current_balance; ?> </h3>

                            </div>
                            <!--- col-md-3 text-center border-box ends --->

                            <!--- col-md-3 text-center border-box starts --->
                            <div class="col-md-3 text-center border-box">

                                <h5 class="text-muted"> This Month Earnings </h5>

                                <h3 class="text-success"> ₹<?php echo $month_earnings; ?> </h3>

                            </div>
                            <!--- col-md-3 text-center border-box ends --->

                        </div>
                        <!---- row pl-3 pr-3 pb-2 pt-2 ends --->

                    </div>
                    <!--- card-body p-0 ends --->

                </div>
                <!--- card rounded-0 ends --->


                <!--- card rounded-0 mt-3 starts --->
                <div class="card rounded-0 mt-3">

                    <!--- card-header starts --->
                    <div class="card-header">

                        <!---- nav nav-tabs card-header-tabs starts --->
                        <ul class="nav nav-tabs card-header-tabs">

                            <li class="nav-item">

                                <?php

                                $get_notifications = "select * from notifications where receiver_id='$login_seller_id' order by 1 DESC";

                                $run_notifications = mysqli_query($con, $get_notifications);

                                $count_notifications = mysqli_num_rows($run_notifications);

                                ?>

                                <a href="#notifications" data-toggle="tab" class="nav-link active">

                                    Notifications <span class="badge badge-success">
                                        <?php echo $count_notifications; ?>
                                    </span>

                                </a>

                            </li>

                            <li class="nav-item">

                                <?php

                                $select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$login_seller_id'";

                                $run_hide_seller_messages = mysqli_query($con, $select_hide_seller_messages);

                                $count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);

                                $select_all_inbox_sellers = "select * from inbox_sellers where (receiver_id='$login_seller_id' or sender_id='$login_seller_id') AND NOT message_status='empty'";

                                $run_all_inbox_sellers = mysqli_query($con, $select_all_inbox_sellers);

                                $count_all_inbox_sellers = mysqli_num_rows($run_all_inbox_sellers);

                                ?>

                                <a href="#inbox" data-toggle="tab" class="nav-link">

                                    Messages
                                    <span class="badge badge-success">
                                        <?php echo $count_all_inbox_sellers - $count_hide_seller_messages; ?>
                                    </span>

                                </a>

                            </li>

                        </ul>
                        <!---- nav nav-tabs card-header-tabs ends --->

                    </div>
                    <!--- card-header ends --->


                    <!--- card-body p-0 starts --->
                    <div class="card-body p-0">

                        <!--- tab-content starts --->
                        <div class="tab-content">

                            <!--- notifications tab-pane fade show active mt-3 starts --->
                            <div id="notifications" class="tab-pane fade show active mt-3">

                                <?php

                                while ($row_notifications = mysqli_fetch_array($run_notifications)) {

                                    $notification_id = $row_notifications['notification_id'];

                                    $sender_id = $row_notifications['sender_id'];

                                    $order_id = $row_notifications['order_id'];

                                    $reason = $row_notifications['reason'];

                                    $date = $row_notifications['date'];

                                    $status = $row_notifications['status'];

                                    // Select Sender Details

                                    $select_sender = "select * from sellers where seller_id='$sender_id'";

                                    $run_sender = mysqli_query($con, $select_sender);

                                    $row_sender = mysqli_fetch_array($run_sender);

                                    $sender_user_name = $row_sender['seller_user_name'];

                                    $sender_image = $row_sender['seller_image'];

                                    ?>


                                    <!--- header-message-div-unread Starts --->
                                    <div class="<?php if ($status == "unread") {
                                                    echo "header-message-div-unread";
                                                } else {
                                                    echo "header-message-div";
                                                } ?>">

                                        <a href="dashboard.php?delete_notification=<?php echo $notification_id; ?>" class="float-right text-danger">

                                            <i class="fa fa-times-circle fa-lg"></i>

                                        </a>

                                        <!--- a Starts --->
                                        <a href="dashboard.php?n_id=<?php echo $notification_id; ?>">

                                            <?php if (!empty($sender_image)) { ?>

                                                <img src="user_images/<?php echo $sender_image; ?>" width="50" height="50" class="rounded-circle">

                                            <?php } else { ?>

                                                <img src="user_images/empty-image.png" width="50" height="50" class="rounded-circle">

                                            <?php } ?>

                                            <strong class="heading">
                                                <?php echo $sender_user_name; ?>
                                            </strong>

                                            <p class="message">
                                                <?php include("includes/notification_reasons.php"); ?>
                                            </p>

                                            <p class="date text-muted">
                                                <?php echo $date; ?>
                                            </p>

                                        </a>
                                        <!--- a Ends --->

                                    </div>
                                    <!--- header-message-div-unread Ends --->

                                <?php } ?>

                            </div>
                            <!--- notifications tab-pane fade show active mt-3 ends --->


                            <!--- inbox tab-pane fade mt-3 starts --->
                            <div id="inbox" class="tab-pane fade mt-3">

                                <?php

                                $select_inbox_sellers = "select * from inbox_sellers where (receiver_id='$login_seller_id' or sender_id='$login_seller_id') AND NOT message_status='empty' order by 1 DESC LIMIT 0,4";

                                $run_inbox_sellers = mysqli_query($con, $select_inbox_sellers);

                                while ($row_inbox_sellers = mysqli_fetch_array($run_inbox_sellers)) {

                                    $inbox_seller_id = $row_inbox_sellers['inbox_seller_id'];

                                    $message_group_id = $row_inbox_sellers['message_group_id'];

                                    $sender_id = $row_inbox_sellers['sender_id'];

                                    $receiver_id = $row_inbox_sellers['receiver_id'];

                                    $message_id = $row_inbox_sellers['message_id'];

                                    /// Select Sender Information

                                    $select_sender = "select * from sellers where seller_id='$sender_id'";

                                    $run_sender = mysqli_query($con, $select_sender);

                                    $row_sender = mysqli_fetch_array($run_sender);

                                    $sender_user_name = $row_sender['seller_user_name'];

                                    $sender_image = $row_sender['seller_image'];

                                    $select_inbox_message = "select * from inbox_messages where message_id='$message_id'";

                                    $run_inbox_message = mysqli_query($con, $select_inbox_message);

                                    $row_inbox_message = mysqli_fetch_array($run_inbox_message);

                                    $message_desc = $row_inbox_message['message_desc'];

                                    $message_date = $row_inbox_message['message_date'];

                                    $message_status = $row_inbox_message['message_status'];


                                    $select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$login_seller_id' AND hide_seller_id='$sender_id'";

                                    $run_hide_seller_messages = mysqli_query($con, $select_hide_seller_messages);

                                    $count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);

                                    ?>


                                    <!--- header-message-div-unread Starts --->
                                    <div <?php

                                            if ($count_hide_seller_messages == 1) {

                                                echo "style='display:none;'";
                                            }

                                            ?> class="<?php if ($message_status == "unread") {
                                                                echo "header-message-div-unread";
                                                            } else {
                                                                echo "header-message-div";
                                                            } ?>">

                                        <a href="conversations/insert_message.php?single_message_id=<?php echo $message_group_id; ?>">

                                            <?php if (!empty($sender_image)) { ?>

                                                <img src="user_images/<?php echo $sender_image; ?>" width="50" height="50" class="rounded-circle">

                                            <?php } else { ?>

                                                <img src="user_images/empty-image.png" width="50" height="50" class="rounded-circle">

                                            <?php } ?>

                                            <strong class="heading">
                                                <?php echo $sender_user_name; ?>
                                            </strong>

                                            <p class="message text-truncate">

                                                <?php echo $message_desc; ?>

                                            </p>

                                            <p class="date text-muted">
                                                <?php echo $message_date; ?>
                                            </p>

                                        </a>

                                    </div>
                                    <!--- header-message-div-unread Ends --->


                                <?php } ?>


                                <div class="p-3">

                                    <a href="<?php echo $site_url; ?>/conversations/inbox.php" class="btn btn-primary btn-block">
                                        See All
                                    </a>

                                </div>

                            </div>
                            <!--- inbox tab-pane fade mt-3 ends --->

                        </div>
                        <!--- tab-content ends --->

                    </div>
                    <!--- card-body p-0 ends --->

                </div>
                <!--- card rounded-0 mt-3 ends --->

            </div>
            <!--- col-md-8 ends --->

        </div>
        <!--- row ends --->

    </div>
    <!--- container mt-4 mb-5 ends --->


    <?php include("includes/footer.php"); ?>


</body>

</html>