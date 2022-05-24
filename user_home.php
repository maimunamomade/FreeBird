<?php

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_name = $row_login_seller['seller_name'];

$login_seller_offers = $row_login_seller['seller_offers'];

?>

<!--- carousel slide starts --->
<div id="myCarousel" class="carousel slide">

    <!--- carousel-indicators starts --->
    <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

        <?php

        $get_slides = "select * from slider";

        $run_slides = mysqli_query($con, $get_slides);

        $count_slides = mysqli_num_rows($run_slides);

        $i = 0;

        $get_slides = "select * from slider LIMIT 1,$count_slides";

        $run_slides = mysqli_query($con, $get_slides);

        while ($row_slides = mysqli_fetch_array($run_slides)) {

            $i++;

            ?>

        <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>

        <?php 
    } ?>

    </ol>
    <!--- carousel-indicators ends --->

    <!--- carousel-inner starts -->
    <div class="carousel-inner">

        <?php

        $get_slides = "select * from slider LIMIT 0,1";

        $run_slides = mysqli_query($con, $get_slides);

        while ($row_slides = mysqli_fetch_array($run_slides)) {

            $slide_image = $row_slides['slide_image'];

            $slide_name = $row_slides['slide_name'];

            $slide_desc = $row_slides['slide_desc'];

            $slide_url = $row_slides['slide_url'];

            ?>

        <!--- carousel-item active starts -->
        <div class="carousel-item active">

            <!--- a starts --->
            <a href="<?php echo $slide_url; ?>">

                <img src="slides_images/<?php echo $slide_image; ?>" class="d-block w-100">

                <!--- carousel-caption starts --->
                <div class="carousel-caption">

                    <h3 class="d-lg-block d-md-block d-none"> <?php echo $slide_name; ?> </h3>

                    <p class="d-lg-block d-md-block d-none">
                        <?php echo $slide_desc; ?>
                    </p>

                </div>
                <!--- carousel-caption Ends --->

            </a>
            <!--- a ends --->

        </div>
        <!--- carousel-item active ends -->

        <?php 
    } ?>

        <?php

        $get_slides = "select * from slider LIMIT 1,$count_slides";

        $run_slides = mysqli_query($con, $get_slides);

        while ($row_slides = mysqli_fetch_array($run_slides)) {

            $slide_image = $row_slides['slide_image'];

            $slide_name = $row_slides['slide_name'];

            $slide_desc = $row_slides['slide_desc'];

            $slide_url = $row_slides['slide_url'];

            ?>

        <!--- carousel-item starts -->
        <div class="carousel-item">

            <!--- a starts --->
            <a href="<?php echo $slide_url; ?>">

                <img src="slides_images/<?php echo $slide_image; ?>" class="d-block w-100">

                <!--- carousel-caption starts --->
                <div class="carousel-caption">

                    <h3 class="d-lg-block d-md-block d-none"> <?php echo $slide_name; ?> </h3>

                    <p class="d-lg-block d-md-block d-none">

                        <?php echo $slide_desc; ?>

                    </p>

                </div>
                <!--- carousel-caption ends --->

            </a>
            <!--- a ends --->

        </div>
        <!--- carousel-item ends -->

        <?php 
    } ?>

    </div>
    <!--- carousel-inner ends -->


    <!--- carousel-control-prev starts -->
    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">

        <span class="carousel-control-prev-icon"></span>

    </a>
    <!--- carousel-control-prev ends -->

    <!--- carousel-control-next starts -->
    <a class="carousel-control-next" href="#myCarousel" data-slide="next">

        <span class="carousel-control-next-icon"></span>

    </a>
    <!--- carousel-control-next ends -->

</div>
<!--- carousel slide ends --->


