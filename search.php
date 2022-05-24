<?php

session_start();

include("includes/db.php");

include("functions/functions.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Search Results For <?php echo @$_SESSION['search_query']; ?> </title>

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
                    <h1> Search Results </h1>

                    <p class="lead"> "<?php echo @$_SESSION['search_query']; ?>" </p>
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

                <?php include("includes/search_sidebar.php"); ?>

            </div>
            <!-- col-lg-3 col-md-4 col-sm-12 ends -->


            <!-- col-lg-9 col-md-8 col-sm-12 starts -->
            <div class="col-lg-9 col-md-8 col-sm-12">

                <!-- row flex-wrap starts -->
                <div class="row flex-wrap" id="search_proposals">

                    <?php get_search_proposals(); ?>

                </div>
                <!-- row flex-wrap ends -->

                <div id="wait"> </div>

                <br> <br>

                <!-- row justify-content-center starts -->
                <div class="row justify-content-center">

                    <!-- nav starts -->
                    <nav>

                        <!-- pagination starts -->
                        <ul class="pagination" id="search_pagination">

                            <?php get_search_pagination(); ?>

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
        function get_search_proposals() {

            var sPath = '';

            var aInputs = Array();

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

            var aInputs = $('li').find('.get_cat_id');

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

                    sPath = sPath + 'cat_id[]=' + aKeys[i] + '&';

                }

            }

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

                url: "search_load.php",
                method: "POST",
                data: sPath + 'zAction=get_search_proposals',
                success: function(data) {

                    $('#search_proposals').html('');

                    $('#search_proposals').html(data);

                    $('#wait').removeClass("loader");

                }

            });

            $.ajax({

                url: "search_load.php",
                method: "POST",
                data: sPath + 'zAction=get_search_pagination',
                success: function(data) {

                    $('#search_pagination').html('');

                    $('#search_pagination').html(data);

                }

            });

        }

        $('.get_online_sellers').click(function() {

            get_search_proposals();

        });

        $('.get_cat_id').click(function() {

            get_search_proposals();

        });

        $('.get_delivery_time').click(function() {

            get_search_proposals();

        });

        $('.get_seller_level').click(function() {

            get_search_proposals();

        });

        $('.get_seller_language').click(function() {

            get_search_proposals();

        });
    </script>


    <script>
        $(document).ready(function() {

            $(".get_cat_id").click(function() {
                if ($(".get_cat_id:checked").length > 0) {
                    $(".clear_cat_id").show();
                } else {
                    $(".clear_cat_id").hide();
                }

            });

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

            $(".clear_cat_id").click(function() {
                $(".clear_cat_id").hide();
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


        function clearCat() {
            $(".get_cat_id").prop("checked", false);

            get_search_proposals();
        }

        function clearDelivery() {
            $(".get_delivery_time").prop("checked", false);

            get_search_proposals();
        }

        function clearLevel() {
            $(".get_seller_level").prop("checked", false);

            get_search_proposals();
        }

        function clearLanguage() {
            $(".get_seller_language").prop("checked", false);

            get_search_proposals();
        }
    </script>

</body>

</html>