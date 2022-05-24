<!-- home header starts -->
<header class="home-header">
    <!-- mt-lg-5 mt-md-3 mt-sm-2 starts -->
    <div class="mt-lg-5 mt-md-3 mt-sm-2">
        <center>
            <h1> DON'T JUST DREAM, DO </h1>

            <p class="lead"> FreeBird - Be Independent Right Here, Right Now </p>

            <!-- col-md-5 starts -->
            <form method="post" class="col-md-5">
                <!-- input group starts -->
                <div class="input-group">

                    <input type="text" class="form-control input-lg" placeholder="Search Proposals" name="search_query" value="<?php echo @$_SESSION['search_query']; ?>" required>

                    <span class="input-group-btn">
                        <button class="btn btn-success btn-md" type="submit" name="search">
                            <strong> Search </strong>
                        </button>
                    </span>

                </div>
                <!-- input group ends -->

            </form>
            <!-- col-md-5 ends -->

            <h3 class="mt-3">
                <a href="#" class="btn btn-success btn-lg" data-toggle="modal" data-target="#register-modal">
                    <i class="fa fa-sign-in"> </i> Join FreeLance
                </a>
            </h3>

            <h3 class="mt-3">
                <a href="#" data-toggle="modal" data-target="#how-it-work">
                    How It Works
                </a>
            </h3>

        </center>

    </div>
    <!-- mt-lg-5 mt-md-3 mt-sm-2 ends -->

</header>
<!-- home header ends -->

<!-- categories-section starts -->
<section class="categories-section">

    <!-- container-fluid starts -->
    <div class="container-fluid">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mb-5 text-center starts -->
            <div class="col-md-12 mb-5 text-center">
                <h2> Explore Our Featured Categories </h2>
                <h4 class="text-muted"> Get inspired to build your business </h4>
            </div>
            <!-- col-md-12 mb-5 text-center ends -->

            <!-- container starts -->
            <div class="container">

                <!-- row starts -->
                <div class="row">

                    <?php

                    $get_categories = "select * from categories where cat_featured='yes' LIMIT 0,8";

                    $run_categories = mysqli_query($con, $get_categories);

                    while ($row_categories = mysqli_fetch_array($run_categories)) {

                        $cat_id = $row_categories['cat_id'];

                        $cat_title = $row_categories['cat_title'];

                        $cat_image = $row_categories['cat_image'];

                        ?>

                    <!-- col-lg-3 col-md-4 col-sm-6 starts -->
                    <div class="col-lg-3 col-md-4 col-sm-6">

                        <!-- category-item starts -->
                        <div class="category-item">

                            <a href="category.php?cat_id=<?php echo $cat_id; ?>">

                                <h4> <?php echo $cat_title; ?> </h4>

                                <img src="cat_images/<?php echo $cat_image; ?>">

                            </a>

                        </div>
                        <!-- category-item ends -->

                    </div>
                    <!-- col-lg-3 col-md-4 col-sm-6 ends -->

                    <?php 
                } ?>

                </div>
                <!-- row ends -->

            </div>
            <!-- container ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid ends -->

</section>
<!-- categories-section ends -->

<!-- box-section starts -->
<section class="box-section">

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <?php

            $get_boxes = "select * from section_boxes";

            $run_boxes = mysqli_query($con, $get_boxes);

            while ($row_boxes = mysqli_fetch_array($run_boxes)) {

                $box_title = $row_boxes['box_title'];

                $box_desc = $row_boxes['box_desc'];

                ?>

            <!-- text-center col-sm-4 mb-4 starts -->
            <div class="text-center col-sm-4 mb-4">

                <h3> <?php echo $box_title; ?> </h3>

                <p> <?php echo $box_desc; ?></p>

            </div>
            <!-- text-center col-sm-4 mb-4 ends -->

            <?php 
        } ?>
        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

</section>
<!-- box-section ends -->

<!-- platform-section starts -->
<section class="platform-section">

    <!-- container starts -->
    <div class="container">

        <?php

        $get_section = "select * from home_section";

        $run_section = mysqli_query($con, $get_section);

        $row_section = mysqli_fetch_array($run_section);

        $section_title = $row_section['section_title'];

        $section_short_desc = $row_section['section_short_desc'];

        $section_desc = $row_section['section_desc'];

        $section_button = $row_section['section_button'];

        $section_button_url = $row_section['section_button_url'];

        $section_image = $row_section['section_image'];

        ?>

        <!-- row text-center starts -->
        <div class="row text-center">

            <!-- col-md-6 mb-3 starts -->
            <div class="col-md-6 mb-3">

                <h2> <?php echo $section_title; ?> </h2>

                <h3> <?php echo $section_short_desc; ?> </h3>

                <p>
                    <?php echo $section_desc; ?>
                </p>

                <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#register-modal">
                    Join Now
                </button>

                <a href="<?php echo $section_button_url; ?>" class="btn btn-outline-primary btn-lg">

                    <?php echo $section_button; ?>

                </a>

            </div>
            <!-- col-md-6 mb-3 starts -->

            <!-- col-md-6 starts -->
            <div class="col-md-6">

                <img src="images/<?php echo $section_image; ?>" class="img-fluid rounded">

            </div>
            <!-- col-md-6 ends -->

        </div>
        <!-- row text-center ends -->

    </div>
    <!-- container ends -->

