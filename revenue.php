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

$login_seller_paypal_email = $row_login_seller['seller_paypal_email'];

$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con, $get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$withdrawal_limit = $row_payment_settings['withdrawal_limit'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Revenues </title>

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

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mt-5 mb-3 starts -->
            <div class="col-md-12 mt-5 mb-3">

                <h1 class="pull-left"> Revenues </h1>

                <?php

                $get_seller_accounts = "select * from seller_accounts where seller_id='$login_seller_id'";

                $run_seller_accounts = mysqli_query($con, $get_seller_accounts);

                $row_seller_accounts = mysqli_fetch_array($run_seller_accounts);

                $current_balance = $row_seller_accounts['current_balance'];

                $used_purchases = $row_seller_accounts['used_purchases'];

                $pending_clearance = $row_seller_accounts['pending_clearance'];

                $withdrawn = $row_seller_accounts['withdrawn'];

                ?>

                <p class="lead pull-right">

                    Available for Withdrawal:
                    <span class="font-weight-bold">
                        ₹<?php echo $current_balance; ?>
                    </span>

                </p>

            </div>
            <!-- col-md-12 mt-5 mb-3 ends -->

            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <!-- card mb-3 rounded-0 starts -->
                <div class="card mb-3 rounded-0  bg-secondary">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- row starts -->
                        <div class="row">

                            <!-- col-md-3 text-center border-box starts -->
                            <div class="col-md-3 text-center border-box bg-warning">

                                <p> Withdrawals </p>

                                <h2> ₹<?php echo $withdrawn; ?> </h2>

                            </div>
                            <!-- col-md-3 text-center border-box ends -->


                            <!-- col-md-3 text-center border-box starts -->
                            <div class="col-md-3 text-center border-box bg-primary">


                                <p> Used To Order proposals </p>

                                <h2> ₹<?php echo $used_purchases; ?> </h2>

                            </div>
                            <!-- col-md-3 text-center border-box ends -->


                            <!-- col-md-3 text-center border-box Starts -->
                            <div class="col-md-3 text-center border-box bg-info">

                                <p> Pending Clearance </p>

                                <h2> ₹<?php echo $pending_clearance; ?> </h2>

                            </div>
                            <!-- col-md-3 text-center border-box ends -->

                            <!-- col-md-3 text-center border-box starts -->
                            <div class="col-md-3 text-center border-box bg-success">

                                <p> Available Income </p>

                                <h2> ₹<?php echo $current_balance; ?> </h2>

                            </div>
                            <!-- col-md-3 text-center border-box ends -->

                        </div>
                        <!-- row ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card mb-3 rounded-0 ends -->


                <label class="lead pull-left mt-1"> Withdraw: </label>

                <?php if ($current_balance >= $withdrawal_limit) { ?>

                    <button class="btn btn-default ml-2" data-toggle="modal" data-target="#paypal_withdraw_modal">

                        <i class="fa fa-paypal"></i> Paypal Account

                    </button>

                <?php } else { ?>

                    <button class="btn btn-default ml-2" onclick="return alert('You Must Have Minimum ₹<?php echo $withdrawal_limit; ?> Available Balance To Withdraw Revenue To Your Paypal Account.');">

                        <i class="fa fa-paypal"></i> Paypal Account

                    </button>

                <?php } ?>


                <!-- table-responsive box-table mt-4 starts -->
                <div class="table-responsive box-table mt-4">

                    <!-- table table-hover starts -->
                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>For</th>

                                <th>Amount</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $get_revenues = "select * from revenues where seller_id='$login_seller_id' order by 1 DESC";

                            $run_revenues = mysqli_query($con, $get_revenues);

                            while ($row_revenues = mysqli_fetch_array($run_revenues)) {

                                $revenue_id = $row_revenues['revenue_id'];

                                $order_id = $row_revenues['order_id'];

                                $amount = $row_revenues['amount'];

                                $date = $row_revenues['date'];

                                $status = $row_revenues['status'];

                                ?>

                                <tr>

                                    <td> <?php echo $date; ?> </td>

                                    <td>

                                        <?php if ($status == "pending") { ?>

                                            Order Revenue Pending Clearance (<a href="order_deatails.php?order_id=<?php echo $order_id; ?>" target="blank"> View Order </a>)

                                        <?php } else { ?>

                                            Order Revenue (<a href="order_deatails.php?order_id=<?php echo $order_id; ?>" target="blank"> View Order </a>)

                                        <?php } ?>

                                    </td>

                                    <td class="text-success"> +₹<?php echo $amount; ?>.00 </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table><!-- table table-hover Ends -->

                </div><!-- table-responsive box-table mt-4 Ends -->

            </div><!-- col-md-12 Ends -->

        </div><!-- row Ends -->

    </div><!-- container Ends -->

    <!-- paypal_withdraw_modal modal fade starts -->
    <div id="paypal_withdraw_modal" class="modal fade">

        <!-- modal-dialog starts -->
        <div class="modal-dialog">

            <!-- modal-content starts -->
            <div class="modal-content">

                <!-- modal-header starts -->
                <div class="modal-header">

                    <h5 class="modal-title"> Transfer Revenues To Paypal Account </h5>

                    <button class="close" data-dismiss="modal">

                        <span> &times; </span>

                    </button>

                </div>
                <!-- modal-header ends -->

                <!-- modal-body starts -->
                <div class="modal-body">

                    <!-- center starts -->
                    <center>

                        <p class="lead">

                            <?php if (empty($login_seller_paypal_email)) { ?>

                                To Transfer Revenues To Your PayPal Account Please Add Your PayPal Account Email In

                                <a href="<?php echo $site_url; ?>/settings.php?account_settings">
                                    Setting Account Actions Tab
                                </a>

                            </p>

                        <?php } else { ?>

                            <p class="lead">

                                Your Revenues Will Be Send To The Follwing PayPal Account Email:

                                <br> <strong> <?php echo $login_seller_paypal_email; ?> </strong>

                            </p>

                            <!-- form starts -->
                            <form action="paypal_adaptive.php" method="post">

                                <!-- form-group row starts -->
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label font-weight-bold">
                                        Enter Amount
                                    </label>

                                    <!-- col-md-8 starts -->
                                    <div class="col-md-8">

                                        <div class="input-group">

                                            <span class="input-group-addon font-weight-bold"> ₹ </span>

                                            <input type="number" name="amount" class="form-control input-lg" min="<?php echo $withdrawal_limit; ?>" max="<?php echo $current_balance; ?>" placeholder="<?php echo $withdrawal_limit; ?>" required>

                                        </div>

                                    </div>
                                    <!-- col-md-8 ends -->

                                </div>
                                <!-- form-group row ends -->

                                <!-- form-group row starts -->
                                <div class="form-group row">

                                    <div class="col-md-8 offset-md-3">

                                        <input type="submit" name="withdraw" value="Deposit" class="btn btn-success form-control">

                                    </div>

                                </div>
                                <!-- form-group row ends -->

                            </form>
                            <!-- form ends -->

                        <?php } ?>

                    </center>
                    <!-- center ends -->

                </div>
                <!-- modal-body ends -->

                <!-- modal-footer starts -->
                <div class="modal-footer">

                    <button class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>

                </div>
                <!-- modal-footer ends -->

            </div>
            <!-- modal-content ends -->

        </div>
        <!-- modal-dialog ends -->

    </div>
    <!-- paypal_withdraw_modal modal fade ends -->

    <?php include("includes/footer.php"); ?>


</body>

</html>