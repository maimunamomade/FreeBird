<?php

session_start();

include("includes/db.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird - Terms & Conditions </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="FreeBird is a revolutionary service for independent entrepeneurs to focus on growth and create sucessful business at affordable cost">
    <meta name="keywords" content="freebird, terms, conditions, freelance, freelancer, jobs, buyers, sellers, proposals, requests">
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

    <!--- container-fluid mt-5 mb-5 starts -->
    <div class="container-fluid mt-5 mb-5">

        <!-- row mb-3 starts -->
        <div class="row mb-3">

            <!-- col-md-12 text-center starts -->
            <div class="col-md-12 text-center">

                <h1>Terms & Conditions</h1>

            </div>
            <!-- col-md-12 text-center ends -->

        </div>
        <!-- row mb-3 ends -->


        <!-- row starts -->
        <div class="row">

            <!-- col-md-3 mb-3 starts -->
            <div class="col-md-3 mb-3">

                <!-- card starts -->
                <div class="card">

                    <!--- card-body starts --->
                    <div class="card-body">

                        <!--- nav nav-pills flex-column mt-2 starts --->
                        <ul class="nav nav-pills flex-column mt-2">

                            <?php

                            $get_terms = "select * from terms LIMIT 0,1";

                            $run_terms = mysqli_query($con, $get_terms);

                            while ($row_terms = mysqli_fetch_array($run_terms)) {

                                $term_title = $row_terms['term_title'];

                                $term_link = $row_terms['term_link'];

                                ?>

                                <li class="nav-item">

                                    <a class="nav-link active" data-toggle="pill" href="#<?php echo $term_link; ?>">

                                        <?php echo $term_title; ?>

                                    </a>

                                </li>

                            <?php
                        } ?>

                            <?php

                            $get_terms = "select * from terms";

                            $run_terms = mysqli_query($con, $get_terms);

                            $count_terms = mysqli_num_rows($run_terms);

                            $get_terms = "select * from terms LIMIT 1,$count_terms";

                            $run_terms = mysqli_query($con, $get_terms);

                            while ($row_terms = mysqli_fetch_array($run_terms)) {

                                $term_title = $row_terms['term_title'];

                                $term_link = $row_terms['term_link'];

                                ?>

                                <li class="nav-item">

                                    <a class="nav-link" data-toggle="pill" href="#<?php echo $term_link; ?>">

                                        <?php echo $term_title; ?>

                                    </a>

                                </li>

                            <?php
                        } ?>

                        </ul>
                        <!--- nav nav-pills flex-column mt-2 ends --->

                    </div>
                    <!--- card-body ends --->

                </div>
                <!-- card ends -->

            </div>
            <!-- col-md-3 mb-3 ends -->


            <!-- col-md-9 starts -->
            <div class="col-md-9">

                <!--- card starts --->
                <div class="card">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- tab-content starts-->
                        <div class="tab-content">

                            <?php

                            $get_terms = "select * from terms LIMIT 0,1";

                            $run_terms = mysqli_query($con, $get_terms);

                            while ($row_terms = mysqli_fetch_array($run_terms)) {

                                $term_title = $row_terms['term_title'];

                                $term_link = $row_terms['term_link'];

                                $term_description = $row_terms['term_description'];

                                ?>

                                <!--- tab-pane fade show active starts -->
                                <div id="<?php echo $term_link; ?>" class="tab-pane fade show active">

                                    <h1> <?php echo $term_title; ?> </h1>

                                    <p>
                                        <?php echo $term_description; ?>
                                    </p>

                                </div>
                                <!--- tab-pane fade show active ends -->

                            <?php
                        } ?>

                            <?php

                            $get_terms = "select * from terms LIMIT 1,$count_terms";

                            $run_terms = mysqli_query($con, $get_terms);

                            while ($row_terms = mysqli_fetch_array($run_terms)) {

                                $term_title = $row_terms['term_title'];

                                $term_link = $row_terms['term_link'];

                                $term_description = $row_terms['term_description'];

                                ?>

                                <div id="<?php echo $term_link; ?>" class="tab-pane fade">
                                    <!--- tab-pane fade Starts -->

                                    <h1> <?php echo $term_title; ?> </h1>

                                    <p>

                                        <?php echo $term_description; ?>

                                    </p>

                                </div>
                                <!--- tab-pane fade Ends -->

                            <?php
                        } ?>

                        </div>
                        <!-- tab-content ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!--- card ends --->

            </div>
            <!-- col-md-9 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!--- container-fluid mt-5 mb-5 ends -->

    <?php include("includes/footer.php"); ?>


</body>

</html>