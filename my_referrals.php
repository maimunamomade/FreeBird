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

$login_seller_referral = $row_login_seller['seller_referral'];


$get_general_settings = "select * from general_settings";

$run_general_settings = mysqli_query($con, $get_general_settings);

$row_general_settings = mysqli_fetch_array($run_general_settings);

$referral_money = $row_general_settings['referral_money'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / My Referrals </title>

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

    <!-- container-fluid starts -->
    <div class="container-fluid">

        <!-- row starts -->
        <div class="row">

            <!-- col-lg-10 col-md-10 mt-5 mb-5 starts -->
            <div class="col-lg-10 col-md-10 mt-5 mb-5">

                <!-- card rounded-0 starts -->
                <div class="card rounded-0">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <h1> My Referrals </h1>

                        <p class="lead">
                            For each unique member you refer that signs up you will get

                            <span class="font-weight-bold text-success">₹<?php echo $referral_money; ?></span>

                            added to your account balance once it is approved by us.

                        </p>

                        <h4 class="border border-primary rounded p-3">
                            Your Unique Referral Link Is:
                            <mark>
                                <?php echo $site_url; ?>?referral=<?php echo $login_seller_referral; ?>
                            </mark>
                        </h4>

                        <p class="lead text-danger">

                            Note: If we conclude that the referral is a fraud it will be declined and you will not receive anything.

                        </p>

                        <!-- row starts -->
                        <div class="row">

                            <!-- col-md-4 mb-3 starts -->
                            <div class="col-md-4 mb-3">

                                <!-- card text-white border-success starts -->
                                <div class="card text-white border-success">

                                    <!-- card-header text-center bg-success starts -->
                                    <div class="card-header text-center bg-success">

                                        <div class="display-4">
                                            ₹
                                            <?php

                                            $total = 0;

                                            $sel_referrals = "select * from referrals where seller_id='$login_seller_id' AND status='approved'";

                                            $run_referrals = mysqli_query($con, $sel_referrals);

                                            while ($row_referrals = mysqli_fetch_array($run_referrals)) {

                                                $comission = $row_referrals['comission'];

                                                $total += $comission;
                                            }

                                            echo $total;

                                            ?>
                                        </div>

                                        <div class="font-weight-bold">

                                            Approved <small> Earned </small>

                                        </div>

                                    </div>
                                    <!-- card-header text-center bg-success ends -->

                                </div>
                                <!-- card text-white border-success ends -->

                            </div>
                            <!-- col-md-4 mb-3 ends -->

                            <!-- col-md-4 mb-3 starts -->
                            <div class="col-md-4 mb-3">

                                <!-- card text-white border-secondary starts -->
                                <div class="card text-white border-secondary">

                                    <!-- card-header text-center bg-secondary starts -->
                                    <div class="card-header text-center bg-secondary">

                                        <div class="display-4">
                                            ₹
                                            <?php

                                            $total = 0;

                                            $sel_referrals = "select * from referrals where seller_id='$login_seller_id' AND status='pending'";

                                            $run_referrals = mysqli_query($con, $sel_referrals);

                                            while ($row_referrals = mysqli_fetch_array($run_referrals)) {

                                                $comission = $row_referrals['comission'];

                                                $total += $comission;
                                            }

                                            echo $total;

                                            ?>
                                        </div>

                                        <div class="font-weight-bold">

                                            Pending

                                        </div>

                                    </div>
                                    <!-- card-header text-center bg-secondary ends -->

                                </div>
                                <!-- card text-white border-secondary ends -->

                            </div>
                            <!-- col-md-4 mb-3 ends -->

                            <!-- col-md-4 mb-3 starts -->
                            <div class="col-md-4 mb-3">

                                <!-- card text-white border-danger starts -->
                                <div class="card text-white border-danger">

                                    <!-- card-header text-center bg-danger starts -->
                                    <div class="card-header text-center bg-danger">

                                        <div class="display-4">
                                            ₹
                                            <?php

                                            $total = 0;

                                            $sel_referrals = "select * from referrals where seller_id='$login_seller_id' AND status='declined'";

                                            $run_referrals = mysqli_query($con, $sel_referrals);

                                            while ($row_referrals = mysqli_fetch_array($run_referrals)) {

                                                $comission = $row_referrals['comission'];

                                                $total += $comission;
                                            }

                                            echo $total;

                                            ?>
                                        </div>

                                        <div class="font-weight-bold">

                                            Declined

                                        </div>

                                    </div>
                                    <!-- card-header text-center bg-danger ends -->

                                </div><!-- card text-white border-danger ends -->

                            </div><!-- col-md-4 mb-3 ends -->

                        </div><!-- row Ends -->

                        <!-- table-responsive border border-secondary rounded starts -->
                        <div class="table-responsive border border-secondary rounded">

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr class="card-header">

                                        <th>Username</th>

                                        <th>Signup Date</th>

                                        <th>Your Commision</th>

                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $sel_referrals = "select * from referrals where seller_id='$login_seller_id' order by 1 DESC";

                                    $run_referrals = mysqli_query($con, $sel_referrals);

                                    $count_referrals = mysqli_num_rows($run_referrals);

                                    if ($count_referrals == 0) {

                                        echo "

<tr>

<td class='text-center' colspan='4'>

<h4 class='text-primary'>You Have Not Referred Anyone Yet.</h4>

</td>

</tr>

";
                                    } else {

                                        while ($row_referrals = mysqli_fetch_array($run_referrals)) {

                                            $referred_id = $row_referrals['referred_id'];

                                            $comission = $row_referrals['comission'];

                                            $date = $row_referrals['date'];

                                            $status = $row_referrals['status'];

                                            $sel_seller = "select * from sellers where seller_id='$referred_id'";

                                            $run_seller = mysqli_query($con, $sel_seller);

                                            $row_seller = mysqli_fetch_array($run_seller);

                                            $seller_user_name = $row_seller['seller_user_name'];

                                            ?>

                                            <tr>

                                                <td><?php echo $seller_user_name; ?></td>

                                                <td><?php echo $date; ?></td>

                                                <td>₹<?php echo $comission; ?></td>

                                                <td class="font-weight-bold
                        <?php

                        if ($status == "approved") {

                            echo "text-success";
                        } elseif ($status == "pending") {

                            echo "text-secondary";
                        } elseif ($status == "declined") {

                            echo "text-danger";
                        }

                        ?>
                        "> <?php echo $status; ?> </td>

                                            </tr>

                                        <?php

                                    }
                                }

                                ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive border border-secondary rounded ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card rounded-0 ends -->

            </div>
            <!-- col-lg-10 col-md-10 mt-5 mb-5 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid ends -->

    <?php include("includes/footer.php"); ?>

</body>

</html>