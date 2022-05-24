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

$login_seller_image = $row_login_seller['seller_image'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Favorites </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c4be8cc90b9456a"></script>
</head>

<body>
    <?php include("includes/header.php"); ?>

    <!--- container-fluid starts --->
    <div class="container-fluid">

        <?php

        $get_favorites = "select * from favorites where seller_id='$login_seller_id'";

        $run_favorites = mysqli_query($con, $get_favorites);

        $count_favorites = mysqli_num_rows($run_favorites);

        if (isset($_GET['add_favourites'])) {

            while ($row_favorites = mysqli_fetch_array($run_favorites)) {

                $proposal_id = $row_favorites['proposal_id'];

                $get_proposals = "select * from proposals where proposal_id='$proposal_id'";

                $run_proposals = mysqli_query($con, $get_proposals);

                $row_proposals = mysqli_fetch_array($run_proposals);

                $proposal_price = $row_proposals['proposal_price'];

                $insert_cart = "insert into cart (seller_id,proposal_id,proposal_price,proposal_qty) values ('$login_seller_id','$proposal_id','$proposal_price','1')";

                $run_cart = mysqli_query($con, $insert_cart);
            }

            $delete_favorites = "delete from favorites where seller_id='$login_seller_id'";

            $run_delete_favorites = mysqli_query($con, $delete_favorites);

            if ($run_delete_favorites) {

                echo "<script>window.open('cart.php','_self')</script>";
            }
        }


        ?>

        <!--- row bg-light justify-content-center p-4 mb-5 starts --->
        <div class="row bg-light justify-content-center p-4 mb-5">

            <!--- col-md-9 starts --->
            <div class="col-md-9">

                <!--- favourites row starts --->
                <div class="row" id="favourites">

                    <!---  offset-lg-1 col-lg-8 col-md-12 offset-md-0 mb-3 starts --->
                    <div class="offset-lg-1 col-lg-8 col-md-12 offset-md-0 mb-3">

                        <h2> Favourites <small> (<?php echo $count_favorites; ?> Proposlas) </small> </h2>

                        <p class="favourite-description">
                            Bootstrap is the most popular HTML, CSS, and JS framework for developing responsive, mobile-first projects on the web.
                        </p>

                        <p>
                            <a href="favourites.php?add_favourites" class="btn btn-success btn-lg">
                                <i class="fa fa-shopping-cart"></i> Add Favourites To Cart
                            </a>
                        </p>

                    </div>
                    <!---  offset-lg-1 col-lg-8 col-md-12 offset-md-0 mb-3 ends --->

                    <!--- col-lg-3 col-md-12 starts --->
                    <div class="col-lg-3 col-md-12">

                        <!--- favourite-owner mb-lg-5 mb-md-0 mb-0 starts --->
                        <div class="favourite-owner mb-lg-5 mb-md-0 mb-0">

                            <?php if (!empty($login_seller_image)) { ?>

                                <img src="user_images/<?php echo $login_seller_image; ?>">

                            <?php } else { ?>

                                <img src="user_images/empty-image.png">

                            <?php } ?>

                            Collected By

                            <br>

                            <a href="#"> <strong><?php echo $login_seller_user_name; ?></strong> </a>

                        </div>
                        <!--- favourite-owner mb-lg-5 mb-md-0 mb-0 ends --->

                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_inline_share_toolbox_etca"></div>

                    </div>
                    <!--- col-lg-3 col-md-12 ends --->

                </div>
                <!--- favourites row ends --->

            </div>
            <!--- col-md-9 ends --->

        </div>
        <!--- row bg-light justify-content-center p-4 mb-5 ends --->

    </div>
    <!--- container-fluid ends --->


    <!--- container starts --->
    <div class="container">

        <!--- row starts --->
        <div class="row">

            <?php

            $get_favorites = "select * from favorites where seller_id='$login_seller_id'";

            $run_favorites = mysqli_query($con, $get_favorites);

            while ($row_favorites = mysqli_fetch_array($run_favorites)) {

                $favorite_proposal_id = $row_favorites['proposal_id'];


                $get_proposals = "select * from proposals where proposal_id='$favorite_proposal_id'";

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

                $select_proposals_favorites = "select * from favorites where proposal_id='$proposal_id' AND seller_id='$login_seller_id'";

                $run_proposals_favorites = mysqli_query($con, $select_proposals_favorites);

                $count_proposals_favorites = mysqli_num_rows($run_proposals_favorites);

                if ($count_proposals_favorites == 0) {

                    $show_favorite_id = "favorite_$proposal_id";

                    $show_favorite_class = "favorite";
                } else {

                    $show_favorite_id = "unfavorite_$proposal_id";

                    $show_favorite_class = "favorited";
                }


                ?>

                <!---- col-xl-3 col-lg-4 col-md-6 col-sm-6 starts --->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">

                    <!--- proposal-div starts --->
                    <div class="proposal-div">

                        <!--- proposal_nav starts --->
                        <div class="proposal_nav">

                            <span class="float-left mt-2">
                                <strong class="ml-2 mr-1"> By </strong> <?php echo $seller_user_name; ?>
                            </span>

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

                                <span class="ml-1 mr-2">(<?php echo $count_reviews; ?>)</span>

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

                                <span class="float-right"> STARTING AT
                                    <strong class="price">
                                        ₹<?php echo $proposal_price; ?>
                                    </strong>
                                </span>

                            </p>
                            <!--- buttons clearfix ends --->

                        </div>
                        <!--- text ends --->

                        <!--- ribbon starts --->
                        <div class="ribbon">

                            <div class="theribbon"> Featured </div>

                            <div class="ribbon-background"> </div>

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

                </div>
                <!---- col-xl-3 col-lg-4 col-md-6 col-sm-6 ends --->

            <?php } ?>

        </div>
        <!--- row ends --->

    </div>
    <!--- container ends --->


    <?php include("includes/footer.php"); ?>


</body>

</html>