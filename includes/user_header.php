<?php

include("db.php");

include("extra_script.php");

if (isset($_SESSION["seller_user_name"])) {

    include("seller_levels.php");

    $seller_user_name = $_SESSION['seller_user_name'];

    $select_seller = "select * from sellers where seller_user_name='$seller_user_name'";

    $run_seller = mysqli_query($con, $select_seller);

    $row_seller = mysqli_fetch_array($run_seller);

    $seller_id = $row_seller['seller_id'];

    $seller_email = $row_seller['seller_email'];

    $seller_verification = $row_seller['seller_verification'];

    $seller_image = $row_seller['seller_image'];

    $select_unread_notifications = "select * from notifications where receiver_id='$seller_id' AND status='unread'";

    $run_unread_notifications = mysqli_query($con, $select_unread_notifications);

    $count_unread_notifications = mysqli_num_rows($run_unread_notifications);

    $select_all_notifications = "select * from notifications where receiver_id='$seller_id'";

    $run_all_notifications = mysqli_query($con, $select_all_notifications);

    $count_all_notifications = mysqli_num_rows($run_all_notifications);

    $select_unread_inbox_messages = "select * from inbox_messages where message_receiver='$seller_id' AND message_status='unread'";

    $run_unread_inbox_messages = mysqli_query($con, $select_unread_inbox_messages);

    $count_unread_inbox_messages = mysqli_num_rows($run_unread_inbox_messages);

    $select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$seller_id'";

    $run_hide_seller_messages = mysqli_query($con, $select_hide_seller_messages);

    $count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);

    $select_all_inbox_sellers = "select * from inbox_sellers where (receiver_id='$seller_id' or sender_id='$seller_id') AND NOT message_status='empty'";

    $run_all_inbox_sellers = mysqli_query($con, $select_all_inbox_sellers);

    $count_all_inbox_sellers = mysqli_num_rows($run_all_inbox_sellers);

    $select_favourites = "select * from favorites where seller_id='$seller_id'";

    $run_favourites = mysqli_query($con, $select_favourites);

    $count_favourites = mysqli_num_rows($run_favourites);

    $select_cart = "select * from cart where seller_id='$seller_id'";

    $run_cart = mysqli_query($con, $select_cart);

    $count_cart = mysqli_num_rows($run_cart);

    $select_seller_account = "select * from seller_accounts where seller_id='$seller_id'";

    $run_seller_account = mysqli_query($con, $select_seller_account);

    $row_seller_account = mysqli_fetch_array($run_seller_account);

    $current_balance = $row_seller_account['current_balance'];

    $select_general_settings = "select * from general_settings";

    $run_general_settings = mysqli_query($con, $select_general_settings);

    $row_general_settings = mysqli_fetch_array($run_general_settings);

    $enable_referrals = $row_general_settings['enable_referrals'];
}


?>

<!-- navbar navbar-expand-lg navbar-dark fixed-top starts -->
<nav class="navbar navbar-expand-lg navbar-dark 

<?php if (isset($_SESSION['seller_user_name'])) {
    echo "navbar-login";
} ?> 

