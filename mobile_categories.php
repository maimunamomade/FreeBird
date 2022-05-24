<?php

session_start();

include("includes/db.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Categories </title>

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

    <!-- container mt-5 starts -->
    <div class="container mt-5">

        <h2 class="text-center mb-4"> FreeBird Categories </h2>

        <!-- row flex-wrap starts -->
        <div class="row flex-wrap">

            <?php

            $get_categories = "select * from categories where cat_featured='yes'";

            $run_categories = mysqli_query($con, $get_categories);

            while ($row_categories = mysqli_fetch_array($run_categories)) {

                $cat_id = $row_categories['cat_id'];

                $cat_title = $row_categories['cat_title'];

                $cat_image = $row_categories['cat_image'];

                $cat_desc = substr($row_categories['cat_desc'], 0, 60);

                ?>

                <!-- col-lg-3 col-md-4 col-sm-6 starts -->
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <!-- mobile-category starts -->
                    <div class="mobile-category">

                        <!-- category.php?cat_id starts -->
                        <a href="category.php?cat_id=<?php echo $cat_id; ?>">

                            <!-- ml-2 mt-3 category-picture starts -->
                            <div class="ml-2 mt-3 category-picture">

                                <img src="cat_images/<?php echo $cat_image; ?>">

                            </div>
                            <!-- ml-2 mt-3 category-picture ends -->

                            <!-- category-text starts -->
                            <div class="category-text">

                                <p class="category-title">
                                    <strong> <?php echo $cat_title; ?> </strong>
                                </p>

                                <p class="mb-4 category-desc">
                                    <?php echo $cat_desc; ?>
                                </p>

                            </div>
                            <!-- category-text ends -->

                        </a>
                        <!-- category.php?cat_id ends -->

                    </div>
                    <!-- mobile-category ends -->

                </div>
                <!-- col-lg-3 col-md-4 col-sm-6 ends-->

            <?php
        } ?>

        </div>
        <!-- row flex-wrap ends -->

    </div>
    <!-- container mt-5 ends -->


    <?php include("includes/footer.php"); ?>


</body>

</html>