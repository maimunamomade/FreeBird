<?php

session_start();

include("../includes/db.php");

$proposal_url = $_GET['proposal_url'];

$get_proposal = "select * from proposals where proposal_url='$proposal_url'";

$run_proposal = mysqli_query($con, $get_proposal);

$count_proposal = mysqli_num_rows($run_proposal);

if ($count_proposal == 0) {

    echo "<script> window.open('../index.php?not_available','_self') </script>";
}

$row_proposal = mysqli_fetch_array($run_proposal);

$proposal_id = $row_proposal['proposal_id'];

// Select Proposal Details From Proposal Id

$get_proposal = "select * from proposals where proposal_id='$proposal_id'";

$run_proposal = mysqli_query($con, $get_proposal);

$row_proposal = mysqli_fetch_array($run_proposal);

$proposal_title = $row_proposal['proposal_title'];

$proposal_cat_id = $row_proposal['proposal_cat_id'];

$proposal_child_id = $row_proposal['proposal_child_id'];

$proposal_price = $row_proposal['proposal_price'];

$proposal_img1 = $row_proposal['proposal_img1'];

$proposal_img2 = $row_proposal['proposal_img2'];

$proposal_img3 = $row_proposal['proposal_img3'];

$proposal_img4 = $row_proposal['proposal_img4'];

$proposal_video = $row_proposal['proposal_video'];

$proposal_desc = $row_proposal['proposal_desc'];

$proposal_short_desc = substr($row_proposal['proposal_desc'], 0, 160);

$proposal_tags = $row_proposal['proposal_tags'];

$proposal_seller_id = $row_proposal['proposal_seller_id'];

$delivery_id = $row_proposal['delivery_id'];

$proposal_rating = $row_proposal['proposal_rating'];

// Select Proposal Category

$get_cat = "select * from categories where cat_id='$proposal_cat_id'";

$run_cat = mysqli_query($con, $get_cat);

$row_cat = mysqli_fetch_array($run_cat);

$proposal_cat_title = $row_cat['cat_title'];

// Select Proposal Child Category

$get_child_cat = "select * from categories_childs where child_id='$proposal_child_id'";

$run_child_cat = mysqli_query($con, $get_child_cat);

$row_child_cat = mysqli_fetch_array($run_child_cat);

$proposal_child_title = $row_child_cat['child_title'];

// Select Proposal Delivery Time

$get_delivery_time = "select * from delivery_times where delivery_id='$delivery_id'";

$run_delivery_time = mysqli_query($con, $get_delivery_time);

$row_delivery_time = mysqli_fetch_array($run_delivery_time);

$delivery_proposal_title = $row_delivery_time['delivery_proposal_title'];

// Select Proposal Active Orders

$select_orders = "select * from orders where proposal_id='$proposal_id' AND order_active='yes'";

$run_orders = mysqli_query($con, $select_orders);

$proposal_order_queue = mysqli_num_rows($run_orders);

// Select Proposal Reviews Then Count Them

$proposal_reviews = array();

$select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

$run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

$count_reviews = mysqli_num_rows($run_buyer_reviews);

while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

    $proposal_buyer_rating = $row_buyer_reviews['buyer_rating'];

    array_push($proposal_reviews, $proposal_buyer_rating);
}

$total = array_sum($proposal_reviews);

@$average_rating = $total / count($proposal_reviews);

// Select Proposal Seller Details

$select_proposal_seller = "select * from sellers where seller_id='$proposal_seller_id'";

$run_proposal_seller = mysqli_query($con, $select_proposal_seller);

$row_proposal_seller = mysqli_fetch_array($run_proposal_seller);

$proposal_seller_user_name = $row_proposal_seller['seller_user_name'];

$proposal_seller_image = $row_proposal_seller['seller_image'];

$proposal_seller_country = $row_proposal_seller['seller_country'];

$proposal_seller_about = $row_proposal_seller['seller_about'];

$proposal_seller_level = $row_proposal_seller['seller_level'];

$proposal_seller_recent_delivery = $row_proposal_seller['seller_recent_delivery'];

$proposal_seller_rating = $row_proposal_seller['seller_rating'];

$proposal_seller_vacation = $row_proposal_seller['seller_vacation'];

$proposal_seller_status = $row_proposal_seller['seller_status'];


// Select Proposal Seller Level


$select_seller_level = "select * from seller_levels where level_id='$proposal_seller_level'";

$run_seller_level = mysqli_query($con, $select_seller_level);

$row_seller_level = mysqli_fetch_array($run_seller_level);

$level_title = $row_seller_level['level_title'];

// Update Proposal Views


if (!isset($_SESSION['seller_user_name'])) {

    $update_proposal_views = "update proposals set proposal_views=proposal_views+1 where proposal_id='$proposal_id'";

    $run_update_views = mysqli_query($con, $update_proposal_views);
}


