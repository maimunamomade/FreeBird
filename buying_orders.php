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

    <title>FreeBird / Buying Proposal Orders </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">

    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/user_nav_style.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/user_header.php"); ?>


    <!---  container-fluid mt-5 starts --->
    <div class="container-fluid mt-5">

        <!--- row starts --->
        <div class="row">

            <!--- col-md-12 starts --->
            <div class="col-md-12">

                <h2> Manage Buying Proposals Orders </h2>

                <!--- col-md-12 ends --->
            </div>

        </div>
        <!--- row ends --->


        <!--- row starts --->
        <div class="row">

            <!--- col-md-12 mt-5 mb-3 starts --->
            <div class="col-md-12 mt-5 mb-3">

                <!--- nav nav-tabs starts --->
                <ul class="nav nav-tabs">

                    <!--- nav-item starts --->
                    <li class="nav-item">

                        <?php

                        $sel_orders = "select * from orders where buyer_id='$login_seller_id' AND order_active='yes'";

                        $run_orders = mysqli_query($con, $sel_orders);

                        $count_orders = mysqli_num_rows($run_orders);

                        ?>

                        <a href="#active" data-toggle="tab" class="nav-link active">
                            ACTIVE
                            <span class="badge badge-success">
                                <?php echo $count_orders; ?>
                            </span>
                        </a>

                    </li>
                    <!--- nav-item ends --->

                    <!--- nav-item starts --->
                    <li class="nav-item">

                        <?php

                        $sel_orders = "select * from orders where buyer_id='$login_seller_id' AND order_status='delivered'";

                        $run_orders = mysqli_query($con, $sel_orders);

                        $count_orders = mysqli_num_rows($run_orders);

                        ?>

                        <a href="#delivered" data-toggle="tab" class="nav-link">
                            DELIVERED
                            <span class="badge badge-success">
                                <?php echo $count_orders; ?>
                            </span>
                        </a>

                    </li>
                    <!--- nav-item ends --->


                    <!--- nav-item starts --->
                    <li class="nav-item">

                        <?php

                        $sel_orders = "select * from orders where buyer_id='$login_seller_id' AND order_status='completed'";

                        $run_orders = mysqli_query($con, $sel_orders);

                        $count_orders = mysqli_num_rows($run_orders);

                        ?>

                        <a href="#completed" data-toggle="tab" class="nav-link">
                            COMPLETED
                            <span class="badge badge-success">
                                <?php echo $count_orders; ?>
                            </span>
                        </a>

                    </li>
                    <!--- nav-item ends --->


                    <!--- nav-item starts --->
                    <li class="nav-item">

                        <?php

                        $sel_orders = "select * from orders where buyer_id='$login_seller_id' AND order_status='cancelled'";

                        $run_orders = mysqli_query($con, $sel_orders);

                        $count_orders = mysqli_num_rows($run_orders);

                        ?>

                        <a href="#cancelled" data-toggle="tab" class="nav-link">
                            CANCELLED
                            <span class="badge badge-success">
                                <?php echo $count_orders; ?>
                            </span>
                        </a>

                    </li>
                    <!--- nav-item ends --->


                    <!--- nav-item Starts --->
                    <li class="nav-item">

                        <?php

                        $sel_orders = "select * from orders where buyer_id='$login_seller_id'";

                        $run_orders = mysqli_query($con, $sel_orders);

                        $count_orders = mysqli_num_rows($run_orders);

                        ?>

                        <a href="#all" data-toggle="tab" class="nav-link">
                            ALL
                            <span class="badge badge-success">
                                <?php echo $count_orders; ?>
                            </span>
                        </a>

                    </li>
                    <!--- nav-item ends --->

                </ul>
                <!--- nav nav-tabs ends --->


                <!--- tab-content starts --->
                <div class="tab-content">

                    <!--- active tab-pane fade show active starts --->
                    <div class="tab-pane fade show active" id="active">

                        <?php include("manage_orders/order_active_buying.php"); ?>

                    </div>
                    <!--- active tab-pane fade show active ends --->


                    <!--- delivered tab-pane fade starts --->
                    <div class="tab-pane fade" id="delivered">

                        <?php include("manage_orders/order_delivered_buying.php"); ?>

                    </div>
                    <!--- delivered tab-pane fade ends --->


                    <!--- completed tab-pane fade starts --->
                    <div class="tab-pane fade" id="completed">

                        <?php include("manage_orders/order_completed_buying.php"); ?>

                    </div>
                    <!--- completed tab-pane fade ends --->


                    <!--- cancelled tab-pane fade starts --->
                    <div class="tab-pane fade" id="cancelled">


                        <?php include("manage_orders/order_cancelled_buying.php"); ?>

                    </div>
                    <!--- cancelled tab-pane fade ends --->


                    <!--- all tab-pane fade starts --->
                    <div class="tab-pane fade" id="all">


                        <?php include("manage_orders/order_all_buying.php"); ?>

                    </div>
                    <!--- all tab-pane fade ends --->


                </div>
                <!--- tab-content ends --->

            </div>
            <!--- col-md-12 mt-5 mb-3 ends --->

        </div>
        <!--- row ends --->

    </div>
    <!---  container-fluid mt-5 ends --->


    <?php include("includes/footer.php"); ?>


</body>

</html>