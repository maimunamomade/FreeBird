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

    <title>FreeBird / Manage Contacts </title>

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

            <!-- col-md-12 mt-5 starts -->
            <div class="col-md-12 mt-5">

                <h1> Manage Contacts </h1>

                <!-- nav nav-tabs mt-5 mb-3 starts -->
                <ul class="nav nav-tabs mt-5 mb-3">

                    <?php

                    $sel_my_buyers = "select * from my_buyers where seller_id='$login_seller_id'";

                    $run_my_buyers = mysqli_query($con, $sel_my_buyers);

                    $count_my_buyers = mysqli_num_rows($run_my_buyers);

                    ?>

                    <li class="nav-item">

                        <a href="#my_buyers" data-toggle="tab" class="nav-link active">

                            My Buyers <span class="badge badge-success"><?php echo $count_my_buyers; ?></span>

                        </a>

                    </li>

                    <?php

                    $sel_my_sellers = "select * from my_sellers where buyer_id='$login_seller_id'";

                    $run_my_sellers = mysqli_query($con, $sel_my_sellers);

                    $count_my_sellers = mysqli_num_rows($run_my_sellers);

                    ?>

                    <li class="nav-item">

                        <a href="#my_sellers" data-toggle="tab" class="nav-link">

                            My Sellers <span class="badge badge-success"><?php echo $count_my_sellers; ?></span>

                        </a>

                    </li>

                </ul>
                <!-- nav nav-tabs mt-5 mb-3 ends -->


                <!-- tab-content mt-2 starts -->
                <div class="tab-content mt-2">

                    <!-- my_buyers tab-pane fade show active starts -->
                    <div id="my_buyers" class="tab-pane fade show active">

                        <!-- table-responsive box-table starts -->
                        <div class="table-responsive box-table">

                            <h4 class="mt-3 mb-3 ml-2">
                                BUYERS WHO HAVE PURCHASED PROPOSALS FROM YOU.
                            </h4>

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Buyer Name</th>

                                        <th> Completed Orders </th>

                                        <th> Amount Spent </th>

                                        <th> Last Order </th>

                                        <th>Conversations</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $sel_my_buyers = "select * from my_buyers where seller_id='$login_seller_id'";

                                    $run_my_buyers = mysqli_query($con, $sel_my_buyers);

                                    while ($row_my_buyers = mysqli_fetch_array($run_my_buyers)) {

                                        $buyer_id = $row_my_buyers['buyer_id'];

                                        $completed_orders = $row_my_buyers['completed_orders'];

                                        $amount_spent = $row_my_buyers['amount_spent'];

                                        $last_order_date = $row_my_buyers['last_order_date'];


                                        $select_buyer = "select * from sellers where seller_id='$buyer_id'";

                                        $run_buyer = mysqli_query($con, $select_buyer);

                                        $row_buyer = mysqli_fetch_array($run_buyer);

                                        $buyer_user_name = $row_buyer['seller_user_name'];

                                        $buyer_image = $row_buyer['seller_image'];


                                        ?>

                                        <tr>

                                            <td>

                                                <?php if (!empty($buyer_image)) { ?>

                                                    <img src="user_images/<?php echo $buyer_image; ?>" class="rounded-circle contact-image">

                                                <?php } else { ?>

                                                    <img src="user_images/empty-image.png" class="rounded-circle contact-image">

                                                <?php } ?>

                                                <div class="contact-title">

                                                    <h6> <?php echo $buyer_user_name; ?> </h6>

                                                    <a href="<?php echo $buyer_user_name; ?>" target="blank"> User Profile </a> | <a href="conversations/message.php?seller_id=<?php echo $buyer_id; ?>" target="blank"> History </a>

                                                </div>

                                            </td>

                                            <td><?php echo $completed_orders; ?></td>

                                            <td>₹<?php echo $amount_spent; ?></td>

                                            <td>
                                                <?php echo $last_order_date; ?>
                                            </td>

                                            <td>

                                                <a href="conversations/message.php?seller_id=<?php echo $buyer_id; ?>" target="blank" class="btn btn-success">

                                                    <i class="fa fa-comment"></i>

                                                </a>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table ends -->

                    </div>
                    <!-- my_buyers tab-pane fade show active ends -->


                    <!-- my_sellers tab-pane fade starts -->
                    <div id="my_sellers" class="tab-pane fade">

                        <!-- table-responsive box-table starts -->
                        <div class="table-responsive box-table">

                            <h4 class="mt-3 mb-3 ml-2">
                                SELLERS FROM WHOM YOU HAVE PURCHASED PROPOSALS.
                            </h4>

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Seller Name</th>

                                        <th> Completed Orders </th>

                                        <th> Amount Spent </th>

                                        <th> Last Order </th>

                                        <th>Conversations</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $sel_my_sellers = "select * from my_sellers where buyer_id='$login_seller_id'";

                                    $run_my_sellers = mysqli_query($con, $sel_my_sellers);

                                    while ($row_my_sellers = mysqli_fetch_array($run_my_sellers)) {

                                        $seller_id = $row_my_sellers['seller_id'];

                                        $completed_orders = $row_my_sellers['completed_orders'];

                                        $amount_spent = $row_my_sellers['amount_spent'];

                                        $last_order_date = $row_my_sellers['last_order_date'];


                                        $select_seller = "select * from sellers where seller_id='$seller_id'";

                                        $run_seller = mysqli_query($con, $select_seller);

                                        $row_seller = mysqli_fetch_array($run_seller);

                                        $seller_image = $row_seller['seller_image'];

                                        $seller_user_name = $row_seller['seller_user_name'];


                                        ?>

                                        <tr>

                                            <td>

                                                <?php if (!empty($seller_image)) { ?>

                                                    <img src="user_images/<?php echo $seller_image; ?>" class="rounded-circle contact-image">

                                                <?php } else { ?>

                                                    <img src="user_images/empty-image.png" class="rounded-circle contact-image">

                                                <?php } ?>

                                                <div class="contact-title">

                                                    <h6> <?php echo $seller_user_name; ?> </h6>

                                                    <a href="<?php echo $seller_user_name; ?>" target="blank"> User Profile </a> | <a href="conversations/message.php?seller_id=<?php echo $seller_id; ?>" target="blank"> History </a>

                                                </div>

                                            </td>

                                            <td><?php echo $completed_orders; ?></td>

                                            <td>₹<?php echo $amount_spent; ?></td>

                                            <td>
                                                <?php echo $last_order_date; ?>
                                            </td>

                                            <td>

                                                <a href="conversations/message.php?seller_id=<?php echo $seller_id; ?>" target="blank" class="btn btn-success">

                                                    <i class="fa fa-comment"></i>

                                                </a>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table ends -->

                    </div>
                    <!-- my_sellers tab-pane fade ends -->

                </div><!-- tab-content mt-2 Ends -->

            </div><!-- col-md-12 mt-5 Ends -->

        </div><!-- row Ends -->

    </div><!-- container-fluid Ends -->

    <?php include("includes/footer.php"); ?>


</body>

</html>