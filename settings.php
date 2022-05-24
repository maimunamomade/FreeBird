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

$login_seller_name = $row_login_seller['seller_name'];

$login_seller_email = $row_login_seller['seller_email'];

$login_seller_paypal_email = $row_login_seller['seller_paypal_email'];

$login_seller_image = $row_login_seller['seller_image'];

$login_seller_headline = $row_login_seller['seller_headline'];

$login_seller_country = $row_login_seller['seller_country'];

$login_seller_language = $row_login_seller['seller_language'];

$login_seller_about = $row_login_seller['seller_about'];


$get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

$run_seller_accounts = mysqli_query($con, $get_seller_accounts);

$row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

$current_balance = $row_seller_accounts['current_balance'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / My Settings </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/user_header.php"); ?>

    <!-- container mt-5 mb-5 starts -->
    <div class="container mt-5 mb-5">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-3 starts -->
            <div class="col-md-3">

                <!-- nav nav-pills nav-stacked mb-4 starts -->
                <ul class="nav nav-pills nav-stacked mb-4">

                    <li class="nav-item">

                        <a href="#profile_settings" data-toggle="pill" class="nav-link 
<?php

if (!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])) {

    echo "active";
}

if (isset($_GET['profile_settings'])) {

    echo "active";
}

?>
">
                            Profile Settings
                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="#account_settings" data-toggle="pill" class="nav-link
<?php

if (isset($_GET['account_settings'])) {

    echo "active";
}

?>
">
                            Account Settings
                        </a>

                    </li>

                </ul>
                <!-- nav nav-pills nav-stacked mb-4 ends -->

            </div>
            <!-- col-md-3 ends -->


            <!-- col-md-9 starts -->
            <div class="col-md-9">

                <!-- card rounded-0 starts -->
                <div class="card rounded-0">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- tab-content starts -->
                        <div class="tab-content">

                            <!-- profile_settings tab-pane fade show active starts -->
                            <div id="profile_settings" class="tab-pane fade 
<?php

if (!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])) {

    echo "show active";
}

if (isset($_GET['profile_settings'])) {

    echo "show active";
}

?>
">

                                <?php include("profile_settings.php"); ?>

                            </div>
                            <!-- profile_settings tab-pane fade show active ends -->

                            <!-- account_settings tab-pane fade starts -->
                            <div id="account_settings" class="tab-pane fade 
<?php

if (isset($_GET['account_settings'])) {

    echo "show active";
}

?>
">

                                <?php include("account_settings.php"); ?>

                            </div>
                            <!-- account_settings tab-pane fade ends -->

                        </div>
                        <!-- tab-content ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card rounded-0 ends -->

            </div>
            <!-- col-md-9 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container mt-5 mb-5 ends -->

    <?php include("includes/footer.php"); ?>


</body>

</html>