<!-- col-md-12 user-header pl-5 pr-5 pt-5 pb-5 starts -->
<div class="col-md-12 user-header pl-5 pr-5 pt-5 pb-5">

    <?php

    $select_seller = "select * from sellers where seller_user_name='$get_seller_user_name'";

    $run_seller = mysqli_query($con, $select_seller);

    $row_seller = mysqli_fetch_array($run_seller);

    $seller_id = $row_seller['seller_id'];

    $seller_user_name = $row_seller['seller_user_name'];

    $seller_image = $row_seller['seller_image'];

    $seller_country = $row_seller['seller_country'];

    $seller_headline = $row_seller['seller_headline'];

    $seller_about = $row_seller['seller_about'];

    $seller_level = $row_seller['seller_level'];

    $seller_rating = $row_seller['seller_rating'];

    $seller_register_date = $row_seller['seller_register_date'];

    $seller_recent_delivery = $row_seller['seller_recent_delivery'];

    $seller_status = $row_seller['seller_status'];


    $get_proposals = "select * from proposals where proposal_seller_id='$seller_id' AND proposal_status='active'";

    $run_proposals = mysqli_query($con, $get_proposals);

    $count_proposals = mysqli_num_rows($run_proposals);


    $select_buyer_reviews = "select * from buyer_reviews where review_seller_id='$seller_id'";

    $run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

    $count_reviews = mysqli_num_rows($run_buyer_reviews);

    if (!$count_reviews == 0) {

        $rattings = array();

        while ($row_buyer_reviews = mysqli_fetch_array($run_buyer_reviews)) {

            $buyer_rating = $row_buyer_reviews['buyer_rating'];

            array_push($rattings, $buyer_rating);
        }

        $total = array_sum($rattings);

        @$average = $total / count($rattings);

        $average_rating = substr($average, 0, 1);
    } else {

        $average = "0";

        $average_rating = "0";
    }

    $get_seller_level = "select * from seller_levels where level_id='$seller_level'";

    $run_seller_level = mysqli_query($con, $get_seller_level);

    $row_seller_level = mysqli_fetch_array($run_seller_level);

    $level_title = $row_seller_level['level_title'];

    ?>

    <!--- profile-image float-lg-left float-md-left float-none mr-4 starts -->
    <div class="profile-image float-lg-left float-md-left float-none mr-4">

        <?php if (!empty($seller_image)) { ?>

            <img src="user_images/<?php echo $seller_image; ?>" class="rounded-circle">

        <?php
    } else { ?>

            <img src="user_images/empty-picture.png" class="rounded-circle">

        <?php
    } ?>

        <?php if ($seller_level == 2) { ?>

            <img src="images/level_badge_1.png" class="level_badge">

        <?php
    } ?>


        <?php if ($seller_level == 3) { ?>

            <img src="images/level_badge_2.png" class="level_badge">

        <?php
    } ?>

        <?php if ($seller_level == 4) { ?>

            <img src="images/level_badge_3.png" class="level_badge">

        <?php
    } ?>

    </div>
    <!--- profile-image float-lg-left float-md-left float-none mr-4 ends -->

    <!--- content-bar mt-3 starts -->
    <div class="content-bar mt-3">

        <h1> Hi, I'm <?php echo $seller_user_name; ?> </h1>

        <span class="headline">
            <?php echo $seller_headline; ?>
        </span>

        <!-- star-rating starts -->
        <div class="star-rating">

            <?php

            for ($seller_i = 0; $seller_i < $average_rating; $seller_i++) {

                echo " <i class='fa fa-star'></i> ";
            }

            for ($seller_i = $average_rating; $seller_i < 5; $seller_i++) {

                echo " <i class='fa fa-star-o'></i> ";
            }

            ?>

            <span class="text-white m-1">

                <strong>
                    <?php printf("%.1f", $average); ?>
                </strong> (<?php echo $count_reviews; ?>)
                Reviews

            </span>

            <span class="text-white">
                <i class="fa fa-map-marker m-1"></i> <?php echo $seller_country; ?>
            </span>

        </div>
        <!-- star-rating ends -->

        <?php if ($seller_status == "online") { ?>

            <span class="user-is-online">

                <span class="text-success h6">
                    <i class="fa fa-circle"> </i>
                </span>

                <span> Online </span>

            </span>

        <?php
    } ?>

    </div>
    <!--- content-bar mt-3 ends -->

    <?php if ($_SESSION['seller_user_name'] != $seller_user_name) { ?>

        <?php if ($count_proposals != 0) { ?>

            <?php if (!isset($_SESSION['seller_user_name'])) { ?>

                <a class="btn btn-primary mt-3" href="login.php">

                    Contact <small>(<?php echo $seller_user_name; ?>)</small>

                </a>

            <?php } else { ?>

                <a class="btn btn-primary mt-3" href="conversations/message.php?seller_id=<?php echo $seller_id; ?>">

                    Contact <small>(<?php echo $seller_user_name; ?>)</small>

                </a>

            <?php } ?>

        <?php } ?>

    <?php } ?>

</div>
<!-- col-md-12 user-header pl-5 pr-5 pt-5 pb-5 ends -->


<!--- col-md-12 user-status starts -->
<div class="col-md-12 user-status">

    <!-- ul starts -->
    <ul>

        <li>
            <i class="fa fa-user"></i>
            Member Since : <strong> <?php echo $seller_register_date; ?> </strong>
        </li>

        <?php if ($seller_recent_delivery != "none") { ?>

            <li>
                <i class="fa fa-truck fa-flip-horizontal"></i>
                Recent Delivery : <strong> <?php echo $seller_recent_delivery; ?> </strong>
            </li>

        <?php
    } ?>

        <?php if ($seller_level != 1) { ?>

            <li>
                <i class="fa fa-clock-o"></i>
                Seller Level : <strong> <?php echo $level_title; ?> </strong>
            </li>

        <?php
    } ?>

    </ul>
    <!-- ul ends -->

</div>
<!--- col-md-12 user-status ends -->