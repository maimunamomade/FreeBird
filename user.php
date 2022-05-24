<?php

session_start();

include("includes/db.php");

if (isset($_SESSION['seller_user_name'])) {

    $login_seller_user_name = $_SESSION['seller_user_name'];


    if (isset($_GET['delete_language'])) {

        $delete_language_id = $_GET['delete_language'];

        $delete_language = "delete from languages_relation where relation_id='$delete_language_id'";

        $run_delete_language = mysqli_query($con, $delete_language);

        if ($run_delete_language) {

            echo "<script>alert('One Language Has Been Deleted.')</script>";

            echo "
	
	<script> window.open('$login_seller_user_name','_self') </script>
	
	";
        }
    }


    if (isset($_GET['delete_skill'])) {

        $delete_skill_id = $_GET['delete_skill'];

        $delete_skill = "delete from skills_relation where relation_id='$delete_skill_id'";

        $run_delete_skill = mysqli_query($con, $delete_skill);

        if ($run_delete_skill) {

            echo "<script>alert('One Skill Has Been Deleted.')</script>";

            echo "
	
	<script> window.open('$login_seller_user_name','_self') </script>
	
	";
        }
    }
}


$get_seller_user_name = $_GET['seller_user_name'];

$select_seller = "select * from sellers where seller_user_name='$get_seller_user_name' AND NOT seller_status='deactivated' AND NOT seller_status='block-ban'";

$run_seller = mysqli_query($con, $select_seller);

$count_seller = mysqli_num_rows($run_seller);