</section>
<!-- platform-section ends -->


<!-- proposals-section starts -->
<section class="proposals-section">

    <!-- container-fluid starts -->
    <div class="container-fluid">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mb-5 text-center starts -->
            <div class="col-md-12 mb-5 text-center">

                <h2> Top Featured Proposals </h2>

                <h4 class="text-muted"> Practical advice for every stage of doing </h4>

            </div>
            <!-- col-md-12 mb-5 text-center ends -->

            <!-- col-md-12 flex-wrap starts -->
            <div class="col-md-12 flex-wrap">

                <!-- owl-carousel home-featured-carousel owl-theme starts -->
                <div class="owl-carousel home-featured-carousel owl-theme">

                    <?php

                    $get_proposals = "select * from proposals where proposal_featured='yes' AND proposal_status='active'";

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

                    <!-- proposal-div starts -->
                    <div class="proposal-div">

                        <!-- proposal_nav starts -->
                        <div class="proposal_nav">

                            <span class="float-left mt-2">
                                <strong class="ml-2 mr-1"> By </strong>
                                <?php echo $seller_user_name; ?>
                            </span>

                            <!-- float-right mt-2 starts -->
                            <span class="float-right mt-2">

                                <?php

                                for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                    echo " <img class='rating' src='images/user_rate_full.png' > ";
                                }

                                for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                    echo " <img class='rating' src='images/user_rate_blank.png' > ";
                                }


                                ?>

                                <span class="ml-1 mr-2">(<?php echo $count_reviews; ?>)
                                    Reviews
                                </span>

                            </span>
                            <!-- float-right mt-2 ends -->

                            <div class="clearfix mb-2"> </div>

                        </div>
                        <!-- proposal_nav ends -->

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

                            <!-- buttons clearfix starts -->
                            <p class="buttons clearfix">

                                <a href="login.php" class="favorite mt-2 float-left" data-toggle="tooltip" title="Add To favorites">
                                    <i class="fa fa-heart fa-lg"> </i>
                                </a>

                                <span class="float-right">
                                    STARTING AT
                                    <strong class="price">
                                        Rs. <?php echo $proposal_price; ?>
                                    </strong>
                                </span>
                            </p>
                            <!-- buttons clearfix ends -->

                        </div>
                        <!-- text ends -->

                        <!-- ribbon starts -->
                        <div class="ribbon">
                            <div class="theribbon"> Featured </div>
                            <div class="ribbon-background"> </div>

                        </div>
                        <!-- ribbon ends -->

                    </div>
                    <!-- proposal-div ends -->

                    <?php 
                } ?>

                </div>
                <!-- owl-carousel home-featured-carousel owl-theme starts -->

            </div>
            <!-- col-md-12 flex-wrap ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid ends -->

</section>
<!-- proposals-section ends -->


<!-- modal fade starts -->
<div class="modal fade" id="how-it-work">

    <!-- modal dialog starts -->
    <div class="modal-dialog">

        <!-- modal content starts -->
        <div class="modal-content">

            <!-- modal header starts -->
            <div class="modal-header">

                <h5 class="h5 modal-title"> How FreeBird Works </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span> &times; </span>
                </button>

            </div>
            <!-- modal header ends -->

            <!-- modal body starts -->
            <div class="modal-body">
                <h4 align="center"> How to Sell </h4>

                <p> Create a new job for a service you can offer. </p>

                <p> Share your job using our social bookmarking tools.</p>

                <p> You will be notified when someone orders your job.</p>

                <p> you deliver your work we will credit your account with $4.</p>

                <p> Withdraw your earnings to your Paypal account.</p>

                <p> Spend your money!</p>

                <h4 align="center"> How to Buy </h4>

                <p> Find a job you like and place an order. </p>

                <p> Pay for your job using Paypal or a credit card. </p>

                <p> Track the seller's progress, communicate and exchange files.</p>

                <p> Receive your finished work.</p>

                <p> You can request fixes from the seller if it is not what you wanted.</p>

                <p> Provide feedback on the seller and job.</p>

                <br>

            </div>
            <!-- modal body ends -->

        </div>
        <!-- modal content ends -->

    </div>
    <!-- modal dialog ends -->

</div>
<!-- modal fade ends --> 