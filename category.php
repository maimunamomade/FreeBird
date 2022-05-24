<?php

session_start();

include("includes/db.php");

include("functions/functions.php");

if (isset($_GET['cat_id'])) {

    unset($_SESSION['cat_child_id']);

    $cat_id = $_GET['cat_id'];

    $_SESSION['cat_id'] = $cat_id;
}

if (isset($_GET['cat_child_id'])) {

    unset($_SESSION['cat_id']);

    $cat_child_id = $_GET['cat_child_id'];

    $_SESSION['cat_child_id'] = $cat_child_id;
}

?>

<!DOCTYPE html>
<html>

<head>
    <?php

    if (isset($_SESSION['cat_id'])) {

        $cat_id = $_SESSION['cat_id'];

        $get_cats = "select * from categories where cat_id='$cat_id'";

        $run_cats = mysqli_query($con, $get_cats);

        $row_cats = mysqli_fetch_array($run_cats);

        $cat_title = $row_cats['cat_title'];

        $cat_desc = $row_cats['cat_desc'];

        ?>


        <title>FreeBird / <?php echo $cat_title; ?> </title>
        <meta name="description" content="<?php echo $cat_desc; ?>">

    <?php
} ?>

    <?php

    if (isset($_SESSION['cat_child_id'])) {

        $cat_child_id = $_SESSION['cat_child_id'];

        $get_child_cats = "select * from categories_childs where child_id='$cat_child_id'";

        $run_child_cats = mysqli_query($con, $get_child_cats);

        $row_child_cats = mysqli_fetch_array($run_child_cats);

        $child_title = $row_child_cats['child_title'];

        $child_desc = $row_child_cats['child_desc'];

        ?>

        <title> FreeBird / <?php echo $child_title; ?> </title>

        <meta name="description" content="<?php echo $child_desc; ?>">

    <?php
} ?>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

