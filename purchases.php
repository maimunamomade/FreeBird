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


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Purchases </title>

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

            <!-- col-md-12 mt-5 starts -->
            <div class="col-md-12 mt-5">

                <h1 class="mb-4"> Payments </h1>

                <!-- table-responsive box-table starts -->
                <div class="table-responsive box-table">

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

                            $get_purchases = "select * from purchases where seller_id='$login_seller_id' order by 1 DESC";

                            $run_purchases = mysqli_query($con, $get_purchases);

                            while ($row_purchases = mysqli_fetch_array($run_purchases)) {

                                $order_id = $row_purchases['order_id'];

                                $amount = $row_purchases['amount'];

                                $date = $row_purchases['date'];

                                $method = $row_purchases['method'];

                                ?>

                                <tr>

                                    <td> <?php echo $date; ?> </td>

                                    <td>

                                        <?php if ($method == "shopping_balance") { ?>

                                            Proposal Purchased from Shopping Balance
                                            (<a href="order_details.php?order_id=<?php echo $order_id; ?>"> View Order </a>)

                                        <?php } elseif ($method == "stripe") { ?>

                                            Deposit from credit card / stripe
                                            (<a href="order_details.php?order_id=<?php echo $order_id; ?>"> View Order </a>)

                                        <?php } elseif ($method == "paypal") { ?>

                                            payment from purchase / paypal
                                            (<a href="order_details.php?order_id=<?php echo $order_id; ?>"> View Order </a>)

                                        <?php } elseif ($method == "order_cancellation") { ?>

                                            cancelled order payment has been refunded to your shopping balance
                                            (<a href="order_details.php?order_id=<?php echo $order_id; ?>"> View Order </a>)

                                        <?php } ?>

                                    </td>

                                    <td class="text-danger">

                                        <?php

                                        if ($method == "order_cancellation") {

                                            echo "+₹$amount.00";
                                        } else {

                                            echo "-₹$amount.00";
                                        }

                                        ?>


                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                    <!-- table table-hover ends -->

                </div>
                <!-- table-responsive box-table ends -->

            </div>
            <!-- col-md-12 mt-5 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

    <?php include("includes/footer.php"); ?>


</body>

</html>