fixed-top" style="background:#e040fb;">

    <!--container starts-->
    <div class="container">

        <!-- left side drop down button for small devices-->
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarnav">
            <span class="navbar-toggler-icon"> </span>
        </button> <!-- drop down button ends-->


        <a class="navbar-brand" href="<?php echo $site_url; ?>/index.php"> <i class="fa fa-twitter fa-lg"> </i> FreeBird </a>

        <a class="navbar-toggler" href="<?php echo $site_url; ?>/mobile_categories.php">
            <i class="fa fa-th-large" style="font-size:1.5em;"> </i>
        </a>

        <!--drop down navbar starts-->
        <div class="collapse navbar-collapse" id="navbarnav">
            <hr>

            <!--inline form strats-->
            <form class="form-inline mr-auto" method="post">
                <!--input-group starts-->
                <div class="input-group">

                    <input type="text" class="form-control" required placeholder="Search Proposals" name="search_query" value="<?php echo @$_SESSION["search_query"]; ?>">

                    <!--input group btn starts-->
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="search" type="submit">
                            <i class="fa fa-search"> </i>
                        </button>
                    </span>
                    <!--input group btn ends-->

                </div>
                <!--input-group ends-->

            </form>
            <!--inline form ends-->

            <?php

            if (isset($_POST['search'])) {

                $search_query = $_POST['search_query'];

                $_SESSION['search_query'] = $search_query;

                header("location: $site_url/search.php");
            }

            ?>

            <hr>
            <!-- ul navbar-nav starts-->
            <ul class="navbar-nav">

                <!-- nav-item starts -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $site_url; ?>/dashboard.php" title="Dashboard">
                        <i class="fa fa-lg fa-dashboard"> </i>

                        <span class="d-lg-none"> Dashboard </span>
                    </a>
                </li>
                <!-- nav-item ends -->


                <!-- nav-item dropdown starts -->
                <li class="nav-item dropdown">

                    <!-- nav-link dropdown-toggle mr-lg-2 starts -->
                    <a href="#" class="nav-link dropdown-toggle mr-lg-2" data-toggle="dropdown" title="Notifications">

                        <i class="fa fa-fw fa-lg fa-bell"> </i>

                        <span class="d-lg-none">

                            Notifications

                            <?php if ($count_unread_notifications > 0) { ?>

                                <span class="badge badge-pill badge-danger">
                                    <?php echo $count_unread_notifications; ?> new
                                </span>

                            <?php
                        } ?>

                        </span>

                        <?php if ($count_unread_notifications > 0) { ?>

                            <!-- new-indicator text-danger d-lg-block d-none starts -->
                            <span class="new-indicator text-danger d-lg-block d-none">

                                <i class="fa fa-fw fa-circle"> </i>

                                <span class="number"> <?php echo $count_unread_notifications; ?> </span>

                            </span>
                            <!-- new-indicator text-danger d-lg-block d-none ends -->

                        <?php
                    } ?>

                    </a>
                    <!-- nav-link dropdown-toggle mr-lg-2 ends -->


                    <!--- dropdown-menu notifications-dropdown starts -->
                    <div class="dropdown-menu notifications-dropdown">

                        <!--- dropdown-header starts --->
                        <h3 class="dropdown-header">

                            Notifications (<?php echo $count_all_notifications; ?>)

                            <a class="float-right" href="<?php echo $site_url; ?>/dashboard.php"> View Dashboard </a>

                        </h3>
                        <!--- dropdown-header ends --->

                        <?php

                        $select_notofications = "select * from notifications where receiver_id='$seller_id' order by 1 DESC LIMIT 0,4";

                        $run_notifications = mysqli_query($con, $select_notofications);

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


                            <!--- header-message-div-unread starts --->
                            <div class=" <?php

                                            if ($status == "unread") {

                                                echo "header-message-div-unread";
                                            } else {

                                                echo "header-message-div";
                                            }

                                            ?> ">

                                <a href="<?php echo $site_url; ?>/dashboard.php?n_id=<?php echo $notification_id; ?>">

                                    <?php if (!empty($sender_image)) { ?>

                                        <img src="<?php echo $site_url; ?>/user_images/<?php echo $sender_image; ?>" width="50" height="50" class="rounded-circle">

                                    <?php
                                } else { ?>

                                        <img src="<?php echo $site_url; ?>/user_images/empty-picture.png" width="50" height="50" class="rounded-circle">

                                    <?php
                                } ?>

                                    <strong class="heading"> <?php echo $sender_user_name; ?> </strong>

                                    <p class="message"> <?php include("notification_reasons.php"); ?> </p>

                                    <p class="date text-muted"> <?php echo $date; ?> </p>

                                </a>

                            </div>
                            <!--- header-message-div-unread ends --->

                        <?php
                    } ?>

                    </div>
                    <!--- dropdown-menu notifications-dropdown ends -->

                </li>
                <!-- nav-item dropdown ends -->


                <!--- nav-item dropdown starts --->
                <li class="nav-item dropdown">

                    <!--- nav-link dropdown-toggle mr-lg-2 starts -->
                    <a href="#" class="nav-link dropdown-toggle mr-lg-2" data-toggle="dropdown" title="Inbox Messages">

                        <i class="fa fa-fw fa-lg fa-envelope"></i>

                        <span class="d-lg-none">

                            Messages

                            <?php if ($count_unread_inbox_messages > 0) { ?>

                                <span class="badge badge-pill badge-danger"> <?php echo $count_unread_inbox_messages; ?> New </span>

                            <?php
                        } ?>

                        </span>

                        <?php if ($count_unread_inbox_messages > 0) { ?>

                            <!--- new-indicator text-danger d-lg-block d-none starts -->
                            <span class="new-indicator text-danger d-lg-block d-none">

                                <i class="fa fa-fw fa-circle"></i>

                                <span class="number"><?php echo $count_unread_inbox_messages; ?></span>

                            </span>
                            <!--- new-indicator text-danger d-lg-block d-none ends -->

                        <?php
                    } ?>

                    </a>
                    <!--- nav-link dropdown-toggle mr-lg-2 ends -->

                    <!--- dropdown-menu messages-dropdown starts -->
                    <div class="dropdown-menu messages-dropdown">

                        <!--- dropdown-header starts -->
                        <h3 class="dropdown-header">

                            Inbox (<?php echo $count_all_inbox_sellers - $count_hide_seller_messages; ?>)

                            <a class="float-right" href="<?php echo $site_url; ?>/conversations/inbox.php">

                                View Inbox

                            </a>

                        </h3>
                        <!--- dropdown-header ends -->

                        <?php

                        $select_inbox_sellers = "select * from inbox_sellers where (receiver_id='$seller_id' or sender_id='$seller_id') AND NOT message_status='empty' order by 1 DESC LIMIT 0,4";

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


                            $select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$seller_id' AND hide_seller_id='$sender_id'";

                            $run_hide_seller_messages = mysqli_query($con, $select_hide_seller_messages);

                            $count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);

                            ?>

                            <!--- header-message-div-unread starts -->
                            <div <?php

                                    if ($count_hide_seller_messages == 1) {

                                        echo "style='display:none;'";
                                    }

                                    ?> class="

                    <?php

                    if ($message_status == "unread") {

                        echo "header-message-div-unread";
                    } else {

                        echo "header-message-div";
                    }

                    ?>

                    ">

                                <a href="<?php echo $site_url; ?>/conversations/insert_message.php?single_message_id=<?php echo $message_group_id; ?>">

                                    <?php if (!empty($sender_image)) { ?>

                                        <img src="<?php echo $site_url; ?>/user_images/<?php echo $sender_image; ?>" width="50" height="50" class="rounded-circle">

                                    <?php
                                } else { ?>

                                        <img src="<?php echo $site_url; ?>/user_images/empty-picture.png" width="50" height="50" class="rounded-circle">

                                    <?php
                                } ?>

                                    <strong class="heading"> <?php echo $sender_user_name; ?> </strong>

                                    <p class="message text-truncate"> <?php echo $message_desc; ?></p>

                                    <p class="date text-muted"> <?php echo $message_date; ?> </p>

                                </a>

                            </div>
                            <!--- header-message-div-unread ends -->

                        <?php
                    } ?>

                        <div class="m-2">

                            <a href="<?php echo $site_url; ?>/conversations/inbox.php" class="btn btn-primary btn-block">

                                See All

                            </a>

                        </div>

                    </div>
                    <!--- dropdown-menu messages-dropdown ends -->

                </li>
                <!--- nav-item dropdown ends --->


                <!--- nav-item dropdown starts -->
                <li class="nav-item dropdown">

                    <a class="nav-link mr-lg-2" href="<?php echo $site_url; ?>/favourites.php" title="Favourites">

                        <i class="fa fa-fw fa-lg fa-heart"></i>

                        <span class="d-lg-none">

                            <?php if ($count_favourites > 0) { ?>

                                Favourites
                                <span class="badge badge-pill badge-success"> <?php echo $count_favourites; ?> </span>

                            <?php
                        } ?>

                        </span>

                        <?php if ($count_favourites > 0) { ?>

                            <!--- new-indicator text-success d-lg-block d-none starts -->
                            <span class="new-indicator text-success d-lg-block d-none">

                                <i class="fa fa-fw fa-circle"></i>

                                <span class="number"> <?php echo $count_favourites; ?> </span>

                            </span>
                            <!--- new-indicator text-success d-lg-block d-none ends -->

                        <?php
                    } ?>

                    </a>

                </li>
                <!--- nav-item dropdown ends -->


                <!--- nav-item dropdown starts -->
                <li class="nav-item dropdown">

                    <a class="nav-link mr-lg-2" href="<?php echo $site_url; ?>/cart.php" title="Cart">

                        <i class="fa fa-fw fa-lg fa-shopping-cart"></i>

                        <span class="d-lg-none">

                            Cart

                            <?php if ($count_cart > 0) { ?>

                                <span class="badge badge-pill badge-success"> <?php echo $count_cart; ?> </span>

                            <?php
                        } ?>

                        </span>

                        <?php if ($count_cart > 0) { ?>

                            <!--- new-indicator text-success d-lg-block d-none starts -->
                            <span class="new-indicator text-success d-lg-block d-none">

                                <i class="fa fa-fw fa-circle"></i>

                                <span class="number"> <?php echo $count_cart; ?> </span>

                            </span>
                            <!--- new-indicator text-success d-lg-block d-none ends -->

                        <?php
                    } ?>

                    </a>

                </li>
                <!--- nav-item dropdown ends -->


                <!--- nav-item starts -->
                <li class="nav-item">

                    <!--- dropdown starts --->
                    <div class="dropdown">

                        <!--btn-outline-secondary-->
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle" data-toggle="dropdown">

                            <?php if (!empty($seller_image)) { ?>

                                <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="27" height="27" class="rounded-circle">

                            <?php
                        } else { ?>

                                <img src="<?php echo $site_url; ?>/user_images/empty-picture.png" width="27" height="27" class="rounded-circle">

                            <?php
                        } ?>

                            <?php echo $_SESSION['seller_user_name']; ?>

                            <?php if ($current_balance > 0) { ?>

                                <span class="badge badge-success"> ₹ <?php echo $current_balance; ?> </span>

                            <?php
                        } ?>

                        </button>

                        <!-- dropdown-menu starts -->
                        <div class="dropdown-menu">

                            <a class="dropdown-item" href="<?php echo $site_url; ?>/dashboard.php">
                                Dashboard
                            </a>

                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#selling">
                                Selling
                            </a>

                            <!--- selling dropdown-submenu collapse starts -->
                            <div id="selling" class="dropdown-submenu collapse">

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/selling_orders.php">
                                    Orders
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/proposals/view_proposals.php">
                                    View Proposals
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/buyer_requests.php">
                                    Buyer Requests
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/revenue.php">
                                    Revenues
                                </a>

                            </div>
                            <!--- selling dropdown-submenu collapse ends -->


                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#buying">
                                Buying
                            </a>

                            <!-- buying dropdown-submenu collapse starts -->
                            <div id="buying" class="dropdown-submenu collapse">

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/buying_orders.php">
                                    Orders
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/purchases.php">
                                    Payments
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/favourites.php">
                                    Favourites
                                </a>

                            </div>
                            <!-- buying dropdown-submenu collapse ends -->


                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#requests">
                                Requests
                            </a>

                            <!-- requests dropdown-submenu collapse Starts -->
                            <div id="requests" class="dropdown-submenu collapse">

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/post_request.php">
                                    Post A Request
                                </a>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/manage_requests.php">
                                    Manage Requests
                                </a>

                            </div>
                            <!-- requests dropdown-submenu collapse ends -->


                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#contacts">
                                Contacts
                            </a>

                            <!--- contacts dropdown-submenu collapse starts -->
                            <div id="contacts" class="dropdown-submenu collapse">

                                <a href="<?php echo $site_url; ?>/manage_contacts.php?my_buyers" class="dropdown-item">
                                    My Buyers
                                </a>

                                <a href="<?php echo $site_url; ?>/manage_contacts.php?my_sellers" class="dropdown-item">
                                    My Sellers
                                </a>

                            </div>
                            <!--- contacts dropdown-submenu collapse ends -->

                            <?php if ($enable_referrals == "yes") { ?>

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/my_referrals.php">
                                    My Referrals
                                </a>

                            <?php
                        } ?>

                            <a class="dropdown-item" href="<?php echo $site_url; ?>/conversations/inbox.php">
                                Inbox Conversations
                            </a>


                            <a class="dropdown-item" href="<?php echo $site_url; ?>/<?php echo $_SESSION['seller_user_name']; ?>">
                                My Profile
                            </a>


                            <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#settings">
                                Settings
                            </a>

                            <!-- settings dropdown-submenu collapse starts -->
                            <div id="settings" class="dropdown-submenu collapse">

                                <a class="dropdown-item" href="<?php echo $site_url; ?>/settings.php?profile_settings">
                                    Profile Settings
                                </a>


                                <a class="dropdown-item" href="<?php echo $site_url; ?>/settings.php?account_settings">
                                    Account Settings
                                </a>

                            </div>
                            <!-- settings dropdown-submenu collapse ends -->


                            <div class="dropdown-divider"> </div>


                            <a class="dropdown-item" href="<?php echo $site_url; ?>/logout.php">
                                Logout
                            </a>

                        </div>
                        <!-- dropdown-menu ends -->

                    </div>
                    <!--- dropdown ends --->

                </li>
                <!--- nav-item ends -->


            </ul>
            <!-- ul navbar-nav ends-->

        </div>
        <!--drop down navbar ends-->

    </div>
    <!--container ends-->

