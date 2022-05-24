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

$order_id = $_GET['order_id'];


$get_orders = "select * from orders where (seller_id='$login_seller_id' or buyer_id='$login_seller_id') AND order_id='$order_id'";

$run_orders = mysqli_query($con, $get_orders);

$count_orders = mysqli_num_rows($run_orders);

if ($count_orders == 0) {

    echo "<script>window.open('index.php?not_available','_self')</script>";
}

$row_orders = mysqli_fetch_array($run_orders);

$order_number = $row_orders['order_number'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / fixmywebsite / Details For Your Order #<?php echo $order_number; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/fontawesome-stars.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
    <script src="js/jquery.barrating.min.js"> </script>
    <script src="js/jquery.sticky.js"> </script>
</head>

<body>

    <?php include("includes/user_header.php"); ?>

    <?php

    $order_id = $_GET['order_id'];


    $get_orders = "select * from orders where (seller_id='$login_seller_id' or buyer_id='$login_seller_id') AND order_id='$order_id'";

    $run_orders = mysqli_query($con, $get_orders);

    $row_orders = mysqli_fetch_array($run_orders);

    $order_id = $row_orders['order_id'];

    $order_number = $row_orders['order_number'];

    $proposal_id = $row_orders['proposal_id'];

    $seller_id = $row_orders['seller_id'];

    $buyer_id = $row_orders['buyer_id'];

    $order_price = $row_orders['order_price'];

    $order_qty = $row_orders['order_qty'];

    $order_date = $row_orders['order_date'];

    $order_duration = $row_orders['order_duration'];

    $order_time = $row_orders['order_time'];

    $order_fee = $row_orders['order_fee'];

    $order_desc = $row_orders['order_description'];

    $order_status = $row_orders['order_status'];


    $total = $order_price + $order_fee;


    //// Select Order Proposal Details ///

    $get_proposal = "select * from proposals where proposal_id='$proposal_id'";

    $run_proposal = mysqli_query($con, $get_proposal);

    $row_proposal = mysqli_fetch_array($run_proposal);

    $proposal_title = $row_proposal['proposal_title'];

    $proposal_img1 = $row_proposal['proposal_img1'];

    $proposal_url = $row_proposal['proposal_url'];

    $buyer_instruction = $row_proposal['buyer_instruction'];


    $get_payment_settings = "select * from payment_settings";

    $run_payment_setttings = mysqli_query($con, $get_payment_settings);

    $row_payment_settings = mysqli_fetch_array($run_payment_setttings);

    $comission_percentage = $row_payment_settings['comission_percentage'];


    function getPercentOfValue($amount, $percentage)
    {

        $calculate_percentage = ($percentage / 100) * $amount;

        return $amount - $calculate_percentage;
    }


    $seller_price = getPercentOfValue($order_price, $comission_percentage);



    /// Select Order Seller Details ///

    $select_seller = "select * from sellers where seller_id='$seller_id'";

    $run_seller = mysqli_query($con, $select_seller);

    $row_seller = mysqli_fetch_array($run_seller);

    $seller_user_name = $row_seller['seller_user_name'];

    $order_seller_rating = $row_seller['seller_rating'];

    if ($order_seller_rating > "100") {

        $update_seller_rating = "update sellers set seller_rating='100' where seller_id='$seller_id'";

        $run_update_seller_rating = mysqli_query($con, $update_seller_rating);
    }


    //// Select Order Buyer Details ///

    $select_buyer = "select * from sellers where seller_id='$buyer_id'";

    $run_buyer = mysqli_query($con, $select_buyer);

    $row_buyer = mysqli_fetch_array($run_buyer);

    $buyer_user_name = $row_buyer['seller_user_name'];



    ?>


    <?php if ($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested" or $order_status == "cancellation requested") { ?>

        <!--- order-status-bar starts --->
        <div id="order-status-bar">

            <!--- row starts --->
            <div class="row">

                <!---- col-md-8 offset-md-2 starts --->
                <div class="col-md-8 offset-md-2">

                    <h6 class="float-left mt-2">

                        <span class="border border-primary rounded p-1">
                            Order: #<?php echo $order_number; ?> : <?php if ($order_status == "progress") {
                                                                        echo "In";
                                                                    } ?>


                            <?php echo ucwords($order_status); ?>
                        </span>

                    </h6>

                    <h2 class="float-right text-muted">
                        <?php if ($order_status == "progress") {
                            echo "In";
                        } ?>

                        <?php echo ucwords($order_status); ?>
                    </h2>

                </div>
                <!---- col-md-8 offset-md-2 ends --->

            </div>
            <!--- row ends --->

        </div>
        <!--- order-status-bar ends --->

    <?php } elseif ($order_status == "cancelled") { ?>

        <!--- order-status-bar starts --->
        <div id="order-status-bar">

            <!--- row starts --->
            <div class="row">

                <!---- col-md-8 offset-md-2 starts --->
                <div class="col-md-8 offset-md-2">

                    <h6 class="float-left mt-2">

                        <i class="fa fa-lg fa-times-circle"> </i> Order Cancelled

                        <i class="fa fa-lg fa-check-circle"> </i> Payment Returned To Buyer

                    </h6>

                    <h2 class="float-right text-muted"> Order Cancelled </h2>

                </div>
                <!---- col-md-8 offset-md-2 ends --->

            </div>
            <!--- row ends --->

        </div>
        <!--- order-status-bar ends --->

    <?php } elseif ($order_status == "completed") { ?>

        <!--- order-status-bar starts --->
        <div id="order-status-bar" class="bg-success text-white">

            <!--- row starts --->
            <div class="row">

                <!---- col-md-10 offset-md-1 starts --->
                <div class="col-md-10 offset-md-1">

                    <?php if ($seller_id == $login_seller_id) { ?>

                        <h6 class="float-left mt-2">

                            <i class="fa fa-lg fa-check-circle-o"></i> WORK DELIVERED

                        </h6>

                        <h2 class="float-right">

                            <i class="fa fa-check-circle"></i> ORDER COMPLETED. YOU EARNED ₹<?php echo $seller_price; ?>

                        </h2>

                    <?php } elseif ($buyer_id == $login_seller_id) { ?>

                        <h6 class="float-left mt-2">

                            <i class="fa fa-lg fa-check-circle-o"></i> Delivery Submitted

                        </h6>

                        <h2 class="float-right">

                            <i class="fa fa-check-circle"></i> ORDER COMPLETED

                        </h2>

                    <?php
                } ?>

                </div>
                <!---- col-md-10 offset-md-1 ends --->

            </div>
            <!--- row ends --->

        </div>
        <!--- order-status-bar ends --->

    <?php } ?>


    <!--- container order-page mt-2 starts --->
    <div class="container order-page mt-2">

        <!--- row starts --->
        <div class="row">

            <!--- col-md-12 starts --->
            <div class="col-md-12">

                <!--- row starts --->
                <div class="row">

                    <!--- col-md-10 offset-md-1 starts --->
                    <div class="col-md-10 offset-md-1">

                        <!--- nav nav-tabs mb-3 mt-3 starts --->
                        <ul class="nav nav-tabs mb-3 mt-3">

                            <li class="nav-item">

                                <a href="#order-activity" data-toggle="tab" class="nav-link active">

                                    Order Activity

                                </a>

                            </li>

                            <?php if ($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested") { ?>

                                <li class="nav-item">

                                    <a href="#resolution-center" data-toggle="tab" class="nav-link">

                                        Resolution Center

                                    </a>

                                </li>

                            <?php } ?>

                        </ul>
                        <!--- nav nav-tabs mb-3 mt-3 ends --->

                    </div>
                    <!--- col-md-10 offset-md-1 ends --->

                </div>
                <!--- row ends --->

            </div>
            <!--- col-md-12 ends --->


            <!--- col-md-12 tab-content mt-2 mb-4 starts --->
            <div class="col-md-12 tab-content mt-2 mb-4">

                <!--- order-activity tab-pane fade show active starts --->
                <div id="order-activity" class="tab-pane fade show active">

                    <!--- row starts --->
                    <div class="row">

                        <!--- col-md-10 offset-md-1 Starts --->
                        <div class="col-md-10 offset-md-1">

                            <!--- card Starts --->
                            <div class="card">

                                <!--- card-body starts --->
                                <div class="card-body">

                                    <!--- row starts --->
                                    <div class="row">

                                        <!--- col-md-2 Starts --->
                                        <div class="col-md-2">

                                            <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid d-lg-block d-md-block d-none">

                                        </div>
                                        <!--- col-md-2 ends --->


                                        <!--- col-md-10 starts --->
                                        <div class="col-md-10">

                                            <?php if ($seller_id == $login_seller_id) { ?>

                                                <h1 class="text-success float-right d-lg-block d-md-block d-none">
                                                    ₹<?php echo $order_price; ?>
                                                </h1>

                                                <h4>

                                                    Order #<?php echo $order_number; ?>

                                                    <small>

                                                        <a href="proposals/<?php echo $proposal_url; ?>" target="_blank">

                                                            View Proposal

                                                        </a>

                                                    </small>

                                                </h4>

                                                <!--- text-muted starts --->
                                                <p class="text-muted">

                                                    <span class="font-weight-bold">
                                                        Buyer :
                                                    </span>

                                                    <a href="<?php echo $buyer_user_name; ?>" target="_blank" class="seller-buyer-name mr-1">

                                                        <?php echo $buyer_user_name; ?>

                                                    </a>

                                                    | <span class="font-weight-bold ml-1">
                                                        Status :
                                                    </span>
                                                    <?php echo $order_status; ?>

                                                    | <span class="font-weight-bold ml-1">
                                                        Date :
                                                    </span>
                                                    <?php echo $order_date; ?>

                                                </p>
                                                <!--- text-muted ends --->

                                            <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                                <h1 class="text-success float-right d-lg-block d-md-block d-none">
                                                    ₹<?php echo $total; ?>
                                                </h1>

                                                <h4> <?php echo $proposal_title; ?> </h4>

                                                <!--- text-muted starts --->
                                                <p class="text-muted">

                                                    <span class="font-weight-bold">
                                                        Seller :
                                                    </span>

                                                    <a href="<?php echo $seller_user_name; ?>" target="_blank" class="seller-buyer-name mr-1">

                                                        <?php echo $seller_user_name; ?>

                                                    </a>

                                                    | <span class="font-weight-bold ml-1">
                                                        Order :
                                                    </span>
                                                    #<?php echo $order_number; ?>

                                                    | <span class="font-weight-bold ml-1">
                                                        Date :
                                                    </span>
                                                    <?php echo $order_date; ?>

                                                </p>
                                                <!--- text-muted ends --->

                                            <?php } ?>

                                        </div>
                                        <!--- col-md-10 ends --->

                                    </div>
                                    <!--- row ends --->


                                    <!--- row d-lg-flex d-md-flex d-none starts --->
                                    <div class="row d-lg-flex d-md-flex d-none">

                                        <!--- col-md-12 starts --->
                                        <div class="col-md-12">

                                            <!--- table mt-3 starts --->
                                            <table class="table mt-3">

                                                <!--- thead starts --->
                                                <thead>

                                                    <tr>

                                                        <th>Item</th>

                                                        <th>Quantity</th>

                                                        <th>Duration</th>

                                                        <th>Amount</th>

                                                    </tr>

                                                </thead>
                                                <!--- thead ends --->

                                                <!--- tbody starts --->
                                                <tbody>

                                                    <tr>

                                                        <td class="font-weight-bold" width="600">

                                                            <?php echo $proposal_title; ?>

                                                        </td>

                                                        <td> <?php echo $order_qty; ?> </td>

                                                        <td> <?php echo $order_duration; ?> </td>

                                                        <td>

                                                            ₹<?php if ($seller_id == $login_seller_id) { ?>

                                                                <?php echo $order_price; ?>

                                                            <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                                                <?php echo $order_price; ?>

                                                            <?php } ?>

                                                        </td>

                                                    </tr>

                                                    <?php if ($buyer_id == $login_seller_id) {  ?>

                                                        <?php if (!empty($order_fee)) { ?>

                                                            <tr>

                                                                <td> Processing Fee </td>

                                                                <td> </td>

                                                                <td> </td>

                                                                <td> ₹<?php echo $order_fee; ?> </td>

                                                            </tr>

                                                        <?php } ?>

                                                    <?php } ?>

                                                    <tr>

                                                        <td colspan="4">

                                                            <span class="float-right mr-4">

                                                                <strong>Total:</strong>

                                                                ₹<?php if ($seller_id == $login_seller_id) { ?>

                                                                    <?php echo $order_price; ?>

                                                                <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                                                    <?php echo $total; ?>

                                                                <?php } ?>

                                                            </span>

                                                        </td>

                                                    </tr>

                                                </tbody>
                                                <!--- tbody ends --->

                                            </table>
                                            <!--- table mt-3 ends --->


                                            <?php if (!empty($order_desc)) { ?>

                                                <!--- table Starts --->
                                                <table class="table">

                                                    <!--- thead Starts --->
                                                    <thead>

                                                        <tr>

                                                            <th> Description </th>

                                                        </tr>

                                                    </thead>
                                                    <!--- thead Ends --->

                                                    <!--- tbody Starts --->
                                                    <tbody>

                                                        <tr>

                                                            <td width="600">

                                                                <?php echo $order_desc; ?>

                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                    <!--- tbody Ends --->

                                                </table>
                                                <!--- table Ends --->

                                            <?php } ?>

                                        </div>
                                        <!--- col-md-12 ends --->

                                    </div>
                                    <!--- row d-lg-flex d-md-flex d-none ends --->

                                </div>
                                <!--- card-body ends --->

                            </div>
                            <!--- card ends --->


                            <?php if ($order_status == "progress" or $order_status == "revision requested") { ?>


                                <?php if ($seller_id == $login_seller_id) { ?>

                                    <h2 class="text-center mt-2" id="countdown-heading">

                                        You Needs To Deliver Your Order Before This Time

                                    </h2>

                                <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                    <h2 class="text-center mt-2" id="countdown-heading">

                                        Seller Needs To Deliver Your Order Before This Time

                                    </h2>

                                <?php } ?>


                                <!--- countdown-timer starts --->
                                <div id="countdown-timer">

                                    <!--- row starts --->
                                    <div class="row">

                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box starts --->
                                        <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">

                                            <p class="countdown-number" id="days"></p>

                                            <p class="countdown-title">Days</p>

                                        </div>
                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box ends --->


                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box starts --->
                                        <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">

                                            <p class="countdown-number" id="hours"></p>

                                            <p class="countdown-title">Hours</p>

                                        </div>
                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box ends --->


                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box starts --->
                                        <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">


                                            <p class="countdown-number" id="minutes"></p>

                                            <p class="countdown-title">Minutes</p>

                                        </div>
                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box ends --->


                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box starts --->
                                        <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">

                                            <p class="countdown-number" id="seconds"></p>

                                            <p class="countdown-title">Seconds</p>

                                        </div>
                                        <!--- col-lg-3 col-md-6 col-sm-6 countdown-box ends --->

                                    </div>
                                    <!--- row ends --->

                                </div>
                                <!--- countdown-timer ends --->

                            <?php } ?>


                            <?php if ($buyer_id == $login_seller_id) { ?>

                                <!--- card mb-3 mt-3 Starts --->
                                <div class="card mb-3 mt-3">

                                    <div class="card-header">

                                        <h5>THE SELLER WILL ONLY GET STARTED AFTER YOU SUBMIT THIS INFORMATION </h5>

                                    </div>


                                    <div class="card-body">

                                        <h6>

                                            <?php echo $seller_user_name; ?>

                                            requires the following information in order to get started

                                        </h6>

                                        <p><?php echo $buyer_instruction; ?></p>

                                    </div>

                                </div>
                                <!--- card mb-3 mt-3 Ends --->

                            <?php } ?>


                            <!--- order-conversations bg-white mt-3 starts --->
                            <div id="order-conversations" class="bg-white mt-3">

                                <?php include("order_conversations.php"); ?>

                            </div>
                            <!--- order-conversations bg-white mt-3 ends --->


                            <?php if ($seller_id == $login_seller_id) { ?>

                                <?php if ($order_status == "progress" or $order_status == "revision requested") { ?>

                                    <!--- center Starts --->
                                    <center>

                                        <button class="btn btn-success btn-lg mt-4 mb-2" data-toggle="modal" data-target="#deliver-order-modal">

                                            Deliver Your Order

                                        </button>

                                    </center>
                                    <!--- center ends --->

                                <?php
                            } ?>

                                <?php if ($order_status == "delivered") { ?>

                                    <center>
                                        <!--- center Starts --->

                                        <button class="btn btn-success btn-lg mt-4 mb-2" data-toggle="modal" data-target="#deliver-order-modal">

                                            Deliver Your Order Again

                                        </button>

                                    </center>
                                    <!--- center Ends --->

                                <?php } ?>


                            <?php } ?>

                            <!--- proposal-reviews mt-3 starts --->
                            <div class="proposal-reviews mt-3">

                                <?php if ($order_status == "completed") { ?>


                                    <?php

                                    $get_buyer_reviews = "select * from buyer_reviews where order_id='$order_id'";

                                    $run_buyer_reviews = mysqli_query($con, $get_buyer_reviews);

                                    $count_buyer_reviews = mysqli_num_rows($run_buyer_reviews);

                                    $row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews);

                                    $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                    $buyer_review = $row_buyer_reviews['buyer_review'];

                                    $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                    $review_date = $row_buyer_reviews['review_date'];


                                    $select_review_buyer = "select * from sellers where seller_id='$review_buyer_id'";

                                    $run_review_buyer = mysqli_query($con, $select_review_buyer);

                                    $row_review_buyer = mysqli_fetch_array($run_review_buyer);

                                    $buyer_user_name = $row_review_buyer['seller_user_name'];

                                    $buyer_image = $row_review_buyer['seller_image'];



                                    $get_seller_reviews = "select * from seller_reviews where order_id='$order_id'";

                                    $run_seller_reviews = mysqli_query($con, $get_seller_reviews);

                                    $count_seller_reviews = mysqli_num_rows($run_seller_reviews);

                                    $row_seller_reviews = mysqli_fetch_array($run_seller_reviews);

                                    $seller_rating = $row_seller_reviews['seller_rating'];

                                    $seller_review = $row_seller_reviews['seller_review'];

                                    $review_seller_id = $row_seller_reviews['review_seller_id'];


                                    $select_review_seller = "select * from sellers where seller_id='$review_seller_id'";

                                    $run_review_seller = mysqli_query($con, $select_review_seller);

                                    $row_review_seller = mysqli_fetch_array($run_review_seller);

                                    $seller_image = $row_review_seller['seller_image'];


                                    $count_all_reviews = "$count_buyer_reviews $count_seller_reviews";


                                    if ($count_all_reviews == "00") { } else {

                                        ?>

                                        <h2 class="text-center"> Order Reviews </h2>

                                        <!--- card rounded-0 mt-3 starts --->
                                        <div class="card rounded-0 mt-3">

                                            <!--- card-body starts --->
                                            <div class="card-body">

                                                <!--- reviews-list starts --->
                                                <ul class="reviews-list">

                                                    <?php if (!$count_buyer_reviews == 0) { ?>

                                                        <!--- star-rating-row starts --->
                                                        <li class="star-rating-row">

                                                            <!--- user-picture starts --->
                                                            <span class="user-picture">

                                                                <img src="user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                                            </span>
                                                            <!--- user-picture ends --->


                                                            <!--- h4 starts --->
                                                            <h4>

                                                                <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>

                                                                <?php

                                                                for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                                    echo "<img src='images/user_rate_full.png'>";
                                                                }

                                                                for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                                    echo "<img src='images/user_rate_blank.png'>";
                                                                }

                                                                ?>

                                                            </h4>
                                                            <!--- h4 ends --->

                                                            <!--- msg-body Starts --->
                                                            <div class="msg-body">

                                                                <?php echo $buyer_review; ?>

                                                            </div>
                                                            <!--- msg-body ends --->

                                                            <span class="rating-date">
                                                                <?php echo $review_date; ?>
                                                            </span>

                                                        </li>
                                                        <!--- star-rating-row ends --->

                                                        <hr>

                                                    <?php } ?>

                                                    <?php if (!$count_seller_reviews == 0) { ?>

                                                        <!--- rating-seller starts --->
                                                        <li class="rating-seller">

                                                            <!--- user-picture starts --->
                                                            <span class="user-picture">

                                                                <img src="user_images/<?php echo $seller_image; ?>" width="40" height="40">

                                                            </span>
                                                            <!--- user-picture ends --->

                                                            <!--- h4 starts --->
                                                            <h4>

                                                                <span class="mr-1"> Seller's Feedback </span>

                                                                <?php

                                                                for ($seller_i = 0; $seller_i < $seller_rating; $seller_i++) {

                                                                    echo "<img src='images/user_rate_full.png'>";
                                                                }

                                                                for ($seller_i = $seller_rating; $seller_i < 5; $seller_i++) {

                                                                    echo "<img src='images/user_rate_blank.png'>";
                                                                }

                                                                ?>

                                                            </h4>
                                                            <!--- h4 ends --->

                                                            <!--- msg-body starts --->
                                                            <div class="msg-body">

                                                                <?php echo $seller_review; ?>

                                                            </div>
                                                            <!--- msg-body ends --->

                                                        </li>
                                                        <!--- rating-seller ends --->

                                                    <?php } ?>

                                                </ul>
                                                <!--- reviews-list ends --->

                                            </div>
                                            <!--- card-body ends --->

                                        </div>
                                        <!--- card rounded-0 mt-3 ends --->

                                    <?php } ?>


                                    <?php if ($seller_id == $login_seller_id) { ?>

                                        <?php if ($count_seller_reviews == 0) { ?>

                                            <!--- order-review-box mb-3 p-3 starts --->
                                            <div class="order-review-box mb-3 p-3">

                                                <h3 class="text-center text-white"> Please Review To Buyer </h3>

                                                <!--- row starts --->
                                                <div class="row">

                                                    <!--- col-md-8 offset-md-2 starts --->
                                                    <div class="col-md-8 offset-md-2">

                                                        <!--- form starts --->
                                                        <form method="post" align="center">

                                                            <!--- form-group starts --->
                                                            <div class="form-group">

                                                                <label class="h6 text-white"> Review Rating </label>

                                                                <select name="rating" class="rating-select">

                                                                    <option value="1">1</option>

                                                                    <option value="2">2</option>

                                                                    <option value="3">3</option>

                                                                    <option value="4">4</option>

                                                                    <option value="5">5</option>

                                                                </select>

                                                                <script>
                                                                    $(document).ready(function() {

                                                                        $('.rating-select').barrating({

                                                                            theme: 'fontawesome-stars'

                                                                        });

                                                                    });
                                                                </script>


                                                            </div>
                                                            <!--- form-group ends --->

                                                            <textarea name="review" class="form-control mb-3" rows="5" placeholder="Write Your Experience The With Buyer"></textarea>

                                                            <input type="submit" name="seller_review_submit" class="btn btn-success" value="Give Your Review">

                                                        </form>
                                                        <!--- form ends --->

                                                        <?php

                                                        if (isset($_POST['seller_review_submit'])) {

                                                            $rating = $_POST['rating'];

                                                            $review = $_POST['review'];

                                                            $insert_review = "insert into seller_reviews (order_id,review_seller_id,seller_rating,seller_review) values ('$order_id','$seller_id','$rating','$review')";


                                                            $run_review = mysqli_query($con, $insert_review);

                                                            $last_update_date = date("h:m: M d Y");

                                                            $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$buyer_id','$login_seller_id','$order_id','seller_order_review','$last_update_date','unread')";

                                                            $run_notification = mysqli_query($con, $insert_notification);

                                                            echo "<script>alert('Your Review Has Been Submited To Buyer.')</script>";

                                                            echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                                                        }

                                                        ?>

                                                    </div>
                                                    <!--- col-md-8 offset-md-2 ends --->

                                                </div>
                                                <!--- row ends --->

                                            </div>
                                            <!--- order-review-box mb-3 p-3 ends --->

                                        <?php } else { ?>

                                            <!--- order-review-box mb-3 p-3 starts --->
                                            <div class="order-review-box mb-3 p-3">

                                                <h3 class="text-center text-white"> Edit Review To Buyer </h3>

                                                <!--- row starts --->
                                                <div class="row">

                                                    <!--- col-md-8 offset-md-2 starts --->
                                                    <div class="col-md-8 offset-md-2">

                                                        <!--- form starts --->
                                                        <form method="post" align="center">

                                                            <!--- form-group starts --->
                                                            <div class="form-group">

                                                                <label class="h6 text-white"> Review Rating </label>

                                                                <select name="rating" class="rating-select-update">

                                                                    <option value="1">1</option>

                                                                    <option value="2">2</option>

                                                                    <option value="3">3</option>

                                                                    <option value="4">4</option>

                                                                    <option value="5">5</option>

                                                                </select>

                                                                <script>
                                                                    $(document).ready(function() {

                                                                        $('.rating-select-update').barrating({

                                                                            theme: 'fontawesome-stars',

                                                                            initialRating: '<?php echo $seller_rating; ?>'

                                                                        });

                                                                    });
                                                                </script>

                                                            </div>
                                                            <!--- form-group ends --->

                                                            <textarea name="review" class="form-control mb-3" rows="5" placeholder="Write Your Experience With Buyer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php echo $seller_review; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </textarea>

                                                            <input type="submit" name="seller_review_update" class="btn btn-success" value="Update Your Review">

                                                        </form>
                                                        <!--- form ends --->

                                                        <?php

                                                        if (isset($_POST['seller_review_update'])) {

                                                            $rating = $_POST['rating'];

                                                            $review = $_POST['review'];

                                                            $update_review = "update seller_reviews set seller_review='$review',seller_rating='$rating' where order_id='$order_id'";

                                                            $run_review = mysqli_query($con, $update_review);

                                                            echo "<script>alert('Your Review Has Been Updated.')</script>";

                                                            echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                                                        }

                                                        ?>

                                                    </div>
                                                    <!--- col-md-8 offset-md-2 ends --->

                                                </div>
                                                <!--- row ends --->

                                            </div>
                                            <!--- order-review-box mb-3 p-3 ends --->

                                        <?php } ?>


                                    <?php } elseif ($buyer_id == $login_seller_id) { ?>


                                        <?php if ($count_buyer_reviews == 0) { ?>


                                            <div class="order-review-box mb-3 p-3">
                                                <!--- order-review-box mb-3 p-3 Starts --->

                                                <h3 class="text-center text-white"> Please Review To Seller </h3>

                                                <div class="row">
                                                    <!--- row Starts --->

                                                    <div class="col-md-8 offset-md-2">
                                                        <!--- col-md-8 offset-md-2 Starts --->

                                                        <form method="post" align="center">
                                                            <!--- form Starts --->

                                                            <div class="form-group">
                                                                <!--- form-group Starts --->

                                                                <label class="h6 text-white"> Review Rating </label>

                                                                <select name="rating" class="rating-select">

                                                                    <option value="1">1</option>

                                                                    <option value="2">2</option>

                                                                    <option value="3">3</option>

                                                                    <option value="4">4</option>

                                                                    <option value="5">5</option>

                                                                </select>

                                                                <script>
                                                                    $(document).ready(function() {

                                                                        $('.rating-select').barrating({

                                                                            theme: 'fontawesome-stars'

                                                                        });

                                                                    });
                                                                </script>


                                                            </div>
                                                            <!--- form-group Ends --->

                                                            <textarea name="review" class="form-control mb-3" rows="5" placeholder="Write Your Experience With Seller"></textarea>

                                                            <input type="submit" name="buyer_review_submit" class="btn btn-success" value="Give Your Review">

                                                        </form>
                                                        <!--- form Ends --->

                                                        <?php

                                                        if (isset($_POST['buyer_review_submit'])) {

                                                            $rating = $_POST['rating'];

                                                            $review = $_POST['review'];

                                                            $date = date("M d Y");

                                                            $insert_review = "insert into buyer_reviews (proposal_id,order_id,review_buyer_id,buyer_rating,buyer_review,review_seller_id,review_date) values ('$proposal_id','$order_id','$buyer_id','$rating','$review','$seller_id','$date')";

                                                            $run_review = mysqli_query($con, $insert_review);

                                                            $last_update_date = date("h:m: M d Y");

                                                            $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$seller_id','$login_seller_id','$order_id','buyer_order_review','$last_update_date','unread')";

                                                            $run_notification = mysqli_query($con, $insert_notification);

                                                            $ratings = array();

                                                            $sel_proposal_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

                                                            $run_proposal_reviews = mysqli_query($con, $sel_proposal_reviews);

                                                            while ($row_proposal_reviews = mysqli_fetch_array($run_proposal_reviews)) {

                                                                $proposal_buyer_rating = $row_proposal_reviews['buyer_rating'];

                                                                array_push($ratings, $proposal_buyer_rating);
                                                            }

                                                            array_push($ratings, $rating);

                                                            $total = array_sum($ratings);

                                                            $avg = $total / count($ratings);

                                                            $update_proposal_rating = substr($avg, 0, 1);


                                                            if ($rating == "5") {

                                                                if ($order_seller_rating == "100") { } else {

                                                                    $update_seller_rating = "update sellers set seller_rating=seller_rating+7 where seller_id='$seller_id'";

                                                                    $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                                }
                                                            } elseif ($rating == "4") {

                                                                if ($order_seller_rating == "100") { } else {

                                                                    $update_seller_rating = "update sellers set seller_rating=seller_rating+2 where seller_id='$seller_id'";

                                                                    $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                                }
                                                            } elseif ($rating == "3") {


                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-3 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            } elseif ($rating == "2") {


                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-5 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            } elseif ($rating == "1") {

                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-7 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            }

                                                            $update_proposal_rating = "update proposals set proposal_rating='$update_proposal_rating' where proposal_id='$proposal_id'";

                                                            $run_update = mysqli_query($con, $update_proposal_rating);

                                                            if ($run_update) {

                                                                echo "<script>alert('Your Review Has Been Submited To Seller.')</script>";

                                                                echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                                                            }
                                                        }

                                                        ?>

                                                    </div>
                                                    <!--- col-md-8 offset-md-2 Ends --->

                                                </div>
                                                <!--- row Ends --->

                                            </div>
                                            <!--- order-review-box mb-3 p-3 Ends --->

                                        <?php } else { ?>

                                            <div class="order-review-box mb-3 p-3">
                                                <!--- order-review-box mb-3 p-3 Starts --->

                                                <h3 class="text-center text-white"> Edit Review To Seller </h3>

                                                <div class="row">
                                                    <!--- row Starts --->

                                                    <div class="col-md-8 offset-md-2">
                                                        <!--- col-md-8 offset-md-2 Starts --->

                                                        <form method="post" align="center">
                                                            <!--- form Starts --->

                                                            <div class="form-group">
                                                                <!--- form-group Starts --->

                                                                <label class="h6 text-white"> Review Rating </label>

                                                                <select name="rating" class="rating-select-update">

                                                                    <option value="1">1</option>

                                                                    <option value="2">2</option>

                                                                    <option value="3">3</option>

                                                                    <option value="4">4</option>

                                                                    <option value="5">5</option>

                                                                </select>

                                                                <script>
                                                                    $(document).ready(function() {

                                                                        $('.rating-select-update').barrating({

                                                                            theme: 'fontawesome-stars',

                                                                            initialRating: '<?php echo $buyer_rating; ?>'

                                                                        });

                                                                    });
                                                                </script>


                                                            </div>
                                                            <!--- form-group Ends --->

                                                            <textarea name="review" class="form-control mb-3" rows="5" placeholder="Write Your Experience With Seller">
                                                                                                                                                                                                                                                                                                                                                                                                                        <?php echo $buyer_review; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                        </textarea>

                                                            <input type="submit" name="buyer_review_update" class="btn btn-success" value="Update Your Review">

                                                        </form>
                                                        <!--- form Ends --->

                                                        <?php

                                                        if (isset($_POST['buyer_review_update'])) {

                                                            $rating = $_POST['rating'];

                                                            $review = $_POST['review'];


                                                            $update_review = "update buyer_reviews set buyer_review='$review',buyer_rating='$rating' where order_id='$order_id'";

                                                            $run_review = mysqli_query($con, $update_review);


                                                            $ratings = array();

                                                            $sel_proposal_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

                                                            $run_proposal_reviews = mysqli_query($con, $sel_proposal_reviews);

                                                            while ($row_proposal_reviews = mysqli_fetch_array($run_proposal_reviews)) {

                                                                $proposal_buyer_rating = $row_proposal_reviews['buyer_rating'];

                                                                array_push($ratings, $proposal_buyer_rating);
                                                            }

                                                            array_push($ratings, $rating);

                                                            $total = array_sum($ratings);

                                                            $avg = $total / count($ratings);

                                                            $update_proposal_rating = substr($avg, 0, 1);


                                                            if ($rating == "5") {

                                                                if ($order_seller_rating == "100") { } else {

                                                                    $update_seller_rating = "update sellers set seller_rating=seller_rating+7 where seller_id='$seller_id'";

                                                                    $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                                }
                                                            } elseif ($rating == "4") {

                                                                if ($order_seller_rating == "100") { } else {

                                                                    $update_seller_rating = "update sellers set seller_rating=seller_rating+2 where seller_id='$seller_id'";

                                                                    $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                                }
                                                            } elseif ($rating == "3") {


                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-3 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            } elseif ($rating == "2") {


                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-5 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            } elseif ($rating == "1") {

                                                                $update_seller_rating = "update sellers set seller_rating=seller_rating-7 where seller_id='$seller_id'";

                                                                $run_seller_rating = mysqli_query($con, $update_seller_rating);
                                                            }

                                                            $update_proposal_rating = "update proposals set proposal_rating='$update_proposal_rating' where proposal_id='$proposal_id'";

                                                            $run_update = mysqli_query($con, $update_proposal_rating);

                                                            if ($run_update) {

                                                                echo "<script>alert('Your Review Has Been Updated.')</script>";

                                                                echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                                                            }
                                                        }

                                                        ?>

                                                    </div>
                                                    <!--- col-md-8 offset-md-2 Ends --->

                                                </div>
                                                <!--- row Ends --->

                                            </div>
                                            <!--- order-review-box mb-3 p-3 Ends --->

                                        <?php } ?>


                                    <?php } ?>

                                <?php
                            } ?>

                            </div>
                            <!--- proposal-reviews mt-3 Ends --->


                            <?php if ($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested") { ?>

                                <!--- insert-message-box Starts --->
                                <div class="insert-message-box">

                                    <?php if ($buyer_id == $login_seller_id and $order_status == "pending") { ?>

                                        <div class="float-left">

                                            <span class="font-weight-bold text-danger"> RESPONSE TO START ORDER </span>

                                        </div>

                                    <?php } ?>

                                    <div class="float-right">
                                        <!--- float-right Starts --->

                                        <?php

                                        if ($seller_id == $login_seller_id) {


                                            $select_buyer = "select * from sellers where seller_id='$buyer_id'";

                                            $run_buyer = mysqli_query($con, $select_buyer);

                                            $row_buyer = mysqli_fetch_array($run_buyer);

                                            $buyer_user_name = $row_buyer['seller_user_name'];

                                            $buyer_status = $row_buyer['seller_status'];
                                        } elseif ($buyer_id == $login_seller_id) {


                                            $select_seller = "select * from sellers where seller_id='$seller_id'";

                                            $run_seller = mysqli_query($con, $select_seller);

                                            $row_seller = mysqli_fetch_array($run_seller);

                                            $seller_user_name = $row_seller['seller_user_name'];

                                            $seller_status = $row_seller['seller_status'];
                                        }

                                        ?>

                                        <!--- text-muted mt-1 Starts --->
                                        <p class="text-muted mt-1">

                                            <?php if ($seller_id == $login_seller_id) { ?>

                                                <?php echo $buyer_user_name; ?> <span class="text-success"> <?php echo $buyer_status; ?> </span> | Local Time

                                            <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                                <?php echo $seller_user_name; ?> <span class="text-success"> <?php echo $seller_status; ?> </span> | Local Time

                                            <?php } ?>

                                            <i class="fa fa-sun-o"></i>

                                            <?php

                                            date_default_timezone_set("Asia/Kolkata");

                                            echo date("h:i A");

                                            ?>


                                        </p>
                                        <!--- text-muted mt-1 Ends --->

                                    </div>
                                    <!--- float-right Ends --->

                                    <!--- insert-message-form clearfix Starts --->
                                    <form id="insert-message-form" class="clearfix">

                                        <textarea id="message" rows="5" placeholder="Type Your Message Here..." class="form-control mb-2"></textarea>

                                        <label class="float-left h6 mt-2 mr-2"> Attach File (optional) </label>

                                        <!--- float-left Starts --->
                                        <label class="float-left mt-2">

                                            <input type="file" id="file" class="form-control-file float-left">

                                        </label>
                                        <!--- float-left Ends --->


                                        <input type="submit" class="btn btn-success float-right" value="Send">

                                    </form>
                                    <!--- insert-message-form clearfix Ends --->

                                </div>
                                <!--- insert-message-box Ends --->

                                <div id="upload_file_div"></div>

                                <div id="message_data_div"></div>

                            <?php } ?>

                        </div>
                        <!--- col-md-10 offset-md-1 ends --->

                    </div>
                    <!--- row ends --->

                </div>
                <!--- order-activity tab-pane fade show active ends --->


                <!-- resolution-center tab-pane fade starts -->
                <div id="resolution-center" class="tab-pane fade">

                    <!-- row starts -->
                    <div class="row">

                        <!-- col-md-10 offset-md-1 starts -->
                        <div class="col-md-10 offset-md-1">

                            <!-- card starts -->
                            <div class="card">

                                <!-- card-body starts -->
                                <div class="card-body">

                                    <!-- row starts -->
                                    <div class="row">

                                        <!-- col-md-8 offset-md-2 starts -->
                                        <div class="col-md-8 offset-md-2">

                                            <h3 class="text-center mb-3"> Order Cancellation </h3>

                                            <!-- form starts -->
                                            <form method="post">

                                                <!-- form-group starts -->
                                                <div class="form-group">

                                                    <label class="font-weight-bold">
                                                        Cancellation Request Message
                                                    </label>

                                                    <textarea name="callcellation_message" placeholder="Enter Your Cancellation Request Message" rows="10" class="form-control" required></textarea>

                                                </div>
                                                <!-- form-group ends -->

                                                <!-- form-group starts -->
                                                <div class="form-group">

                                                    <label class="font-weight-bold"> Cancellation Request Reason </label>

                                                    <select name="cancellation_reason" class="form-control">

                                                        <option class="hidden"> Select Cancellation Reason </option>

                                                        <?php if ($seller_id == $login_seller_id) { ?>

                                                            <option> Buyer is not responding </option>

                                                            <option> Buyer did not accept the work </option>

                                                            <option> Buyer told me to, cancel this order. </option>

                                                            <option> Other Reasons. </option>


                                                        <?php } elseif ($buyer_id == $login_seller_id) { ?>

                                                            <option> Seller is not responding </option>

                                                            <option> Seller doesn't work well. </option>

                                                            <option> Seller told me to cancel this order. </option>

                                                            <option> Other Reasons. </option>

                                                        <?php }  ?>

                                                    </select>

                                                </div><!-- form-group ends -->

                                                <input type="submit" name="submit_cancellation_request" value="Send Cancellation Request" class="btn btn-success float-right">

                                            </form>
                                            <!-- form ends -->

                                            <?php

                                            if (isset($_POST['submit_cancellation_request'])) {

                                                $cancellation_message = mysqli_real_escape_string($con, $_POST['cancellation_message']);

                                                $cancellation_reason = mysqli_real_escape_string($con, $_POST['cancellation_reason']);

                                                date_default_timezone_set("Asia/Karachi");

                                                $last_update_date = date("h:i: M d, Y");

                                                $insert_cancellation_message = "insert into order_conversations (order_id,sender_id,message,file,date,reason,status) values ('$order_id','$login_seller_id','$cancellation_message','','$last_update_date','$cancellation_reason','cancellation_request')";

                                                $run_cancellation_message = mysqli_query($con, $insert_cancellation_message);

                                                if ($seller_id == $login_seller_id) {

                                                    $receiver_id = $buyer_id;
                                                } else {

                                                    $receiver_id = $seller_id;
                                                }

                                                if ($run_cancellation_message) {


                                                    $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$receiver_id','$login_seller_id','$order_id','cancellation_request','$last_update_date','unread')";

                                                    $run_notification = mysqli_query($con, $insert_notification);

                                                    $update_order = "update orders set order_status='cancellation requested' where order_id='$order_id'";

                                                    $run_update = mysqli_query($con, $update_order);

                                                    echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                                                }
                                            }

                                            ?>

                                        </div>
                                        <!-- col-md-8 offset-md-2 ends -->

                                    </div>
                                    <!-- row ends -->

                                </div>
                                <!-- card-body ends -->

                            </div>
                            <!-- card ends -->

                        </div>
                        <!-- col-md-10 offset-md-1 ends -->

                    </div>
                    <!-- row ends -->

                </div>
                <!-- resolution-center tab-pane fade ends -->

            </div>
            <!--- col-md-12 tab-content mt-2 mb-4 ends --->

        </div>
        <!--- row ends --->

    </div>
    <!--- container order-page mt-2 ends --->


    <?php if ($seller_id == $login_seller_id) { ?>

        <!--- deliver-order-modal modal fade starts --->
        <div id="deliver-order-modal" class="modal fade">

            <!--- modal-dialog starts --->
            <div class="modal-dialog">

                <!--- modal-content starts --->
                <div class="modal-content">

                    <!--- modal-header starts --->
                    <div class="modal-header">

                        <h5 class="modal-title"> Deliver Your Order Now </h5>

                        <button class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>

                    </div>
                    <!--- modal-header ends --->


                    <!--- modal-body Starts --->
                    <div class="modal-body">

                        <!--- form starts --->
                        <form method="post" enctype="multipart/form-data">

                            <!--- form-group starts --->
                            <div class="form-group">

                                <label class="font-weight-bold"> Message </label>

                                <textarea name="delivered_message" placeholder="Type Your Message Here..." class="form-control mb-2"></textarea>

                            </div>
                            <!--- form-group ends --->

                            <!--- form-group clearfix starts --->
                            <div class="form-group clearfix">

                                <input type="file" name="delivered_file" class="mt-1">

                                <input type="submit" name="submit_delivered" value="Deliver Order" class="btn btn-success float-right">

                            </div>
                            <!--- form-group clearfix ends --->

                        </form>
                        <!--- form ends --->

                        <?php

                        if (isset($_POST['submit_delivered'])) {

                            $d_message = mysqli_real_escape_string($con, $_POST['delivered_message']);

                            $d_file = $_FILES['delivered_file']['name'];

                            $d_file_tmp = $_FILES['delivered_file']['tmp_name'];

                            move_uploaded_file($d_file_tmp, "order_files/$d_file");

                            $last_update_date = date("h:m: M d Y");

                            $update_messages = "update order_conversations set status='message' where order_id='$order_id' and status='delivered'";

                            $run_update_messages = mysqli_query($con, $update_messages);

                            $insert_delivered_message = "insert into order_conversations (order_id,sender_id,message,file,date,reason,status) values ('$order_id','$seller_id','$d_message','$d_file','$last_update_date','','delivered')";

                            $run_delivered_message = mysqli_query($con, $insert_delivered_message);

                            if ($run_delivered_message) {

                                $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$buyer_id','$seller_id','$order_id','order_delivered','$last_update_date','unread')";

                                $run_notification = mysqli_query($con, $insert_notification);

                                $update_order = "update orders set order_status='delivered' where order_id='$order_id'";

                                $run_update = mysqli_query($con, $update_order);

                                echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                            }
                        }

                        ?>

                    </div>
                    <!--- modal-body ends --->

                </div>
                <!--- modal-content ends --->

            </div>
            <!--- modal-dialog ends --->

        </div>
        <!--- deliver-order-modal modal fade ends --->


    <?php } elseif ($buyer_id == $login_seller_id) { ?>

        <div id="revision-request-modal" class="modal fade">
            <!--- revision-request-modal fade Starts --->

            <div class="modal-dialog">
                <!--- modal-dialog Starts --->

                <div class="modal-content">
                    <!--- modal-content Starts --->

                    <div class="modal-header">
                        <!--- modal-header Starts --->

                        <h5 class="modal-title"> Submit Your Revision Request Now </h5>

                        <button class="close" data-dismiss="modal"> <span>&times;</span> </button>

                    </div>
                    <!--- modal-header Ends --->

                    <div class="modal-body">
                        <!--- modal-body Starts --->

                        <form method="post" enctype="multipart/form-data">
                            <!--- form Starts --->

                            <div class="form-group">
                                <!--- form-group Starts --->

                                <label class="font-weight-bold"> Request Message </label>

                                <textarea name="revison_message" placeholder="Type Your Message Here..." class="form-control mb-2"></textarea>

                            </div>
                            <!--- form-group Ends --->

                            <div class="form-group clearfix">
                                <!--- form-group clearfix Starts --->

                                <input type="file" name="revison_file" class="mt-1">

                                <input type="submit" name="submit_revison" value="Submit Revison" class="btn btn-success float-right">

                            </div>
                            <!--- form-group clearfix Ends --->

                        </form>
                        <!--- form Ends --->

                        <?php

                        if (isset($_POST['submit_revison'])) {

                            $revison_message = mysqli_real_escape_string($con, $_POST['revison_message']);

                            $revison_file = $_FILES['revison_file']['name'];

                            $revison_file_tmp = $_FILES['revison_file']['tmp_name'];

                            move_uploaded_file($revison_file_tmp, "order_files/$revison_file");

                            date_default_timezone_set("Asia/Karachi");

                            $last_update_date = date("h:i: M d, Y");

                            $update_messages_status = "update order_conversations set status='message' where order_id='$order_id' and status='delivered'";

                            $run_messages = mysqli_query($con, $update_messages_status);


                            $insert_revision_message = "insert into order_conversations (order_id,sender_id,message,file,date,reason,status) values ('$order_id','$buyer_id','$revison_message','$revison_file','$last_update_date','','revision')";

                            $run_revision_message = mysqli_query($con, $insert_revision_message);


                            if ($run_revision_message) {


                                $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$seller_id','$buyer_id','$order_id','order_revision','$last_update_date','unread')";

                                $run_notification = mysqli_query($con, $insert_notification);

                                $update_order = "update orders set order_status='revision requested' where order_id='$order_id'";

                                $run_update = mysqli_query($con, $update_order);

                                echo "<script>window.open('order_details.php?order_id=$order_id','_self')</script>";
                            }
                        }

                        ?>

                    </div>
                    <!--- modal-body Ends --->

                </div>
                <!--- modal-content Ends --->

            </div>
            <!--- modal-dialog Ends --->

        </div>
        <!--- revision-request-modal fade Ends --->

    <?php
} ?>

    <script>
        $(document).ready(function() {

            ////  Sticky Order Status Bar Code Starts  ////	

            $(function() {

                $(window).scroll(function() {

                    if ($(this).scrollTop() >= 100) {

                        $("#order-status-bar").addClass("order-status-bar-sticky");

                    } else {

                        $("#order-status-bar").removeClass("order-status-bar-sticky");
                    }
                });

            });

            ////  Sticky Order Status Bar Code Ends  ////	


            ////  Countdown Timer Code Starts  ////

            // Set the date we're counting down to

            var countDownDate = new Date("<?php echo $order_time; ?>").getTime() + (409 * 1600 * 22);

            // Update the count down every 1 second

            var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));

                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerHTML = days;

                document.getElementById("hours").innerHTML = hours;

                document.getElementById("minutes").innerHTML = minutes;

                document.getElementById("seconds").innerHTML = seconds;

                // If the count down is over, write some text 
                if (distance < 0) {

                    clearInterval(x);

                    <?php if (isset($_GET["selling_order"])) { ?>

                        document.getElementById("countdown-heading").innerHTML = "You Failed To Deliver Your Order On Time";

                    <?php
                } elseif (isset($_GET["buying_order"])) { ?>

                        document.getElementById("countdown-heading").innerHTML = "Seller Failed To Deliver Your Order On Time";

                    <?php
                } ?>

                    $("#countdown-timer .countdown-number").addClass("countdown-number-late");

                    document.getElementById("days").innerHTML = "Your";

                    document.getElementById("hours").innerHTML = "Order";

                    document.getElementById("minutes").innerHTML = "Is";

                    document.getElementById("seconds").innerHTML = "Late";

                }
            }, 1000);

            ////  Countdown Timer Code Ends  ////

            $(document).on('change', '#file', function() {

                var form_data = new FormData();

                form_data.append("file", document.getElementById('file').files[0]);

                $.ajax({

                    url: "upload_file.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,


                }).done(function(data) {

                    $("#upload_file_div").empty();

                    $("#upload_file_div").append(data);


                });

            });


            $('#insert-message-form').submit(function(e) {

                e.preventDefault();

                order_id = "<?php echo $order_id; ?>";

                order_message = $('#message').val();

                file = $('#file').val();

                if (file == "") {

                    order_file = file;

                } else {

                    order_file = document.getElementById('file').files[0].name;

                }

                $.ajax({

                    method: "POST",

                    url: "insert_order_message.php",

                    data: {
                        message: order_message,
                        file: order_file,
                        order_id: order_id
                    },

                    success: function(data) {

                        $('#message_data_div').html(data);

                        $('#message').val("");

                        $('#file').val("");

                    }

                });


            });



            setInterval(function() {

                order_id = "<?php echo $order_id; ?>";

                $.ajax({

                    method: "GET",

                    url: "order_conversations.php",

                    data: {
                        order_id: order_id
                    }

                }).done(function(data) {

                    $("#order-conversations").empty();

                    $("#order-conversations").append(data);


                });


            }, 1000);


        });
    </script>


    <?php include("includes/footer.php"); ?>

</body>

</html>