if (isset($_SESSION['seller_user_name'])) {


    $login_seller_user_name = $_SESSION['seller_user_name'];

    $select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

    $run_login_seller = mysqli_query($con, $select_login_seller);

    $row_login_seller = mysqli_fetch_array($run_login_seller);

    $login_seller_id = $row_login_seller['seller_id'];


    if ($proposal_seller_id != $login_seller_id) {

        $update_proposal_views = "update proposals set proposal_views=proposal_views+1 where proposal_id='$proposal_id'";

        $run_update_views = mysqli_query($con, $update_proposal_views);
    }

    $select_recent_proposal = "select * from recent_proposals where seller_id='$login_seller_id' AND proposal_id='$proposal_id'";

    $run_recent_proposal = mysqli_query($con, $select_recent_proposal);

    $count_recent_proposal = mysqli_num_rows($run_recent_proposal);

    if ($count_recent_proposal == 1) {

        if ($proposal_seller_id != $login_seller_id) {

            $delete_recent_proposal = "delete from recent_proposals where seller_id='$login_seller_id' AND proposal_id='$proposal_id'";

            $run_delete = mysqli_query($con, $delete_recent_proposal);

            $insert_recent_proposal = "insert into recent_proposals (seller_id,proposal_id) values ('$login_seller_id','$proposal_id')";

            $run_recent_proposal = mysqli_query($con, $insert_recent_proposal);
        }
    } else {

        if ($proposal_seller_id != $login_seller_id) {

            $insert_recent_proposal = "insert into recent_proposals (seller_id,proposal_id) values ('$login_seller_id','$proposal_id')";

            $run_recent_proposal = mysqli_query($con, $insert_recent_proposal);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title> <?php echo $proposal_title; ?> </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="<?php echo $proposal_short_desc; ?>">

    <meta name="keywords" content="<?php echo $proposal_tags; ?>">
    <meta name="Author" content="<?php echo $proposal_seller_user_name; ?>">

    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleips.com/css?family=Roboto:400,500,700,300.100">
    <link href="../styles/owl.carousel.css" rel="stylesheet">
    <link href="../styles/owl.theme.default.css" rel="stylesheet">

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c4be8cc90b9456a"></script>

    <script src="../js/jquery.min.js"> </script>
</head>

<body>

    <?php include("../includes/header.php"); ?>

    <!-- container mt-5 starts -->
    <div class="container mt-5">

        <!-- row starts -->
        <div class="row">

            <!-- col-lg-8 col-md-7 mb-3 starts -->
            <div class="col-lg-8 col-md-7 mb-3">

                <!-- card rounded-0 mb-3 starts -->
                <div class="card rounded-0 mb-3">

                    <!-- card-body details starts -->
                    <div class="card-body details">

                        <!-- proposal-info starts -->
                        <div class="proposal-info">

                            <h3>
                                <?php echo $proposal_title; ?>
                            </h3>

                            <?php

                            for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                echo " <img class='rating' src='../images/user_rate_full.png' > ";
                            }

                            for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                            }


                            ?>

                            <span class="text-muted span"> (<?php echo $count_reviews; ?>) Reviews &nbsp;&nbsp; (<?php echo $proposal_order_queue; ?>) Orders In Queue </span>

                            <hr>

                            <a href="../category.php?cat_id=<?php echo $proposal_cat_id; ?>"> <?php echo $proposal_cat_title; ?> </a>

                            /

                            <a href="../category.php?cat_child_id=<?php echo $proposal_child_id; ?>">
                                <?php echo $proposal_child_title; ?>
                            </a>

                        </div>
                        <!-- proposal-info ends -->


                        <!-- carousel slide starts -->
                        <div id="myCarousel" class="carousel slide">

                            <!-- carousel-indicators starts -->
                            <ol class="carousel-indicators">

                                <?php if (!empty($proposal_video)) { ?>

                                    <li data-target="myCarousel" data-slide-to="0" class="active"> </li>

                                <?php
                            } ?>
                                <li data-target="myCarousel" data-slide-to="1" <?php
                                                                                if (empty($proposal_video)) {
                                                                                    echo "class='active'";
                                                                                }

                                                                                ?>> </li>


                                <?php if (!empty($proposal_img2)) { ?>

                                    <li data-target="myCarousel" data-slide-to="2"> </li>

                                <?php
                            } ?>

                                <?php if (!empty($proposal_img3)) { ?>

                                    <li data-target="myCarousel" data-slide-to="3"> </li>

                                <?php
                            } ?>

                                <?php if (!empty($proposal_img4)) { ?>

                                    <li data-target="myCarousel" data-slide-to="4"> </li>

                                <?php
                            } ?>

                            </ol>
                            <!-- carousel-indicators ends -->

                            <!-- carousel-inner starts -->
                            <div class="carousel-inner">

                                <?php if (!empty($proposal_video)) { ?>

                                    <!-- carousel-item active starts -->
                                    <div class="carousel-item active">

                                        <script src="https://content.jwplatform.com/libraries/IKBOrtS2.js">

                                        </script>

                                        <div class="d-block w-100" id="player"></div>

                                        <script>
                                            var player = jwplayer('player');

                                            player.setup({
                                                file: "proposal_files/<?php echo $proposal_video; ?>",

                                                image: "proposal_files/<?php echo $proposal_img1; ?>"
                                            });
                                        </script>

                                    </div>
                                    <!-- carousel-item active ends -->

                                <?php
                            } ?>

                                <!-- carousel-item starts -->
                                <div class="carousel-item

<?php

if (empty($proposal_video)) {
    echo "active";
}

?>

">

                                    <img class="d-block w-100" src="proposal_files/<?php echo $proposal_img1; ?>">

                                </div>
                                <!-- carousel-item ends -->

                                <?php if (!empty($proposal_img2)) { ?>

                                    <!-- carousel-item starts -->
                                    <div class="carousel-item">

                                        <img class="d-block w-100" src="proposal_files/<?php echo $proposal_img2; ?>">

                                    </div>
                                    <!-- carousel-item ends -->

                                <?php
                            } ?>

                                <?php if (!empty($proposal_img3)) { ?>

                                    <!-- carousel-item starts -->
                                    <div class="carousel-item">

                                        <img class="d-block w-100" src="proposal_files/<?php echo $proposal_img3; ?>">

                                    </div>
                                    <!-- carousel-item ends -->

                                <?php
                            } ?>

                                <?php if (!empty($proposal_img4)) { ?>

                                    <!-- carousel-item starts -->
                                    <div class="carousel-item">

                                        <img class="d-block w-100" src="proposal_files/<?php echo $proposal_img4; ?>">

                                    </div>
                                    <!-- carousel-item ends -->

                                <?php
                            } ?>

                            </div>
                            <!-- carousel-inner ends -->


                            <a class="carousel-control-prev slide-nav slide-right" href="#myCarousel" data-slide="prev">

                                <span class="carousel-control-prev-icon carousel-icon"></span>

                            </a>

                            <a class="carousel-control-next slide-nav slide-left" href="#myCarousel" data-slide="next">

                                <span class="carousel-control-next-icon carousel-icon"></span>

                            </a>

                        </div>
                        <!-- carousel slide ends -->

                    </div>
                    <!-- card-body details ends -->

                </div>
                <!-- card rounded-0 mb-3 ends -->


                <!-- card rounded-0 mb-3 starts -->
                <div class="card rounded-0 mb-3">

                    <!-- card-header starts -->
                    <div class="card-header">
                        <h4>About This Proposal</h4>
                    </div>
                    <!-- card-header ends -->

                    <!-- card-body starts -->
                    <div class="card-body">

                        <p>
                            <?php echo $proposal_desc; ?>
                        </p>

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card rounded-0 mb-3 ends -->


                <!-- card proposal-reviews rounded-0 mb-3 starts -->
                <div class="card proposal-reviews rounded-0 mb-3">

                    <!-- card-header starts -->
                    <div class="card-header">
                        <h4>
                            <span class="ml-2"> <?php echo $count_reviews; ?> Reviews </span>

                            <?php

                            for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                echo " <img class='rating' src='../images/user_rate_full_big.png' > ";
                            }

                            for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                echo " <img class='rating' src='../images/user_rate_blank_big.png' > ";
                            }


                            ?>

                            <span class="text-muted">
                                <?php

                                if ($proposal_rating == "0") {

                                    echo "0.0";
                                } else {

                                    printf("%.1f", $average_rating);
                                }


                                ?>
                            </span>

                            <!--- dropdown float-right starts -->
                            <div class="dropdown float-right">

                                <button id="dropdown-button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">

                                    All Reviews
                                </button>

                                <!-- dropdown-menu starts -->
                                <ul class="dropdown-menu">

                                    <li class="dropdown-item active all"> All Reviews </li>

                                    <li class="dropdown-item good"> Positive Reviews </li>

                                    <li class="dropdown-item bad"> Negative Reviews </li>

                                </ul>
                                <!-- dropdown-menu ends -->

                            </div>
                            <!-- dropdown float-right ends -->

                        </h4>

                    </div>
                    <!-- card-header ends -->

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- proposal-reviews starts -->
                        <article id="all" class="proposal-reviews">

                            <!-- reviews-list Starts -->
                            <ul class="reviews-list">

                                <?php

                                $select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

                                $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                $count_reviews = mysqli_num_rows($run_buyer_reviews);

                                if ($count_reviews == 0) {

                                    echo "
	
	<li>
	
	<h3 align='center'> 
This Proposal Has No Reivews, Become First To Write a Reivew. 
</h3>
	
	</li>
	
	";
                                }

                                while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                    $order_id = $row_buyer_reviews['order_id'];

                                    $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                    $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                    $buyer_review = $row_buyer_reviews['buyer_review'];

                                    $review_date = $row_buyer_reviews['review_date'];

                                    $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                    $run_seller = mysqli_query($con, $select_seller);

                                    $row_seller = mysqli_fetch_array($run_seller);

                                    $buyer_user_name = $row_seller['seller_user_name'];

                                    $buyer_image = $row_seller['seller_image'];

                                    $select_seller_review = "select * from seller_reviews where order_id='$order_id'";

                                    $run_seller_review = mysqli_query($con, $select_seller_review);

                                    $count_seller_review = mysqli_num_rows($run_seller_review);

                                    $row_seller_review = mysqli_fetch_array($run_seller_review);

                                    $seller_rating = $row_seller_review['seller_rating'];

                                    $seller_review = $row_seller_review['seller_review'];


                                    ?>

                                    <!-- star-rating-row starts -->
                                    <li class="star-rating-row">

                                        <!-- user-picture starts -->
                                        <span class="user-picture">

                                            <?php if (!empty($buyer_image)) { ?>

                                                <img src="../user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                            <?php
                                        } else { ?>

                                                <img src="../user_images/empty-image.png" width="60" height="60">

                                            <?php
                                        } ?>

                                        </span>
                                        <!-- user-picture ends -->

                                        <!-- h4 starts -->
                                        <h4>
                                            <a href="#" class="mr-1">
                                                <?php echo $buyer_user_name; ?>
                                            </a>

                                            <?php

                                            for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                            }

                                            for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                            }
                                            ?>

                                        </h4>
                                        <!-- h4 ends -->

                                        <!-- msg-body starts -->
                                        <div class="msg-body">

                                            <?php echo $buyer_review; ?>

                                        </div>
                                        <!-- msg-body ends -->

                                        <span class="rating-date"> <?php echo $review_date; ?> </span>

                                    </li>
                                    <!-- star-rating-row ends -->


                                    <?php if (!$count_seller_review == 0) { ?>

                                        <!-- rating-seller starts -->
                                        <li class="rating-seller">

                                            <!-- h4 starts -->
                                            <h4>
                                                <span class="mr-1"> Seller's feedback </span>

                                                <?php

                                                for ($seller_i = 0; $seller_i < $seller_rating; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                                }

                                                for ($seller_i = $seller_rating; $seller_i < 5; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                                }


                                                ?>

                                            </h4>
                                            <!-- h4 ends -->

                                            <!-- user-picture starts -->
                                            <span class="user-picture">

                                                <?php if (!empty($proposal_seller_image)) { ?>

                                                    <img src="../user_images/<?php echo $proposal_seller_image; ?>" width="40" height="40">

                                                <?php
                                            } else { ?>

                                                    <img src="../user_images/empty-image.png" width="40" height="40">

                                                <?php
                                            } ?>

                                            </span>
                                            <!-- user-picture ends -->

                                            <!-- msg-body starts -->
                                            <div class="msg-body">

                                                <?php echo $seller_review; ?>

                                            </div>
                                            <!-- msg-body ends -->

                                        </li>
                                        <!-- rating-seller ends -->

                                    <?php
                                } ?>

                                    <hr>

                                <?php
                            } ?>

                            </ul>
                            <!-- reviews-list Ends -->

                        </article>
                        <!-- proposal-reviews Ends -->


                        <!-- proposal-reviews starts -->
                        <article id="good" class="proposal-reviews">

                            <!-- reviews-list starts -->
                            <ul class="reviews-list">

                                <?php

                                $select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id' AND (buyer_rating='5' or buyer_rating='4')";

                                $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                $count_reviews = mysqli_num_rows($run_buyer_reviews);

                                if ($count_reviews == 0) {

                                    echo "
	
	<li>
	
	<h3 align='center'> 
    Currently There Are No Positive Reviews For This Proposal.
</h3>
	
	</li>
	
	";
                                }

                                while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                    $order_id = $row_buyer_reviews['order_id'];

                                    $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                    $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                    $buyer_review = $row_buyer_reviews['buyer_review'];

                                    $review_date = $row_buyer_reviews['review_date'];

                                    $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                    $run_seller = mysqli_query($con, $select_seller);

                                    $row_seller = mysqli_fetch_array($run_seller);

                                    $buyer_user_name = $row_seller['seller_user_name'];

                                    $buyer_image = $row_seller['seller_image'];

                                    $select_seller_review = "select * from seller_reviews where order_id='$order_id'";

                                    $run_seller_review = mysqli_query($con, $select_seller_review);

                                    $count_seller_review = mysqli_num_rows($run_seller_review);

                                    $row_seller_review = mysqli_fetch_array($run_seller_review);

                                    $seller_rating = $row_seller_review['seller_rating'];

                                    $seller_review = $row_seller_review['seller_review'];


                                    ?>

                                    <!-- star-rating-row starts -->
                                    <li class="star-rating-row">

                                        <!-- user-picture starts -->
                                        <span class="user-picture">

                                            <?php if (!empty($buyer_image)) { ?>

                                                <img src="../user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                            <?php
                                        } else { ?>

                                                <img src="../user_images/empty-image.png" width="60" height="60">

                                            <?php
                                        } ?>

                                        </span>
                                        <!-- user-picture ends -->

                                        <!-- h4 starts -->
                                        <h4>

                                            <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>

                                            <?php

                                            for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                            }

                                            for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                            }


                                            ?>

                                        </h4>
                                        <!-- h4 ends -->

                                        <!-- msg-body starts -->
                                        <div class="msg-body">

                                            <?php echo $buyer_review; ?>

                                        </div>
                                        <!-- msg-body ends -->

                                        <span class="rating-date"> <?php echo $review_date; ?> </span>

                                    </li>
                                    <!-- star-rating-row ends -->

                                    <?php if (!$count_seller_review == 0) { ?>

                                        <!-- rating-seller starts -->
                                        <li class="rating-seller">

                                            <!-- h4 starts -->
                                            <h4>

                                                <span class="mr-1"> Seller's Feedback </span>

                                                <?php

                                                for ($seller_i = 0; $seller_i < $seller_rating; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                                }

                                                for ($seller_i = $seller_rating; $seller_i < 5; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                                }


                                                ?>

                                            </h4>
                                            <!-- h4 ends -->

                                            <!-- user-picture starts -->
                                            <span class="user-picture">

                                                <?php if (!empty($proposal_seller_image)) { ?>

                                                    <img src="../user_images/<?php echo $proposal_seller_image; ?>" width="40" height="40">

                                                <?php
                                            } else { ?>

                                                    <img src="../user_images/empty-image.png" width="40" height="40">

                                                <?php
                                            } ?>

                                            </span>
                                            <!-- user-picture ends -->

                                            <!-- msg-body starts -->
                                            <div class="msg-body">

                                                <?php echo $seller_review; ?>

                                            </div>
                                            <!-- msg-body ends -->

                                        </li>
                                        <!-- rating-seller ends -->

                                    <?php
                                } ?>

                                    <hr>

                                <?php
                            } ?>


                            </ul>
                            <!-- reviews-list ends -->

                        </article>
                        <!-- proposal-reviews ends -->



                        <!-- proposal-reviews starts -->
                        <article id="bad" class="proposal-reviews">

                            <!-- reviews-list starts -->
                            <ul class="reviews-list">

                                <?php

                                $select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id' AND (buyer_rating='1' or buyer_rating='2' or buyer_rating='3')";

                                $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                $count_reviews = mysqli_num_rows($run_buyer_reviews);

                                if ($count_reviews == 0) {

                                    echo "
	
	<li>
	
	<h3 align='center'> 
    Currently There Are No Negative Reviews For This Proposal.
</h3>
	
	</li>
	
	";
                                }

                                while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                    $order_id = $row_buyer_reviews['order_id'];

                                    $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                    $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                    $buyer_review = $row_buyer_reviews['buyer_review'];

                                    $review_date = $row_buyer_reviews['review_date'];

                                    $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                    $run_seller = mysqli_query($con, $select_seller);

                                    $row_seller = mysqli_fetch_array($run_seller);

                                    $buyer_user_name = $row_seller['seller_user_name'];

                                    $buyer_image = $row_seller['seller_image'];

                                    $select_seller_review = "select * from seller_reviews where order_id='$order_id'";

                                    $run_seller_review = mysqli_query($con, $select_seller_review);

                                    $count_seller_review = mysqli_num_rows($run_seller_review);

                                    $row_seller_review = mysqli_fetch_array($run_seller_review);

                                    $seller_rating = $row_seller_review['seller_rating'];

                                    $seller_review = $row_seller_review['seller_review'];


                                    ?>

                                    <!-- star-rating-row Starts -->
                                    <li class="star-rating-row">

                                        <!-- user-picture Starts -->
                                        <span class="user-picture">


                                            <?php if (!empty($buyer_image)) { ?>

                                                <img src="../user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                            <?php
                                        } else { ?>

                                                <img src="../user_images/empty-image.png" width="60" height="60">

                                            <?php
                                        } ?>

                                        </span>
                                        <!-- user-picture ends -->

                                        <!-- h4 starts -->
                                        <h4>

                                            <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>

                                            <?php

                                            for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                            }

                                            for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                            }


                                            ?>

                                        </h4>
                                        <!-- h4 ends -->

                                        <!-- msg-body starts -->
                                        <div class="msg-body">

                                            <?php echo $buyer_review; ?>

                                        </div>
                                        <!-- msg-body ends -->

                                        <span class="rating-date"> <?php echo $review_date; ?> </span>

                                    </li>
                                    <!-- star-rating-row ends -->

                                    <?php if (!$count_seller_review == 0) { ?>

                                        <!-- rating-seller starts -->
                                        <li class="rating-seller">

                                            <!-- h4 Starts -->
                                            <h4>

                                                <span class="mr-1"> Seller's Feedback </span>

                                                <?php

                                                for ($seller_i = 0; $seller_i < $seller_rating; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                                }

                                                for ($seller_i = $seller_rating; $seller_i < 5; $seller_i++) {

                                                    echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                                }


                                                ?>

                                            </h4>
                                            <!-- h4 ends -->

                                            <!-- user-picture starts -->
                                            <span class="user-picture">

                                                <?php if (!empty($proposal_seller_image)) { ?>

                                                    <img src="../user_images/<?php echo $proposal_seller_image; ?>" width="40" height="40">

                                                <?php
                                            } else { ?>

                                                    <img src="../user_images/empty-image.png" width="40" height="40">

                                                <?php
                                            } ?>

                                            </span>
                                            <!-- user-picture ends -->

                                            <!-- msg-body starts -->
                                            <div class="msg-body">

                                                <?php echo $seller_review; ?>

                                            </div>
                                            <!-- msg-body ends -->

                                        </li>
                                        <!-- rating-seller ends -->

                                    <?php
                                } ?>

                                    <hr>

                                <?php
                            } ?>

                            </ul>
                            <!-- reviews-list ends -->

                        </article>
                        <!-- proposal-reviews ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card proposal-reviews rounded-0 mb-3 ends -->


                <!--- proposal-tags-container mt-2 Starts -->
                <div class="proposal-tags-container mt-2">

                    <?php

                    $tags = explode(",", $proposal_tags);

                    foreach ($tags as $tag) {

                        ?>

                        <div class="proposal-tag mb-3"> <span> <?php echo $tag; ?> </span> </div>

                    <?php
                } ?>

                </div>
                <!--- proposal-tags-container mt-2 ends -->

            </div>
            <!-- col-lg-8 col-md-7 mb-3 ends -->


            <!--- col-lg-4 col-md-5 proposal-sidebar starts -->
            <div class="col-lg-4 col-md-5 proposal-sidebar">

                <!-- card mb-3 rounded-0 starts -->
                <div class="card mb-3 rounded-0">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <?php if ($proposal_seller_vacation == "on") { ?>

                            <?php if ($proposal_seller_user_name == @$_SESSION['seller_user_name']) { ?>

                                <h4>

                                    Your Vacation Mode Has Been Turned On , <br>

                                    Now No One Is Able To Buy Your Proposals.

                                </h4>

                            <?php
                        } else { ?>

                                <h4>

                                    Seller Vacation Mode Has Been Turned On,<br>
                                    Sorry The Proposals of this Seller Are Unavilable Now.

                                </h4>

                            <?php
                        } ?>

                        <?php
                    } elseif ($proposal_seller_vacation == "off") { ?>

                            <h3>
                                <strong class="text-success"> ₹ <?php echo $proposal_price; ?> </strong> Order Details
                            </h3>

                            <h4>
                                <i class="fa fa-clock-o"></i> &nbsp; <?php echo $delivery_proposal_title; ?> Delivery
                            </h4>

                            <?php if (!isset($_SESSION['seller_user_name'])) { ?>

                                <button class="btn btn-lg button-lg1 btn-success" data-toggle="modal" data-target="#login-modal">

                                    Order Now (₹<?php echo $proposal_price; ?>)

                                </button>

                                <button class="btn btn-lg button-lg2 btn-success" data-toggle="modal" data-target="#login-modal">

                                    <i class="fa fa-lg fa-shopping-cart"></i>

                                </button>

                                <hr>

                                <!-- form-group row starts -->
                                <div class="form-group row">

                                    <label class="col-md-6 control-label"> Proposal Quantity </label>

                                    <div class="col-md-6">

                                        <select class="form-control" name="proposal_qty">

                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>

                                        </select>

                                    </div>

                                </div>
                                <!-- form-group row ends -->

                            <?php
                        } else { ?>

                                <?php if ($proposal_seller_user_name == @$_SESSION['seller_user_name']) { ?>

                                    <a class="btn btn-lg btn-block btn-success" href="edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>">

                                        Edit Proposal

                                    </a>

                                <?php
                            } else { ?>

                                    <!-- form starts -->
                                    <form method="post" action="../checkout.php">

                                        <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                                        <button class="btn btn-lg button-lg1 btn-success" type="submit" name="add_order">

                                            Order Now (₹ <?php echo $proposal_price; ?>)

                                        </button>

                                        <button class="btn btn-lg button-lg2 btn-success" type="submit" name="add_cart">

                                            <i class="fa fa-lg fa-shopping-cart"></i>

                                        </button>

                                        <hr>

                                        <!-- form-group row starts -->
                                        <div class="form-group row">

                                            <label class="col-md-6 control-label"> Proposal Quantity </label>

                                            <div class="col-md-6">

                                                <select class="form-control" name="proposal_qty">

                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>

                                                </select>

                                            </div>

                                        </div>
                                        <!-- form-group row ends -->

                                    </form>
                                    <!-- form ends -->

                                <?php
                            } ?>


                            <?php
                        } ?>

                        <?php
                    } ?>

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card mb-3 rounded-0 ends -->

                <!-- mb-3 starts -->
                <center class="mb-3">

                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <div class="addthis_inline_share_toolbox_etca"></div>

                </center>
                <!-- mb-3 ends -->

                <!--- card seller-bio mb-3 rounded-0 starts -->
                <div class="card seller-bio mb-3 rounded-0">

                    <!--- card-body starts -->
                    <div class="card-body">

                        <center class="mb-4">

                            <?php if (!empty($proposal_seller_image)) { ?>

                                <img src="../user_images/<?php echo $proposal_seller_image; ?>" width="130" class="rounded-circle">

                            <?php
                        } else { ?>

                                <img src="../user_images/empty-image.png" width="130" class="rounded-circle">

                            <?php
                        } ?>

                            <?php if ($proposal_seller_level == 2) { ?>

                                <img src="../images/level_badge_1.png" width="55" class="seller_level_badge">

                            <?php
                        } ?>

                            <?php if ($proposal_seller_level == 3) { ?>

                                <img src="../images/level_badge_2.png" width="55" class="seller_level_badge">

                            <?php
                        } ?>

                            <?php if ($proposal_seller_level == 4) { ?>

                                <img src="../images/level_badge_3.png" width="55" class="seller_level_badge">

                            <?php
                        } ?>

                        </center>

                        <a class="text-center" href="../<?php echo $proposal_seller_user_name; ?>">

                            <h3> <?php echo $proposal_seller_user_name; ?> </h3>

                        </a>

                        <h4 class="text-muted text-center"> <?php echo $level_title; ?> </h4>

                        <hr>

                        <!--  row starts -->
                        <div class="row">

                            <!-- col-md-6 starts -->
                            <div class="col-md-6">

                                <p class="text-muted"> From </p>

                                <p> <?php echo $proposal_seller_country; ?> </p>

                            </div>
                            <!-- col-md-6 ends -->


                            <!-- col-md-6 starts -->
                            <div class="col-md-6">

                                <p class="text-muted"> Positive Ratings </p>

                                <p> <?php echo $proposal_seller_rating; ?>% </p>

                            </div>
                            <!-- col-md-6 ends -->


                            <!-- col-md-6 starts -->
                            <div class="col-md-6">
                                <p class="text-muted"> Speaks </p>

                                <p>
                                    <?php

                                    $select_languages_relation = "select * from languages_relation where seller_id='$proposal_seller_id'";

                                    $run_languages_relation = mysqli_query($con, $select_languages_relation);

                                    while ($row_languages_relation = mysqli_fetch_array($run_languages_relation)) {

                                        $language_id = $row_languages_relation['language_id'];

                                        $get_language = "select * from seller_languages where language_id='$language_id'";

                                        $run_language = mysqli_query($con, $get_language);

                                        $row_language = mysqli_fetch_array($run_language);

                                        $language_title = $row_language['language_title'];

                                        ?>

                                        <?php echo $language_title; ?>,


                                    <?php
                                } ?>
                                </p>

                            </div>
                            <!-- col-md-6 ends -->


                            <!-- col-md-6 starts -->
                            <div class="col-md-6">

                                <p class="text-muted"> Recent Delivery </p>

                                <p> <?php echo $proposal_seller_recent_delivery; ?> </p>

                            </div>
                            <!-- col-md-6 ends -->

                        </div>
                        <!-- row ends -->

                        <hr>

                        <p>
                            <?php echo $proposal_seller_about; ?>
                        </p>

                        <a href="../<?php echo $proposal_seller_user_name; ?>"> Read More </a>

                    </div>
                    <!--- card-body ends -->


                    <!-- card-footer starts -->
                    <div class="card-footer">

                        <?php if ($proposal_seller_status == "online") { ?>

                            <p class="float-left online">
                                <i class="fa fa-check"> </i> Online
                            </p>

                        <?php
                    } ?>

                        <a class="float-right btn btn-primary" href="../conversations/message.php?seller_id=<?php echo $proposal_seller_id; ?>">

                            <i class="fa fa-comment-o"></i>
                            Contact Us

                        </a>

                    </div>
                    <!-- card-footer ends -->

                </div>
                <!--- card seller-bio mb-3 rounded-0 starts -->

            </div>
            <!--- col-lg-4 col-md-5 proposal-sidebar ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container mt-5 ends -->

    <!-- container-fluid bg-light starts -->
    <div class="container-fluid bg-light">

        <!-- row starts -->
        <div class="row">

            <!--- col-md-10 offset-md-1 starts -->
            <div class="col-md-10 offset-md-1">

                <h2 class="p-2 mt-3">
                    RECOMMENDED FOR YOU IN <a href="../<?php echo $proposal_seller_user_name; ?>"> <?php echo $proposal_seller_user_name; ?> </a>
                </h2>

                <!-- row flex-wrap mb-3 Starts -->
                <div class="row flex-wrap mb-3">

                    <?php

                    $get_proposals = "select * from proposals where proposal_seller_id='$proposal_seller_id' AND proposal_status='active'";

                    $run_proposals = mysqli_query($con, $get_proposals);

                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                        $proposal_id = $row_proposals['proposal_id'];

                        $proposal_title = $row_proposals['proposal_title'];

                        $proposal_price = $row_proposals['proposal_price'];

                        $proposal_img1 = $row_proposals['proposal_img1'];

                        $proposal_video = $row_proposals['proposal_video'];

                        $proposal_seller_id = $row_proposals['proposal_seller_id'];

                        $proposal_rating = $row_proposals['proposal_rating'];

                        $proposal_url = $row_proposals['proposal_url'];

                        $proposal_featured = $row_proposals['proposal_featured'];

                        if (empty($proposal_video)) {

                            $video_class = "";
                        } else {

                            $video_class = "video-img";
                        }

                        $select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

                        $run_seller = mysqli_query($con, $select_seller);

                        $row_seller = mysqli_fetch_array($run_seller);

                        $seller_user_name = $row_seller['seller_user_name'];

                        $select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

                        $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                        $count_reviews = mysqli_num_rows($run_buyer_reviews);


                        ?>

                        <!--- col-lg-3 col-md-6 col-sm-6 starts -->
                        <div class="col-lg-3 col-md-6 col-sm-6">

                            <!--- proposal-div starts -->
                            <div class="proposal-div">

                                <!--- proposal_nav starts -->
                                <div class="proposal_nav">

                                    <span class="float-left mt-2">

                                        <strong class="ml-2 mr-1"> By </strong> <?php echo $seller_user_name; ?>

                                    </span>

                                    <span class="float-right mt-2">
                                        <?php

                                        for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                            echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                        }

                                        for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                            echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                        }


                                        ?>

                                        <span class="ml-1 mr-2">
                                            (<?php echo $count_reviews; ?>) Reviews
                                        </span>

                                    </span>

                                    <div class="clearfix mb-2"> </div>

                                </div>
                                <!--- proposal_nav ends -->

                                <a href="<?php echo $proposal_url; ?>">

                                    <hr class="m-0 p-0">

                                    <img src="proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">

                                </a>

                                <!-- text starts -->
                                <div class="text">

                                    <h4>
                                        <a href="<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                            <?php echo $proposal_title; ?>

                                        </a>
                                    </h4>

                                    <hr>

                                    <p class="buttons clearfix">

                                        <span class="float-right">

                                            STARTING AT
                                            <strong class="price">
                                                ₹ <?php echo $proposal_price; ?>
                                            </strong>

                                        </span>

                                    </p>

                                </div>
                                <!-- text ends -->

                                <?php if ($proposal_featured == "yes") { ?>

                                    <!-- ribbon starts -->
                                    <div class="ribbon">

                                        <div class="theribbon"> Featured </div>

                                        <div class="ribbon-background"> </div>

                                    </div>
                                    <!-- ribbon ends -->

                                <?php
                            } ?>

                            </div>
                            <!--- proposal-div ends -->

                        </div>
                        <!--- col-lg-3 col-md-6 col-sm-6 ends -->

                    <?php
                } ?>

                </div>
                <!-- row flex-wrap mb-3 ends -->

            </div>
            <!--- col-md-10 offest-md-1 ends -->

        </div>
        <!-- row ends -->


        <?php if (isset($_SESSION['seller_user_name'])) { ?>

            <!-- row starts -->
            <div class="row">

                <!--- col-md-10 offset-md-1 starts -->
                <div class="col-md-10 offset-md-1">

                    <h2 class="p-2 mt-3">
                        Your Recentely viewed Proposals
                    </h2>

                    <!-- row flex-wrap mb-3 Starts -->
                    <div class="row flex-wrap mb-3">

                        <?php

                        $select_recent = "select * from recent_proposals where seller_id='$login_seller_id' order by 1 DESC LIMIT 0,4";

                        $run_recent = mysqli_query($con, $select_recent);

                        while ($row_recent = mysqli_fetch_array($run_recent)) {

                            $proposal_id = $row_recent['proposal_id'];

                            $get_proposals = "select * from proposals where proposal_id='$proposal_id' AND proposal_status='active'";

                            $run_proposals = mysqli_query($con, $get_proposals);

                            $row_proposals = mysqli_fetch_array($run_proposals);


                            $proposal_id = $row_proposals['proposal_id'];

                            $proposal_title = $row_proposals['proposal_title'];

                            $proposal_price = $row_proposals['proposal_price'];

                            $proposal_img1 = $row_proposals['proposal_img1'];

                            $proposal_video = $row_proposals['proposal_video'];

                            $proposal_seller_id = $row_proposals['proposal_seller_id'];

                            $proposal_rating = $row_proposals['proposal_rating'];

                            $proposal_url = $row_proposals['proposal_url'];

                            $proposal_featured = $row_proposals['proposal_featured'];

                            if (empty($proposal_video)) {

                                $video_class = "";
                            } else {

                                $video_class = "video-img";
                            }

                            $select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

                            $run_seller = mysqli_query($con, $select_seller);

                            $row_seller = mysqli_fetch_array($run_seller);

                            $seller_user_name = $row_seller['seller_user_name'];

                            $select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

                            $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                            $count_reviews = mysqli_num_rows($run_buyer_reviews);

                            ?>

                            <!--- col-lg-3 col-md-6 col-sm-6 starts -->
                            <div class="col-lg-3 col-md-6 col-sm-6">

                                <!--- proposal-div starts -->
                                <div class="proposal-div">

                                    <!--- proposal_nav starts -->
                                    <div class="proposal_nav">

                                        <span class="float-left mt-2">

                                            <strong class="ml-2 mr-1"> By </strong> <?php echo $seller_user_name; ?>

                                        </span>

                                        <span class="float-right mt-2">

                                            <?php

                                            for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                                echo " <img class='rating' src='../images/user_rate_full.png' > ";
                                            }

                                            for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                                echo " <img class='rating' src='../images/user_rate_blank.png' > ";
                                            }


                                            ?>

                                            <span class="ml-1 mr-2">
                                                (<?php echo $count_reviews; ?>) Reviews
                                            </span>

                                        </span>

                                        <div class="clearfix mb-2"> </div>

                                    </div>
                                    <!--- proposal_nav ends -->

                                    <a href="proposal.php">

                                        <hr class="m-0 p-0">

                                        <img src="proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">

                                    </a>

                                    <!-- text starts -->
                                    <div class="text">
                                        <h4>
                                            <a href="<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                                <?php echo $proposal_title; ?>

                                            </a>
                                        </h4>

                                        <hr>

                                        <p class="buttons clearfix">
                                            <span class="float-right">

                                                STARTING AT
                                                <strong class="price">
                                                    ₹ <?php echo $proposal_price; ?>
                                                </strong>

                                            </span>
                                        </p>

                                    </div>
                                    <!-- text ends -->

                                    <?php if ($proposal_featured == "yes") { ?>

                                        <!-- ribbon starts -->
                                        <div class="ribbon">

                                            <div class="theribbon"> Featured </div>

                                            <div class="ribbon-background"> </div>

                                        </div>
                                        <!-- ribbon ends -->

                                    <?php
                                } ?>

                                </div>
                                <!--- proposal-div ends -->

                            </div>
                            <!--- col-lg-3 col-md-6 col-sm-6 ends -->

                        <?php
                    } ?>

                    </div>
                    <!-- row flex-wrap mb-3 ends -->

                </div>
                <!--- col-md-10 offest-md-1 ends -->

            </div>
            <!-- row ends -->

        <?php
    } ?>

    </div>
    <!-- container-fluid bg-light ends -->



    <?php include("../includes/footer.php"); ?>


    <script>
        $(document).ready(function() {

            $('#good').hide();

            $('#bad').hide();

            $('.all').click(function() {

                $("#dropdown-button").html("All Reviews");

                $(".all").attr('class', 'dropdown-item all active');

                $(".bad").attr('class', 'dropdown-item bad');

                $(".good").attr('class', 'dropdown-item good');

                $("#all").show();

                $("#good").hide();

                $("#bad").hide();

            });


            $('.good').click(function() {

                $("#dropdown-button").html("Positive Reviews");

                $(".all").attr('class', 'dropdown-item all');

                $(".bad").attr('class', 'dropdown-item bad');

                $(".good").attr('class', 'dropdown-item good active');

                $("#all").hide();

                $("#good").show();

                $("#bad").hide();

            });


            $('.bad').click(function() {

                $("#dropdown-button").html("Negative Reviews");

                $(".all").attr('class', 'dropdown-item all');

                $(".bad").attr('class', 'dropdown-item bad active');

                $(".good").attr('class', 'dropdown-item good');

                $("#all").hide();

                $("#good").hide();

                $("#bad").show();

            });

        });
    </script>

</body>

</html>