<body class="bg-white">
    <?php include("includes/header.php"); ?>

    <!-- container-fluid mt-5 starts -->
    <div class="container-fluid mt-5">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <center>

                    <?php

                    if (isset($_SESSION['cat_id'])) {

                        $cat_id = $_SESSION['cat_id'];

                        $get_cats = "select * from categories where cat_id='$cat_id'";

                        $run_cats = mysqli_query($con, $get_cats);

                        $row_cats = mysqli_fetch_array($run_cats);

                        $cat_title = $row_cats['cat_title'];

                        $cat_desc = $row_cats['cat_desc'];

                        ?>

                        <h1> <?php echo $cat_title; ?> </h1>

                        <p class="lead">

                            <?php echo $cat_desc; ?>

                        </p>

                    <?php
                } ?>


                    <?php

                    if (isset($_SESSION['cat_child_id'])) {

                        $cat_child_id = $_SESSION['cat_child_id'];

                        $get_child_cats = "select * from categories_childs where child_id='$cat_child_id'";

                        $run_child_cats = mysqli_query($con, $get_child_cats);

                        $row_child_cats = mysqli_fetch_array($run_child_cats);

                        $child_title = $row_child_cats['child_title'];

                        $child_desc = $row_child_cats['child_desc'];

                        ?>

                        <h1> <?php echo $child_title; ?> </h1>

                        <p class="lead">

                            <?php echo $child_desc; ?>

                        </p>

                    <?php
                } ?>
                </center>

                <hr>

            </div>
            <!-- col-md-12 ends -->

        </div>
        <!-- row ends -->

        <!-- row mt-3 starts -->
        <div class="row mt-3">

            <!-- col-lg-3 col-md-4 col-sm-12 starts -->
            <div class="col-lg-3 col-md-4 col-sm-12">

                <?php include("includes/category_sidebar.php"); ?>

            </div>
            <!-- col-lg-3 col-md-4 col-sm-12 ends -->


            <!-- col-lg-9 col-md-8 col-sm-12 starts -->
            <div class="col-lg-9 col-md-8 col-sm-12">

                <!-- row flex-wrap starts -->
                <div class="row flex-wrap" id="category_proposals">

                    <?php get_category_proposals(); ?>

                </div>
                <!-- row flex-wrap ends -->

                <div id="wait"> </div>

                <br> <br>

                <!-- row justify-content-center starts -->
                <div class="row justify-content-center">
                    <!-- nav starts -->
                    <nav>
                        <!-- pagination starts -->
                        <ul class="pagination" id="category_pagination">

                            <?php get_category_pagination(); ?>

                        </ul>
                        <!-- pagination ends -->

                    </nav>
                    <!-- nav ends -->

                </div>
                <!-- row justify-content-center ends -->

            </div>
            <!-- col-lg-9 col-md-8 col-sm-12 ends -->

        </div>
        <!-- row mt-3 ends -->

    </div>
    <!-- container-fluid mt-5 ends -->


    <?php include("includes/footer.php"); ?>

    <script>
        function get_category_proposals() {

            var sPath = '';

            var aInputs = $('li').find('.get_online_sellers');

            var aKeys = Array();

            var aValues = Array();

            iKey = 0;

            $.each(aInputs, function(key, oInput) {

                if (oInput.checked) {

                    aKeys[iKey] = oInput.value

                };

                iKey++;

            });

            if (aKeys.length > 0) {

                var sPath = '';

                for (var i = 0; i < aKeys.length; i++) {

                    sPath = sPath + 'online_sellers[]=' + aKeys[i] + '&';

                }

            }

            var aInputs = Array();

            var aInputs = $('li').find('.get_delivery_time');

            var aKeys = Array();

            var aValues = Array();

            iKey = 0;

            $.each(aInputs, function(key, oInput) {

                if (oInput.checked) {

                    aKeys[iKey] = oInput.value

                };

                iKey++;

            });

            if (aKeys.length > 0) {

                for (var i = 0; i < aKeys.length; i++) {

                    sPath = sPath + 'delivery_time[]=' + aKeys[i] + '&';

                }

            }

            var aInputs = Array();

            var aInputs = $('li').find('.get_seller_level');

            var aKeys = Array();

            var aValues = Array();

            iKey = 0;

            $.each(aInputs, function(key, oInput) {

                if (oInput.checked) {

                    aKeys[iKey] = oInput.value

                };

                iKey++;

            });

            if (aKeys.length > 0) {

                for (var i = 0; i < aKeys.length; i++) {

                    sPath = sPath + 'seller_level[]=' + aKeys[i] + '&';

                }

            }

            var aInputs = Array();

            var aInputs = $('li').find('.get_seller_language');

            var aKeys = Array();

            var aValues = Array();

            iKey = 0;

            $.each(aInputs, function(key, oInput) {

                if (oInput.checked) {

                    aKeys[iKey] = oInput.value

                };

                iKey++;

            });

            if (aKeys.length > 0) {

                for (var i = 0; i < aKeys.length; i++) {

                    sPath = sPath + 'seller_language[]=' + aKeys[i] + '&';

                }

            }

            $('#wait').addClass("loader");

            $.ajax({

                url: "category_load.php",
                method: "POST",
                data: sPath + 'zAction=get_category_proposals',
                success: function(data) {

                    $('#category_proposals').html('');

                    $('#category_proposals').html(data);

                    $('#wait').removeClass("loader");

                }

            });

            $.ajax({

                url: "category_load.php",
                method: "POST",
                data: sPath + 'zAction=get_category_pagination',
                success: function(data) {

                    $('#category_pagination').html('');

                    $('#category_pagination').html(data);

                }

            });

        }

        $('.get_online_sellers').click(function() {

            get_category_proposals();

        });

        $('.get_delivery_time').click(function() {

            get_category_proposals();

        });

        $('.get_seller_level').click(function() {

            get_category_proposals();

        });

        $('.get_seller_language').click(function() {

            get_category_proposals();

        });
    </script>


    <script>
        $(document).ready(function() {

            $(".get_delivery_time").click(function() {
                if ($(".get_delivery_time:checked").length > 0) {
                    $(".clear_delivery_time").show();
                } else {
                    $(".clear_delivery_time").hide();
                }

            });


            $(".get_seller_level").click(function() {
                if ($(".get_seller_level:checked").length > 0) {
                    $(".clear_seller_level").show();
                } else {
                    $(".clear_seller_level").hide();
                }

            });


            $(".get_seller_language").click(function() {
                if ($(".get_seller_language:checked").length > 0) {
                    $(".clear_seller_language").show();
                } else {
                    $(".clear_seller_language").hide();
                }

            });

            $(".clear_delivery_time").click(function() {
                $(".clear_delivery_time").hide();
            });

            $(".clear_seller_level").click(function() {
                $(".clear_seller_level").hide();
            });

            $(".clear_seller_language").click(function() {
                $(".clear_seller_language").hide();
            });

        });

        function clearDelivery() {
            $(".get_delivery_time").prop("checked", false);

            get_category_proposals();
        }

        function clearLevel() {
            $(".get_seller_level").prop("checked", false);

            get_category_proposals();
        }

        function clearLanguage() {
            $(".get_seller_language").prop("checked", false);

            get_category_proposals();
        }
    </script>

</body>

</html>