</nav>
<!-- navbar navbar-expand-lg navbar-dark fixed-top etarts -->

<?php include("user_nav.php") ?>




<?php

if (isset($_SESSION["seller_user_name"])) {

    if ($seller_verification != "ok") {

        ?>

        <!-- alert alert-warning clearfix starts -->
        <div class="alert alert-warning clearfix">

            <!-- row starts -->
            <div class="row">

                <!-- col-md-1 text-center starts -->
                <div class="col-md-1 text-center">

                    <i class="fa fa-exclamation-circle fa-5x d-inline-block"></i>

                </div>
                <!-- col-md-1 text-center ends -->

                <!-- col-md-8 text-lg-left text-sm-center starts -->
                <div class="col-md-8 text-lg-left text-sm-center">

                    <p>
                        <strong>
                            You need to activate your account to visit this website.
                        </strong>
                    </p>

                    <p>
                        Confirm email sent to <?php echo $seller_email; ?>
                    </p>

                    <p>
                        Need Help! <a href="contact.php"> Contact Support </a>
                    </p>

                </div>
                <!-- col-md-8 text-lg-left text-sm-center ends -->

                <!-- col-md-3 starts -->
                <div class="col-md-3">

                    <button id="send-email" class="btn btn-warning float-right">
                        Send Email
                    </button>

                </div>
                <!-- col-md-3 ends -->

            </div>
            <!-- row ends -->

        </div>
        <!-- alert alert-warning clearfix ends -->

        <script>
            $(document).ready(function() {

                $("#send-email").click(function() {

                    $.ajax({

                        method: "POST",
                        url: "<?php echo $site_url; ?>/includes/send-email.php",
                        success: function() {

                            $("#send-email").html("Resend Email");

                            alert("Your Verification Email Has Been Sent. Check Your Inbox.");

                        }

                    });

                });

            });
        </script>

        <script src="<?php echo $site_url; ?>/js/jquery.sticky.js"></script>

        <script src="<?php echo $site_url; ?>/js/popper.min.js"></script>

        <script src="<?php echo $site_url; ?>/js/bootstrap.min.js"></script>

        <script src="<?php echo $site_url; ?>/js/owl.carousel.min.js"></script>

        <script src="<?php echo $site_url; ?>/js/custom.js"></script>

        <?php

        exit();
    }
}

?>



<?php include("register-login-forgot.php");
?>