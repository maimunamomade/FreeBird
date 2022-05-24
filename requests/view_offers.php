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

$request_id = $_GET['request_id'];


$get_requests = "select * from buyer_requests where request_id='$request_id' AND request_status='active'";

$run_requests = mysqli_query($con, $get_requests);

$row_requests = mysqli_fetch_array($run_requests);

$request_id = $row_requests['request_id'];

$cat_id = $row_requests['cat_id'];

$child_id = $row_requests['child_id'];

$request_description = $row_requests['request_description'];

$request_date = $row_requests['request_date'];

$request_budget = $row_requests['request_budget'];

$request_delivery_time = $row_requests['delivery_time'];


$get_cats = "select * from categories where cat_id='$cat_id'";

$run_cats = mysqli_query($con, $get_cats);

$row_cats = mysqli_fetch_array($run_cats);

$cat_title = $row_cats['cat_title'];


$get_c_cats = "select * from categories_childs where child_id='$child_id'";

$run_c_cats = mysqli_query($con, $get_c_cats);

$row_c_cats = mysqli_fetch_array($run_c_cats);

$child_title = $row_c_cats['child_title'];


$select_offers = "select * from send_offers where request_id='$request_id' AND status='active'";

$run_offers = mysqli_query($con, $select_offers);

$count_offers = mysqli_num_rows($run_offers);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / View Request </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="../js/jquery.min.js"> </script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <!-- container mt-4 mb-4 starts -->
    <div class="container mt-4 mb-4">

        <!-- row view-offers starts -->
        <div class="row view-offers">

            <h2 class="mb-3 ml-3"> View Offers (<?php echo $count_offers; ?>) </h2>

            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <!-- card mb-4 rounded-0 starts -->
                <div class="card mb-4 rounded-0">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <h5 class="text-muted"> Request Description </h5>

                        <p class="offer-p">

                            <?php echo $request_description; ?>

                        </p>

                        <h5>
                            Request Details:
                        </h5>

                        <p class="offer-p">

                            <i class="fa fa-inr"></i> <span> Budget: </span> ₹<?php echo $request_budget; ?> |

                            <i class="fa fa-clock-o ml-1"></i> <span>Date: </span> <?php echo $request_date; ?> |

                            <i class="fa fa-clock-o ml-1"></i> <span>Duration: </span> <?php echo $request_delivery_time; ?> Delivery |

                            <i class="fa fa-archive ml-1"></i> <span>Category: </span> <?php echo $cat_title; ?> / <?php echo $child_title; ?> |

                        </p>

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card mb-4 rounded-0 ends -->


                <?php if ($count_offers == "0") { ?>

                    <!-- card rounded-0 mb-3 starts -->
                    <div class="card rounded-0 mb-3">

                        <!-- card-body starts -->
                        <div class="card-body">

                            <h2 class="text-center"> Your Request Has Not Received Offers Yet, Please Wait </h2>

                        </div>
                        <!-- card-body ends -->

                    </div>
                    <!-- card rounded-0 mb-3 ends -->

                <?php } else { ?>

                    <?php

                    while ($row_offers = mysqli_fetch_array($run_offers)) {

                        $offer_id = $row_offers['offer_id'];

                        $proposal_id = $row_offers['proposal_id'];

                        $description = $row_offers['description'];

                        $delivery_time = $row_offers['delivery_time'];

                        $amount = $row_offers['amount'];

                        $sender_id = $row_offers['sender_id'];


                        $select_sender = "select * from sellers where seller_id='$sender_id'";

                        $run_sender = mysqli_query($con, $select_sender);

                        $row_sender = mysqli_fetch_array($run_sender);

                        $sender_user_name = $row_sender['seller_user_name'];

                        $sender_level = $row_sender['seller_level'];

                        $sender_image = $row_sender['seller_image'];

                        $sender_status = $row_sender['seller_status'];


                        $select_proposals = "select * from proposals where proposal_id='$proposal_id'";

                        $run_proposals = mysqli_query($con, $select_proposals);

                        $row_proposals = mysqli_fetch_array($run_proposals);

                        $proposal_title = $row_proposals['proposal_title'];

                        $proposal_url = $row_proposals['proposal_url'];

                        $proposal_img1 = $row_proposals['proposal_img1'];

                        ?>

                        <!-- card rounded-0 mb-3 starts -->
                        <div class="card rounded-0 mb-3">

                            <!-- card-body starts -->
                            <div class="card-body">

                                <!-- row starts -->
                                <div class="row">

                                    <!-- col-md-2 starts -->
                                    <div class="col-md-2">

                                        <img src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">

                                    </div>
                                    <!-- col-md-2 ends -->

                                    <!-- col-md-7 starts -->
                                    <div class="col-md-7">

                                        <!-- mt-md-0 mt-2 starts -->
                                        <h5 class="mt-md-0 mt-2">

                                            <a href="../proposals/<?php echo $proposal_url; ?>">
                                                <?php echo $proposal_title; ?>
                                            </a>

                                        </h5>
                                        <!-- mt-md-0 mt-2 ends -->

                                        <p class="mb-1">

                                            <?php echo $description; ?>

                                        </p>

                                        <p class="offer-p text-muted">

                                            <i class="fa fa-usd"></i> Offer Budget:
                                            <span class="font-weight-normal mr-2">
                                                ₹<?php echo $amount; ?>
                                            </span>

                                            <i class="fa fa-clock-o"></i> Offer Duration:
                                            <span class="font-weight-normal">
                                                <?php echo $delivery_time; ?>
                                            </span>

                                        </p>

                                    </div>
                                    <!-- col-md-7 ends -->


                                    <!-- col-md-3 responsive-border pt-md-0 pt-3 starts -->
                                    <div class="col-md-3 responsive-border pt-md-0 pt-3">

                                        <!-- offer-seller-picture starts -->
                                        <div class="offer-seller-picture">


                                            <?php if (!empty($sender_image)) { ?>

                                                <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle">

                                            <?php } else { ?>

                                                <img src="../user_images/empty-image.png" class="rounded-circle">

                                            <?php } ?>

                                            <?php if ($sender_level == 2) { ?>

                                                <img src="../images/level_badge_1.png" class="level-badge">

                                            <?php } elseif ($sender_level == 3) { ?>

                                                <img src="../images/level_badge_2.png" class="level-badge">

                                            <?php } elseif ($sender_level == 4) { ?>

                                                <img src="../images/level_badge_3.png" class="level-badge">

                                            <?php } ?>

                                        </div>
                                        <!-- offer-seller-picture ends -->

                                        <!-- offer-seller mb-4 starts -->
                                        <div class="offer-seller mb-4">

                                            <!-- font-weight-bold mb-1 starts -->
                                            <p class="font-weight-bold mb-1">

                                                <?php echo $sender_user_name; ?>
                                                <small class="text-success">
                                                    <?php echo $sender_status; ?>
                                                </small>

                                            </p>
                                            <!-- font-weight-bold mb-1 ends -->

                                            <p class="user-link">

                                                <a href="<?php echo $sender_user_name; ?>" target="blank">
                                                    User Profile
                                                </a>

                                            </p>

                                        </div>
                                        <!-- offer-seller mb-4 ends -->

                                        <a href="../conversations/message.php?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="btn btn-sm btn-success rounded-0">

                                            Contact Now

                                        </a>

                                        <button id="order-button-<?php echo $offer_id; ?>" class="btn btn-sm btn-success rounded-0">

                                            Order Now

                                        </button>

                                    </div>
                                    <!-- col-md-3 responsive-border pt-md-0 pt-3 ends -->

                                </div>
                                <!-- row ends -->


                                <script>
                                    $("#order-button-<?php echo $offer_id; ?>").click(function() {

                                        request_id = "<?php echo $request_id; ?>";

                                        offer_id = "<?php echo $offer_id; ?>";

                                        $.ajax({
                                            method: "POST",
                                            url: "offer_submit_order.php",
                                            data: {
                                                request_id: request_id,
                                                offer_id: offer_id
                                            }
                                        }).done(function(data) {

                                            $("#append-modal").html(data);

                                        });


                                    });
                                </script>

                            </div>
                            <!-- card-body ends -->

                        </div>
                        <!-- card rounded-0 mb-3 ends -->

                    <?php } ?>


                <?php } ?>

            </div>
            <!-- col-md-12 ends -->

        </div>
        <!-- row view-offers ends -->

    </div>
    <!-- container mt-4 mb-4 ends -->

    <div id="append-modal"></div>

    <?php include("../includes/footer.php"); ?>


</body>

</html>