<!--- container-fluid mt-5 starts --->
<div class="container-fluid mt-5">

    <!--- row starts --->
    <div class="row">

        <!--- col-md-3 Starts --->
        <div class="col-md-3">

            <?php include("includes/user_home_sidebar.php"); ?>

        </div>
        <!--- col-md-3 Ends --->

        <!--- col-md-9 starts --->
        <div class="col-md-9">

            <!--- row starts --->
            <div class="row">

                <!--- col-md-12 starts --->
                <div class="col-md-12">

                    <h2> Featuerd Proposals </h2>

                </div>
                <!--- col-md-12 ends --->

            </div>
            <!--- row Ends --->

            <!--- row starts --->
            <div class="row">

                <!--- col-md-12 flex-wrap starts --->
                <div class="col-md-12 flex-wrap">

                    <!--- owl-carousel user-home-featured-carousel owl-theme starts --->
                    <div class="owl-carousel user-home-featured-carousel owl-theme">

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

                            $select_favorites = "select * from favorites where proposal_id='$proposal_id' AND seller_id='$login_seller_id'";

                            $run_favorites = mysqli_query($con, $select_favorites);

                            $count_favorites = mysqli_num_rows($run_favorites);

                            if ($count_favorites == 0) {

                                $show_favorite_id = "favorite_$proposal_id";

                                $show_favorite_class = "favorite";
                            } else {

                                $show_favorite_id = "unfavorite_$proposal_id";

                                $show_favorite_class = "favorited";
                            }

                            ?>

                        <!--- proposal-div starts --->
                        <div class="proposal-div">

                            <!--- proposal_nav starts --->
                            <div class="proposal_nav">

                                <!--- float-left mt-2 starts --->
                                <span class="float-left mt-2">

                                    <strong class="ml-2 mr-1">
                                        By
                                    </strong>
                                    <?php echo $seller_user_name; ?>

                                </span>
                                <!--- float-left mt-2 snds --->

                                <!--- float-right mt-2 starts --->
                                <span class="float-right mt-2">

                                    <?php

                                    for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_full.png' > ";
                                    }

                                    for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_blank.png' > ";
                                    }


                                    ?>

                                    <span class="ml-1 mr-2">(<?php echo $count_reviews; ?>) Reviews </span>

                                </span>
                                <!--- float-right mt-2 ends --->

                                <div class="clearfix mb-2"> </div>

                            </div>
                            <!--- proposal_nav ends --->

                            <a href="proposals/<?php echo $proposal_url; ?>">
                                <hr class="m-0 p-0">

                                <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">
                            </a>

                            <!--- text starts --->
                            <div class="text">
                                <h4>
                                    <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                        <?php echo $proposal_title; ?>

                                    </a>
                                </h4>

                                <hr>

                                <!--- buttons clearfix starts --->
                                <p class="buttons clearfix">

                                    <a href="#" id="<?php echo $show_favorite_id; ?>" class="<?php echo $show_favorite_class; ?> mt-2 float-left" data-toggle="tooltip" title="Favorites">

                                        <i class="fa fa-heart fa-lg"></i>

                                    </a>

                                    <span class="float-right">

                                        STARTING AT
                                        <strong class="price">
                                            ₹ <?php echo $proposal_price; ?>
                                        </strong>

                                    </span>

                                </p>
                                <!--- buttons clearfix ends --->

                            </div>
                            <!--- text ends --->

                            <!--- ribbon starts --->
                            <div class="ribbon">

                                <div class="theribbon"> Featuerd </div>

                                <div class="ribbon-background"></div>

                            </div>
                            <!--- ribbon ends --->

                            <script>
                                $(document).on("click", "#favorite_<?php echo $proposal_id; ?>", function(event) {

                                    event.preventDefault();

                                    var seller_id = "<?php echo $login_seller_id; ?>";

                                    var proposal_id = "<?php echo $proposal_id; ?>";

                                    $.ajax({

                                        type: "POST",
                                        url: "includes/add_delete_favorite.php",
                                        data: {
                                            seller_id: seller_id,
                                            proposal_id: proposal_id,
                                            favorite: "add_favorite"
                                        },
                                        success: function() {

                                            $("#favorite_<?php echo $proposal_id; ?>").attr({

                                                id: "unfavorite_<?php echo $proposal_id; ?>",
                                                class: "favorited mt-2 float-left"

                                            });

                                        }

                                    });

                                });

                                $(document).on("click", "#unfavorite_<?php echo $proposal_id; ?>", function(event) {

                                    event.preventDefault();

                                    var seller_id = "<?php echo $login_seller_id; ?>";

                                    var proposal_id = "<?php echo $proposal_id; ?>";

                                    $.ajax({

                                        type: "POST",
                                        url: "includes/add_delete_favorite.php",
                                        data: {
                                            seller_id: seller_id,
                                            proposal_id: proposal_id,
                                            favorite: "delete_favorite"
                                        },
                                        success: function() {

                                            $("#unfavorite_<?php echo $proposal_id; ?>").attr({

                                                id: "favorite_<?php echo $proposal_id; ?>",
                                                class: "favorite mt-2 float-left"

                                            });

                                        }

                                    });

                                });
                            </script>

                        </div>
                        <!--- proposal-div ends --->

                        <?php 
                    } ?>

                    </div>
                    <!--- owl-carousel user-home-featured-carousel owl-theme ends --->

                </div>
                <!--- col-md-12 flex-wrap ends --->

            </div>
            <!--- row ends --->


            <!--- row starts --->
            <div class="row">

                <!--- col-md-12 starts --->
                <div class="col-md-12">

                    <h2> Recent Buyer Requests </h2>

                </div>
                <!--- col-md-12 ends --->

            </div>
            <!--- row ends --->

            <!--- row buyer-requests starts --->
            <div class="row buyer-requests">

                <!--- col-md-12 starts -->
                <div class="col-md-12">

                    <!--- table-responsive box-table starts --->
                    <div class="table-responsive box-table">

                        <!--- table table-hover starts --->
                        <table class="table table-hover">

                            <!--- thead starts --->
                            <thead>
                                <tr>
                                    <th>Request</th>

                                    <th>Offers</th>

                                    <th>Duration</th>

                                    <th>Budget</th>
                                </tr>

                            </thead>
                            <!--- thead ends --->

                            <!--- tbody starts --->
                            <tbody>

                                <?php

                                $request_child_ids = array();

                                $select_proposals = "select DISTINCT proposal_child_id from proposals where proposal_seller_id='$login_seller_id'";

                                $run_proposals = mysqli_query($con, $select_proposals);

                                while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                                    $proposal_child_id = $row_proposals['proposal_child_id'];

                                    array_push($request_child_ids, $proposal_child_id);
                                }

                                $where_child_id = array();

                                foreach ($request_child_ids as $child_id) {

                                    $where_child_id[] = "child_id=" . $child_id;
                                }

                                if (count($where_child_id) > 0) {

                                    $query_where = " and (" . implode(" or ", $where_child_id) . ")";
                                }

                                if (!empty($query_where)) {

                                    $select_requests = "select * from buyer_requests where request_status='active'" . $query_where . " AND NOT seller_id='$login_seller_id' order by 1 DESC LIMIT 0,4";

                                    $run_requests = mysqli_query($con, $select_requests);

                                    while ($row_requests = mysqli_fetch_array($run_requests)) {

                                        $request_id = $row_requests['request_id'];

                                        $seller_id = $row_requests['seller_id'];

                                        $request_title = $row_requests['request_title'];

                                        $request_description = $row_requests['request_description'];

                                        $delivery_time = $row_requests['delivery_time'];

                                        $request_budget = $row_requests['request_budget'];

                                        $request_file = $row_requests['request_file'];

                                        $select_request_seller = "select * from sellers where seller_id='$seller_id'";

                                        $run_request_seller = mysqli_query($con, $select_request_seller);

                                        $row_request_seller = mysqli_fetch_array($run_request_seller);

                                        $request_seller_user_name = $row_request_seller['seller_user_name'];

                                        $request_seller_image = $row_request_seller['seller_image'];

                                        $select_send_offers = "select * from send_offers where request_id='$request_id'";

                                        $run_send_offers = mysqli_query($con, $select_send_offers);

                                        $count_send_offers = mysqli_num_rows($run_send_offers);

                                        $select_offers = "select * from send_offers where request_id='$request_id' AND sender_id='$login_seller_id'";

                                        $run_offers = mysqli_query($con, $select_offers);

                                        $count_offers = mysqli_num_rows($run_offers);

                                        if ($count_offers == 0) {

                                            ?>

                                <!--- request_tr_1 id starts --->
                                <tr id="request_tr_<?php echo $request_id; ?>">

                                    <td>
                                        <?php if (!empty($request_seller_image)) { ?>

                                        <img src="user_images/<?php echo $request_seller_image; ?>" class="request-img rounded-circle">

                                        <?php 
                                    } else { ?>

                                        <img src="user_images/empty-image.png" class="request-img rounded-circle">

                                        <?php 
                                    } ?>

                                        <!--- request-description starts --->
                                        <div class="request-description">

                                            <h6><?php echo $request_seller_user_name; ?></h6>

                                            <h6 class="text-primary"> <?php echo $request_title; ?> </h6>

                                            <p class="lead"> <?php echo $request_description; ?> </p>

                                            <?php if (!empty($request_file)) { ?>

                                            <a href="request_files/<?php echo $request_file; ?>" download>

                                                <i class="fa fa-arrow-circle-down"> </i> <?php echo $request_file; ?>

                                            </a>

                                            <?php 
                                        } ?>

                                        </div>
                                        <!--- request-description ends --->

                                    </td>

                                    <td><?php echo $count_send_offers; ?></td>

                                    <td><?php echo $delivery_time; ?></td>

                                    <td class="text-success">

                                        <?php if (!empty($request_budget)) { ?>

                                        ₹<?php echo $request_budget; ?>

                                        <?php 
                                    } else { ?>

                                        ---

                                        <?php 
                                    } ?>

                                        <br>

                                        <?php if ($login_seller_offers == "0") { ?>

                                        <button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>" data-toggle="modal" data-target="#quota-finish">

                                            Send Offer

                                        </button>

                                        <?php 
                                    } else { ?>

                                        <button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>">

                                            Send Offer

                                        </button>

                                        <?php 
                                    } ?>

                                    </td>

                                    <script>
                                        $(".send_button_<?php echo $request_id; ?>").css("visibility", "hidden");

                                        $(document).on("mouseenter", "#request_tr_<?php echo $request_id; ?>", function() {

                                            $(".send_button_<?php echo $request_id; ?>").css("visibility", "visible");

                                        });

                                        $(document).on("mouseleave", "#request_tr_<?php echo $request_id; ?>", function() {

                                            $(".send_button_<?php echo $request_id; ?>").css("visibility", "hidden");

                                        });

                                        <?php if ($login_seller_offers == "0") { ?>


                                        <?php 
                                    } else { ?>

                                        $(".send_button_<?php echo $request_id; ?>").click(function() {

                                            request_id = "<?php echo $request_id; ?>";

                                            $.ajax({

                                                    method: "POST",
                                                    url: "requests/send_offer_modal.php",
                                                    data: {
                                                        request_id: request_id
                                                    }
                                                })
                                                .done(function(data) {

                                                    $(".append-modal").html(data);

                                                });

                                        });

                                        <?php 
                                    } ?>
                                    </script>

                                </tr>
                                <!--- request_tr_1 id ends --->

                                <?php

                            }
                        }
                    }

                    ?>

                            </tbody>
                            <!--- tbody ends --->

                        </table>
                        <!--- table table-hover ends --->

                        <hr>

                        <center>
                            <a href="requests/buyer_requests.php" class="btn btn-success btn-md mb-3">
                                Load More
                            </a>
                        </center>

                    </div>
                    <!--- table-responsive box-table ends --->

                </div>
                <!--- col-md-12 ends -->

            </div>
            <!--- row buyer-requests ends --->

        </div>
        <!--- col-md-9 ends --->

    </div>
    <!--- row ends --->


    <!--- row starts --->
    <div class="row">

        <!--- col-md-6 Starts --->
        <div class="col-md-6">

            <!--- card border-primary mb-3 starts --->
            <div class="card border-primary mb-3">

                <!--- card-header bg-primary starts --->
                <div class="card-header bg-primary">

                    <h5 class="h5 text-white"> Random Proposals </h5>

                </div>
                <!--- card-header bg-primary ends --->

                <!--- card-body vertical-proposals starts --->
                <div class="card-body vertical-proposals">

                    <?php

                    $per_page = 4;

                    if (isset($_GET['random_proposals_page'])) {

                        $page = $_GET['random_proposals_page'];
                    } else {

                        $page = 1;
                    }

                    /// Page Will Start From 0 and Multiply By Per Page


                    $start_from = ($page - 1) * $per_page;

                    /// Selecting The Data From Table With Limits

                    $select_proposals = "select * from proposals where proposal_status='active' order by rand() LIMIT $start_from, $per_page";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                        $proposal_id = $row_proposals['proposal_id'];

                        $proposal_title = $row_proposals['proposal_title'];

                        $proposal_price = $row_proposals['proposal_price'];

                        $proposal_img1 = $row_proposals['proposal_img1'];

                        $proposal_video = $row_proposals['proposal_video'];

                        $proposal_seller_id = $row_proposals['proposal_seller_id'];

                        $proposal_rating = $row_proposals['proposal_rating'];

                        $proposal_url = $row_proposals['proposal_url'];

                        $proposal_desc = substr(strip_tags($row_proposals['proposal_desc']), 0, 200);

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

                    <!--- row mb-3 starts --->
                    <div class="row mb-3">

                        <!--- col-md-3 starts --->
                        <div class="col-md-3">

                            <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="vertical-proposal-img">

                            </a>

                        </div>
                        <!--- col-md-3 ends --->

                        <!--- col-md-9 starts --->
                        <div class="col-md-9">

                            <!--- text starts --->
                            <div class="text">

                                <span class="float-left">

                                    <strong class="ml-2 mr-1"> By </strong> <?php echo $seller_user_name; ?>

                                </span>

                                <span class="float-right">

                                    <?php

                                    for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_full.png' > ";
                                    }

                                    for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_blank.png' > ";
                                    }


                                    ?>

                                    <span class="ml-1 mr-2"> (<?php echo $count_reviews; ?>) Reviews</span>

                                </span>

                                <br> <br>

                                <h6>

                                    <a href="proposals/<?php echo $proposal_url; ?>"> <?php echo $proposal_title; ?> </a>

                                    <span class="text-success"> ₹<?php echo $proposal_price; ?> </span>

                                </h6>

                                <p>

                                    <?php echo $proposal_desc; ?> .. &nbsp;

                                    <a href="proposals/<?php echo $proposal_url; ?>"> Read More </a>

                                </p>

                                <hr>
                            </div>
                            <!--- text ends --->

                        </div>
                        <!--- col-md-9 ends --->

                    </div>
                    <!--- row mb-3 ends --->

                    <?php 
                } ?>

                    <!--- pagination justify-content-center starts --->
                    <ul class="pagination justify-content-center">

                        <?php

                        $select_proposals = "select * from proposals where proposal_status='active' order by rand() LIMIT 0,16";

                        $run_proposals = mysqli_query($con, $select_proposals);

                        $count_proposals = mysqli_num_rows($run_proposals);

                        $total_pages = ceil($count_proposals / $per_page);

                        if (isset($_GET['top_proposals_page'])) {

                            $top_proposals_page = $_GET['top_proposals_page'];
                        } else {

                            $top_proposals_page = 1;
                        }

                        ?>

                        <li class="page-item">

                            <a href="index.php?random_proposals_page=1&top_proposals_page=<?php echo $top_proposals_page; ?>" class="page-link">

                                First Page

                            </a>

                        </li>

                        <?php

                        for ($i = 1; $i <= $total_pages; $i++) {

                            if ($i == $page) {

                                $active = "active";
                            } else {

                                $active = "";
                            }

                            ?>

                        <li class="page-item <?php echo $active; ?>">

                            <a href="index.php?random_proposals_page=<?php echo $i; ?>&top_proposals_page=<?php echo $top_proposals_page; ?>" class="page-link">

                                <?php echo $i; ?>

                            </a>

                        </li>

                        <?php

                    }

                    ?>


                        <li class="page-item">

                            <a href="index.php?random_proposals_page=<?php echo $total_pages; ?>&top_proposals_page=<?php echo $top_proposals_page; ?>" class="page-link">

                                Last Page

                            </a>

                        </li>

                    </ul>
                    <!--- pagination justify-content-center ends --->

                </div>
                <!--- card-body vertical-proposals ends --->

            </div>
            <!--- card border-primary mb-3 ends --->

        </div>
        <!--- col-md-6 ends --->


        <!--- col-md-6 Starts --->
        <div class="col-md-6">

            <!--- card border-primary mb-3 starts --->
            <div class="card border-primary mb-3">

                <!--- card-header bg-primary starts --->
                <div class="card-header bg-primary">

                    <h5 class="h5 text-white"> Top Rated Proposals </h5>

                </div>
                <!--- card-header bg-primary ends --->

                <!--- card-body vertical-proposals starts --->
                <div class="card-body vertical-proposals">

                    <?php

                    $per_page = 4;

                    if (isset($_GET['top_proposals_page'])) {

                        $page = $_GET['top_proposals_page'];
                    } else {

                        $page = 1;
                    }

                    /// Page Will Start From 0 and Multiply By Per Page


                    $start_from = ($page - 1) * $per_page;

                    /// Selecting The Data From Table With Limits

                    $select_proposals = "select * from proposals where proposal_status='active' and proposal_rating='5' LIMIT $start_from, $per_page";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                        $proposal_id = $row_proposals['proposal_id'];

                        $proposal_title = $row_proposals['proposal_title'];

                        $proposal_price = $row_proposals['proposal_price'];

                        $proposal_img1 = $row_proposals['proposal_img1'];

                        $proposal_video = $row_proposals['proposal_video'];

                        $proposal_seller_id = $row_proposals['proposal_seller_id'];

                        $proposal_rating = $row_proposals['proposal_rating'];

                        $proposal_url = $row_proposals['proposal_url'];

                        $proposal_desc = substr(strip_tags($row_proposals['proposal_desc']), 0, 200);

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

                    <!--- row mb-3 starts --->
                    <div class="row mb-3">

                        <!--- col-md-3 starts --->
                        <div class="col-md-3">

                            <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                                <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="vertical-proposal-img">
                            </a>

                        </div>
                        <!--- col-md-3 ends --->

                        <!--- col-md-9 starts --->
                        <div class="col-md-9">

                            <!--- text starts --->
                            <div class="text">

                                <span class="float-left">
                                    <strong class="ml-2 mr-1"> By </strong> <?php echo $seller_user_name; ?>

                                </span>

                                <span class="float-right">

                                    <?php

                                    for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_full.png' > ";
                                    }

                                    for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

                                        echo " <img class='rating' src='images/user_rate_blank.png' > ";
                                    }


                                    ?>

                                    <span class="ml-1 mr-2"> (<?php echo $count_reviews; ?>) Reviews</span>

                                </span>

                                <br> <br>

                                <h6>
                                    <a href="proposals/<?php echo $proposal_url; ?>"> <?php echo $proposal_title; ?> </a>

                                    <span class="text-success"> ₹<?php echo $proposal_price; ?> </span>
                                </h6>

                                <p>
                                    <?php echo $proposal_desc; ?> .. &nbsp;

                                    <a href="proposals/<?php echo $proposal_url; ?>"> Read More </a>
                                </p>

                                <hr>

                            </div>
                            <!--- text ends --->

                        </div>
                        <!--- col-md-9 ends --->

                    </div>
                    <!--- row mb-3 ends --->

                    <?php 
                } ?>


                    <!--- pagination justify-content-center starts --->
                    <ul class="pagination justify-content-center">

                        <?php

                        $select_proposals = "select * from proposals where proposal_status='active' and proposal_rating='5' LIMIT 0,16";

                        $run_proposals = mysqli_query($con, $select_proposals);

                        $count_proposals = mysqli_num_rows($run_proposals);

                        $total_pages = ceil($count_proposals / $per_page);

                        if (isset($_GET['random_proposals_page'])) {

                            $random_proposals_page = $_GET['random_proposals_page'];
                        } else {

                            $random_proposals_page = 1;
                        }


                        ?>

                        <li class="page-item">

                            <a href="index.php?random_proposals_page=<?php echo $random_proposals_page; ?>&top_proposals_page=1" class="page-link">

                                First Page

                            </a>

                        </li>

                        <?php

                        for ($i = 1; $i <= $total_pages; $i++) {

                            if ($i == $page) {

                                $active = "active";
                            } else {

                                $active = "";
                            }

                            ?>

                        <li class="page-item <?php echo $active; ?> ">

                            <a href="index.php?random_proposals_page=<?php echo $random_proposals_page; ?>&top_proposals_page=<?php echo $i; ?>" class="page-link">

                                <?php echo $i; ?>

                            </a>

                        </li>

                        <?php 
                    } ?>

                        <li class="page-item">

                            <a href="index.php?random_proposals_page=<?php echo $random_proposals_page; ?>&top_proposals_page=<?php echo $total_pages; ?>" class="page-link">

                                Last Page

                            </a>

                        </li>

                    </ul>
                    <!--- pagination justify-content-center ends --->

                </div>
                <!--- card-body vertical-proposals ends --->

            </div>
            <!--- card border-primary mb-3 ends --->

        </div>
        <!--- col-md-6 ends --->

    </div>
    <!--- row ends --->

</div>
<!--- container-fluid mt-5 ends --->


<div class="append-modal"> </div>


<!--- quota-finish modal fade starts --->
<div id="quota-finish" class="modal fade">
    <!--- modal-dialog starts --->
    <div class="modal-dialog">
        <!--- modal-content starts --->
        <div class="modal-content">

            <!--- modal-header starts --->
            <div class="modal-header">

                <h5 class="modal-title h5"> Daily Request Limit Exceeded </h5>

                <button class="close" data-dismiss="modal"> &times; </button>

            </div>
            <!--- modal-header ends --->

            <!--- modal-body starts --->
            <div class="modal-body">
                <center>
                    <h4> You Have Already Sent 10 Offers Today, Limit Exceeded </h4>
                </center>

            </div>
            <!--- modal-body ends --->

            <!--- modal-footer starts --->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

            </div>
            <!--- modal-footer ends --->

        </div>
        <!--- modal-content ends --->

    </div>
    <!--- modal-dialog ends --->

</div>
<!--- quota-finish modal fade ends ---> 