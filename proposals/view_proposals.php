<?php

session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('../login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_vacation = $row_login_seller['seller_vacation'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / View Proposals </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="FreeBird is a revolutionary service for independent entrepeneurs to focus on growth and create sucessful business at affordable cost">
    <meta name="keywords" content="freebird, freelance, freelancer, jobs, buyers, sellers, proposals, requests">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="../styles/owl.carousel.css" rel="stylesheet">
    <link href="../styles/owl.theme.default.css" rel="stylesheet">
    <script src="../js/jquery.min.js"> </script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <!-- container-fluid view-proposals starts -->
    <div class="container-fluid view-proposals">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mt-5 mb-3 starts -->
            <div class="col-md-12 mt-5 mb-3">

                <h1 class="pull-left"> View Proposals </h1>

                <!-- pull-right lead starts -->
                <label class="pull-right lead">

                    Vacation Mode

                    <?php if ($login_seller_vacation == "off") { ?>

                        <button id="turn_on_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle">

                            <div class="toggle-handle bg-info"></div>

                        </button>

                    <?php } else { ?>

                        <button id="turn_off_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle active">

                            <div class="toggle-handle bg-info"></div>

                        </button>

                    <?php } ?>

                </label>
                <!-- pull-right lead ends -->

                <script>
                    $(document).ready(function() {


                        $(document).on('click', '#turn_on_seller_vaction', function() {

                            seller_id = "<?php echo $login_seller_id; ?>";

                            $.ajax({

                                method: "POST",

                                url: "seller_vacation.php",

                                data: {
                                    seller_id: seller_id,
                                    turn_on: 'on'
                                }

                            }).done(function() {

                                $("#turn_on_seller_vaction").attr('id', 'turn_off_seller_vaction');

                                alert('Your Seller Vacation Mode Has Been Turned On');

                            });

                        });


                        $(document).on('click', '#turn_off_seller_vaction', function() {

                            seller_id = "<?php echo $login_seller_id; ?>";

                            $.ajax({

                                method: "POST",

                                url: "seller_vacation.php",

                                data: {
                                    seller_id: seller_id,
                                    turn_off: 'off'
                                }

                            }).done(function() {

                                $("#turn_off_seller_vaction").attr('id', 'turn_on_seller_vaction');

                                alert('Your Seller Vacation Mode Has Been Turned Off');

                            });

                        });

                    });
                </script>

            </div>
            <!-- col-md-12 mt-5 mb-3 ends -->


            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <a href="create_proposal.php" class="btn btn-success pull-right">
                    Add New Proposal
                </a>

                <div class="clearfix"></div>

                <!-- nav nav-tabs mt-3 starts -->
                <ul class="nav nav-tabs mt-3">

                    <?php

                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='active'";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    $count_proposals = mysqli_num_rows($run_proposals);

                    ?>

                    <li class="nav-item">

                        <a href="#active-proposals" data-toggle="tab" class="nav-link active">

                            Active
                            <span class="badge badge-success">
                                <?php echo $count_proposals; ?>
                            </span>

                        </a>

                    </li>

                    <?php

                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='pause'";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    $count_proposals = mysqli_num_rows($run_proposals);

                    ?>

                    <li class="nav-item">

                        <a href="#pause-proposals" data-toggle="tab" class="nav-link">

                            Paused
                            <span class="badge badge-success">
                                <?php echo $count_proposals; ?>
                            </span>

                        </a>

                    </li>

                    <?php

                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='pending'";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    $count_proposals = mysqli_num_rows($run_proposals);

                    ?>

                    <li class="nav-item">

                        <a href="#pending-proposals" data-toggle="tab" class="nav-link">

                            Pending Approval
                            <span class="badge badge-success">
                                <?php echo $count_proposals; ?>
                            </span>

                        </a>

                    </li>

                    <?php

                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='modification'";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    $count_proposals = mysqli_num_rows($run_proposals);

                    ?>

                    <li class="nav-item">

                        <a href="#modification-proposals" data-toggle="tab" class="nav-link">

                            Requires Modification
                            <span class="badge badge-success">
                                <?php echo $count_proposals; ?>
                            </span>

                        </a>

                    </li>

                </ul>
                <!-- nav nav-tabs mt-3 ends -->

                <!-- tab-content starts -->
                <div class="tab-content">

                    <!-- active-proposals tab-pane fade show active starts -->
                    <div id="active-proposals" class="tab-pane fade show active">

                        <!-- table-responsive box-table mt-4 starts -->
                        <div class="table-responsive box-table mt-4">

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Proposal Title</th>

                                        <th>Proposal Price </th>

                                        <th>Views</th>

                                        <th>Orders</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='active'";

                                    $run_proposals = mysqli_query($con, $select_proposals);

                                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                                        $proposal_id = $row_proposals['proposal_id'];

                                        $proposal_title = $row_proposals['proposal_title'];

                                        $proposal_views = $row_proposals['proposal_views'];

                                        $proposal_price = $row_proposals['proposal_price'];

                                        $proposal_img1 = $row_proposals['proposal_img1'];

                                        $proposal_url = $row_proposals['proposal_url'];

                                        $proposal_featured = $row_proposals['proposal_featured'];

                                        $select_orders = "select * from orders where proposal_id='$proposal_id'";

                                        $run_orders = mysqli_query($con, $select_orders);

                                        $count_orders = mysqli_num_rows($run_orders);

                                        ?>

                                        <tr>

                                            <td class="proposal-title">
                                                <?php echo $proposal_title; ?>
                                            </td>

                                            <td class="text-success">
                                                ₹<?php echo $proposal_price; ?>
                                            </td>

                                            <td><?php echo $proposal_views; ?></td>

                                            <td><?php echo $count_orders; ?></td>

                                            <td>

                                                <!-- dropdown Starts -->
                                                <div class="dropdown">

                                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>

                                                    <!-- dropdown-menu Starts -->
                                                    <div class="dropdown-menu">

                                                        <a href="<?php echo $proposal_url; ?>" class="dropdown-item">
                                                            Preview
                                                        </a>

                                                        <?php if ($proposal_featured == "no") { ?>

                                                            <a href="#" class="dropdown-item" id="featured-button-<?php echo $proposal_id; ?>">
                                                                Featured Listing
                                                            </a>

                                                        <?php } else { ?>

                                                            <a href="#" class="dropdown-item bg-success active">
                                                                Already Featured
                                                            </a>

                                                        <?php } ?>

                                                        <a href="pause_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Pause
                                                        </a>

                                                        <a href="edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Edit
                                                        </a>

                                                        <a href="delete_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Delete
                                                        </a>

                                                    </div>
                                                    <!-- dropdown-menu Ends -->

                                                </div>
                                                <!-- dropdown Ends -->

                                                <script>
                                                    $("#featured-button-<?php echo $proposal_id; ?>").click(function() {

                                                        proposal_id = "<?php echo $proposal_id; ?>";

                                                        $.ajax({
                                                                method: "POST",
                                                                url: "pay_featured_listing.php",
                                                                data: {
                                                                    proposal_id: proposal_id
                                                                }
                                                            })
                                                            .done(function(data) {

                                                                $("#featured-proposal-modal").html(data);

                                                            });


                                                    });
                                                </script>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table mt-4 ends -->

                    </div><!-- active-proposals tab-pane fade show active ends -->


                    <!-- pause-proposals tab-pane fade show  starts -->
                    <div id="pause-proposals" class="tab-pane fade show">

                        <!-- table-responsive box-table mt-4 starts -->
                        <div class="table-responsive box-table mt-4">

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Proposal Title</th>

                                        <th>Proposal Price </th>

                                        <th>Views</th>

                                        <th>Orders</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='pause'";

                                    $run_proposals = mysqli_query($con, $select_proposals);

                                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                                        $proposal_id = $row_proposals['proposal_id'];

                                        $proposal_title = $row_proposals['proposal_title'];

                                        $proposal_views = $row_proposals['proposal_views'];

                                        $proposal_price = $row_proposals['proposal_price'];

                                        $proposal_img1 = $row_proposals['proposal_img1'];

                                        $proposal_url = $row_proposals['proposal_url'];

                                        $proposal_featured = $row_proposals['proposal_featured'];

                                        $select_orders = "select * from orders where proposal_id='$proposal_id'";

                                        $run_orders = mysqli_query($con, $select_orders);

                                        $count_orders = mysqli_num_rows($run_orders);

                                        ?>

                                        <tr>

                                            <td class="proposal-title">
                                                <?php echo $proposal_title; ?>
                                            </td>

                                            <td class="text-success">
                                                ₹<?php echo $proposal_price; ?>
                                            </td>

                                            <td><?php echo $proposal_views; ?></td>

                                            <td><?php echo $count_orders; ?></td>

                                            <td>

                                                <!-- dropdown Starts -->
                                                <div class="dropdown">

                                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>

                                                    <!-- dropdown-menu Starts -->
                                                    <div class="dropdown-menu">

                                                        <a href="<?php echo $proposal_url; ?>" class="dropdown-item">
                                                            Preview
                                                        </a>

                                                        <a href="activate_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Activate
                                                        </a>

                                                        <a href="edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Edit
                                                        </a>

                                                        <a href="delete_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Delete
                                                        </a>

                                                    </div>
                                                    <!-- dropdown-menu Ends -->

                                                </div>
                                                <!-- dropdown Ends -->

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table mt-4 ends -->

                    </div>
                    <!-- pause-proposals tab-pane fade show ends -->


                    <!-- pending-proposals tab-pane fade show  starts -->
                    <div id="pending-proposals" class="tab-pane fade show">

                        <!-- table-responsive box-table mt-4 starts -->
                        <div class="table-responsive box-table mt-4">

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Proposal Title</th>

                                        <th>Proposal Price </th>

                                        <th>Views</th>

                                        <th>Orders</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='pending'";

                                    $run_proposals = mysqli_query($con, $select_proposals);

                                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                                        $proposal_id = $row_proposals['proposal_id'];

                                        $proposal_title = $row_proposals['proposal_title'];

                                        $proposal_views = $row_proposals['proposal_views'];

                                        $proposal_price = $row_proposals['proposal_price'];

                                        $proposal_img1 = $row_proposals['proposal_img1'];

                                        $proposal_url = $row_proposals['proposal_url'];

                                        $proposal_featured = $row_proposals['proposal_featured'];

                                        $select_orders = "select * from orders where proposal_id='$proposal_id'";

                                        $run_orders = mysqli_query($con, $select_orders);

                                        $count_orders = mysqli_num_rows($run_orders);

                                        ?>

                                        <tr>

                                            <td class="proposal-title">
                                                <?php echo $proposal_title; ?>
                                            </td>

                                            <td class="text-success">
                                                ₹<?php echo $proposal_price; ?>
                                            </td>

                                            <td><?php echo $proposal_views; ?></td>

                                            <td><?php echo $count_orders; ?></td>

                                            <td>

                                                <!-- dropdown Starts -->
                                                <div class="dropdown">

                                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>

                                                    <!-- dropdown-menu Starts -->
                                                    <div class="dropdown-menu">

                                                        <a href="<?php echo $proposal_url; ?>" class="dropdown-item">
                                                            Preview
                                                        </a>

                                                        <a href="edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Edit
                                                        </a>

                                                        <a href="delete_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Delete
                                                        </a>

                                                    </div>
                                                    <!-- dropdown-menu Ends -->

                                                </div>
                                                <!-- dropdown Ends -->

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table mt-4 ends -->

                    </div>
                    <!-- pending-proposals tab-pane fade show ends -->


                    <!-- modification-proposals tab-pane fade show  starts -->
                    <div id="modification-proposals" class="tab-pane fade show">

                        <!-- table-responsive box-table mt-4 starts -->
                        <div class="table-responsive box-table mt-4">

                            <!-- table table-hover starts -->
                            <table class="table table-hover">

                                <thead>

                                    <tr>

                                        <th>Modification Proposal</th>

                                        <th>Modification Message</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

                                    $select_proposals = "select * from proposals where proposal_seller_id='$login_seller_id' and proposal_status='modification'";

                                    $run_proposals = mysqli_query($con, $select_proposals);

                                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                                        $proposal_id = $row_proposals['proposal_id'];

                                        $proposal_title = $row_proposals['proposal_title'];

                                        $proposal_url = $row_proposals['proposal_url'];


                                        $select_modification = "select * from proposal_modifications where proposal_id='$proposal_id'";

                                        $run_modification = mysqli_query($con, $select_modification);

                                        $row_modification = mysqli_fetch_array($run_modification);

                                        $modification_message = $row_modification['modification_message'];


                                        ?>

                                        <tr>

                                            <td class="proposal-title"> <?php echo $proposal_title; ?> </td>

                                            <td> <?php echo $modification_message; ?> </td>

                                            <td>

                                                <!-- dropdown starts -->
                                                <div class="dropdown">

                                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>

                                                    <!-- dropdown-menu Starts -->
                                                    <div class="dropdown-menu">

                                                        <a href="submit_approval.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Submit For Approval
                                                        </a>

                                                        <a href="<?php echo $proposal_url; ?>" class="dropdown-item">
                                                            Preview
                                                        </a>

                                                        <a href="edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Edit
                                                        </a>

                                                        <a href="delete_proposal.php?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item">
                                                            Delete
                                                        </a>

                                                    </div>
                                                    <!-- dropdown-menu Ends -->

                                                </div>
                                                <!-- dropdown Ends -->

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>
                            <!-- table table-hover ends -->

                        </div>
                        <!-- table-responsive box-table mt-4 ends -->

                    </div>
                    <!-- modification-proposals tab-pane fade show ends -->

                </div>
                <!-- tab-content ends -->

            </div>
            <!-- col-md-12 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid view-proposals ends -->

    <div id="featured-proposal-modal"></div>


    <?php include("../includes/footer.php"); ?>


</body>

</html>