if ($count_seller == 0) {

    echo "
	
	<script> window.open('index.php?not_available','_self') </script>
	
	";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / <?php echo $get_seller_user_name; ?> </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleips.com/css?family=Roboto:400,500,700,300.100">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/header.php"); ?>

    <?php include("includes/user_profile_header.php"); ?>


    <!-- container-fluid starts -->
    <div class="container-fluid">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-4 mt-4 starts -->
            <div class="col-md-4 mt-4">

                <?php include("includes/user_sidebar.php"); ?>

            </div>
            <!-- col-md-4 mt-4 ends -->


            <!-- col-md-8 Starts -->
            <div class="col-md-8">

                <!-- row starts -->
                <div class="row">

                    <!-- col-md-12 starts -->
                    <div class="col-md-12">

                        <!-- card mt-4 mb-4 rounded-0 starts -->
                        <div class="card mt-4 mb-4 rounded-0">

                            <!--- card-body starts -->
                            <div class="card-body">

                                <h2> <?php echo $get_seller_user_name; ?>'s Proposals </h2>

                            </div>
                            <!--- card-body ends -->

                        </div>
                        <!-- card mt-4 mb-4 rounded-0 ends -->

                    </div>
                    <!-- col-md-12 ends -->

                </div>
                <!-- row ends -->


                <!-- row starts -->
                <div class="row">

                    <?php

                    $get_proposals = "select * from proposals where proposal_seller_id='$seller_id' AND proposal_status='active'";

                    $run_proposals = mysqli_query($con, $get_proposals);

                    $count_proposals = mysqli_num_rows($run_proposals);

                    if ($count_proposals == 0) {

                        ?>

                        <div class="col-md-12">

                            <h3 class="bg-secondary text-white text-center mb-5 p-2">

                                <?php echo $get_seller_user_name; ?> There Are No proposals To Display.

                            </h3>

                        </div>

                    <?php
                }

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

                        <!--- col-lg-4 col-md-6 col-sm-6 starts -->
                        <div class="col-lg-4 col-md-6 col-sm-6">

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

                                            echo " <img class='rating' src='images/user_rate_full.png' > ";
                                        }

                                        for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                            echo " <img class='rating' src='images/user_rate_blank.png' > ";
                                        }


                                        ?>

                                        <span class="ml-1 mr-2">
                                            (<?php echo $count_reviews; ?>) Reviews
                                        </span>

                                    </span>

                                    <div class="clearfix mb-2"> </div>

                                </div>
                                <!--- proposal_nav ends -->

                                <a href="proposals/<?php echo $proposal_url; ?>">

                                    <hr class="m-0 p-0">

                                    <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">

                                </a>

                                <!-- text starts -->
                                <div class="text">

                                    <h4>
                                        <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                            <?php echo $proposal_title; ?>
                                        </a>
                                    </h4>

                                    <hr>

                                    <p class="buttons clearfix">

                                        <span class="float-right">
                                            STARTING AT <strong class="price"> ₹ <?php echo $proposal_price; ?> </strong>
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
                        <!--- col-lg-4 col-md-6 col-sm-6 ends -->

                    <?php
                } ?>

                </div>
                <!-- row ends -->

                <?php

                $select_buyer_reviews = "select * from buyer_reviews where review_seller_id='$seller_id'";

                $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                $count_reviews = mysqli_num_rows($run_buyer_reviews);

                if (!$count_reviews == 0) {

                    ?>

                    <!-- row starts -->
                    <div class="row">

                        <!-- col-md-12 Starts -->
                        <div class="col-md-12">

                            <!--- card user-reviews mt-4 mb-4 rounded-0 starts -->
                            <div class="card user-reviews mt-4 mb-4 rounded-0">

                                <!-- card-header starts -->
                                <div class="card-header">

                                    <!-- h4 starts -->
                                    <h4>

                                        <?php echo $get_seller_user_name; ?>'s Reviews

                                        <?php

                                        for ($seller_i = 0; $seller_i < $average_rating; $seller_i++) {

                                            echo " <img class='rating' src='images/user_rate_full_big.png' > ";
                                        }

                                        for ($seller_i = $average_rating; $seller_i < 5; $seller_i++) {

                                            echo " <img class='rating' src='images/user_rate_blank_big.png' > ";
                                        }


                                        ?>

                                        <span class="text-muted"> <?php printf("%.1f", $average); ?> (<?php echo $count_reviews; ?>) Reviews </span>

                                        <!-- dropdown float-right starts -->
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
                                    <!-- h4 Ends -->

                                </div>
                                <!-- card-header ends -->


                                <!-- card-body starts -->
                                <div class="card-body">

                                    <!-- proposal-reviews starts -->
                                    <article id="all" class="proposal-reviews">

                                        <!-- reviews-list starts -->
                                        <ul class="reviews-list">

                                            <?php

                                            $select_buyer_reviews = "select * from buyer_reviews where review_seller_id='$seller_id'";

                                            $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                            while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                                $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                                $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                                $buyer_review = $row_buyer_reviews['buyer_review'];

                                                $review_date = $row_buyer_reviews['review_date'];

                                                $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                                $run_seller = mysqli_query($con, $select_seller);

                                                $row_seller = mysqli_fetch_array($run_seller);

                                                $buyer_user_name = $row_seller['seller_user_name'];

                                                $buyer_image = $row_seller['seller_image'];

                                                ?>

                                                <!-- star-rating-row starts -->
                                                <li class="star-rating-row">

                                                    <!-- user-picture starts -->
                                                    <span class="user-picture">


                                                        <?php if (!empty($buyer_image)) { ?>

                                                            <img src="user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                                        <?php
                                                    } else { ?>

                                                            <img src="user_images/empty-picture.png" width="60" height="60">

                                                        <?php
                                                    } ?>

                                                    </span>
                                                    <!-- user-picture ends -->

                                                    <h4>
                                                        <!-- h4 Starts -->

                                                        <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>


                                                        <?php

                                                        for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_full.png' > ";
                                                        }

                                                        for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_blank.png' > ";
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

                                                <hr>

                                            <?php
                                        } ?>

                                        </ul>
                                        <!-- reviews-list ends -->

                                    </article>
                                    <!-- proposal-reviews ends -->


                                    <!-- proposal-reviews starts -->
                                    <article id="good" class="proposal-reviews">

                                        <!-- reviews-list starts -->
                                        <ul class="reviews-list">

                                            <?php

                                            $select_buyer_reviews = "select * from buyer_reviews where review_seller_id='$seller_id' AND (buyer_rating='5' or buyer_rating='4')";

                                            $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                            $count_reviews = mysqli_num_rows($run_buyer_reviews);

                                            if ($count_reviews == 0) {

                                                echo "
	
	<li>
	
	<h3 align='center'> Currently There Are No Positive Reviews For This Seller. </h3>
	
	</li>
	
	";
                                            }

                                            while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                                $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                                $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                                $buyer_review = $row_buyer_reviews['buyer_review'];

                                                $review_date = $row_buyer_reviews['review_date'];

                                                $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                                $run_seller = mysqli_query($con, $select_seller);

                                                $row_seller = mysqli_fetch_array($run_seller);

                                                $buyer_user_name = $row_seller['seller_user_name'];

                                                $buyer_image = $row_seller['seller_image'];

                                                ?>

                                                <!-- star-rating-row starts -->
                                                <li class="star-rating-row">

                                                    <!-- user-picture starts -->
                                                    <span class="user-picture">

                                                        <?php if (!empty($buyer_image)) { ?>

                                                            <img src="user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                                        <?php
                                                    } else { ?>

                                                            <img src="user_images/empty-picture.png" width="60" height="60">

                                                        <?php
                                                    } ?>

                                                    </span>
                                                    <!-- user-picture ends -->

                                                    <!-- h4 etarts -->
                                                    <h4>

                                                        <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>


                                                        <?php

                                                        for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_full.png' > ";
                                                        }

                                                        for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_blank.png' > ";
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

                                            $select_buyer_reviews = "select * from buyer_reviews where review_seller_id='$seller_id' AND (buyer_rating='3' or buyer_rating='2' or buyer_rating='1')";

                                            $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

                                            $count_reviews = mysqli_num_rows($run_buyer_reviews);

                                            if ($count_reviews == 0) {

                                                echo "
	
	<li>
	
	<h3 align='center'> Currently There Are No Negative Reviews For This Seller. </h3>
	
	</li>
	
	";
                                            }

                                            while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

                                                $review_buyer_id = $row_buyer_reviews['review_buyer_id'];

                                                $buyer_rating = $row_buyer_reviews['buyer_rating'];

                                                $buyer_review = $row_buyer_reviews['buyer_review'];

                                                $review_date = $row_buyer_reviews['review_date'];

                                                $select_seller = "select * from sellers where seller_id='$review_buyer_id'";

                                                $run_seller = mysqli_query($con, $select_seller);

                                                $row_seller = mysqli_fetch_array($run_seller);

                                                $buyer_user_name = $row_seller['seller_user_name'];

                                                $buyer_image = $row_seller['seller_image'];

                                                ?>

                                                <!-- star-rating-row starts -->
                                                <li class="star-rating-row">

                                                    <!-- user-picture starts -->
                                                    <span class="user-picture">

                                                        <?php if (!empty($buyer_image)) { ?>

                                                            <img src="user_images/<?php echo $buyer_image; ?>" width="60" height="60">

                                                        <?php
                                                    } else { ?>

                                                            <img src="user_images/empty-picture.png" width="60" height="60">

                                                        <?php
                                                    } ?>

                                                    </span>
                                                    <!-- user-picture ends -->

                                                    <!-- h4 starts -->
                                                    <h4>

                                                        <a href="#" class="mr-1"> <?php echo $buyer_user_name; ?> </a>


                                                        <?php

                                                        for ($buyer_i = 0; $buyer_i < $buyer_rating; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_full.png' > ";
                                                        }

                                                        for ($buyer_i = $buyer_rating; $buyer_i < 5; $buyer_i++) {

                                                            echo " <img class='rating' src='images/user_rate_blank.png' > ";
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
                            <!--- card user-reviews mt-4 mb-4 rounded-0 ends -->

                        </div>
                        <!-- col-md-12 ends -->

                    </div>
                    <!-- row ends -->

                <?php
            } ?>

            </div>
            <!-- col-md-8 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid ends -->


    <?php include("includes/footer.php"); ?>


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