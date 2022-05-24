<!--- card rounded-0 mb-3 starts --->
<div class="card rounded-0 mb-3">

    <!-- card-body starts -->
    <div class="card-body">

        <h3> Hi, <?php echo $login_seller_name; ?> </h3>

        <p> Request the service you are looking for. </p>

        <a class="btn btn-success btn-block" href="requests/post_request.php" target="blank">
            Post A Request
        </a>

    </div>
    <!-- card-body ends -->

</div>
<!--- card rounded-0 mb-3 ends --->

<!--- card rounded-0 mb-3 starts --->
<div class="card rounded-0 mb-3">

    <!--- card-header starts --->
    <div class="card-header">

        <h5> BUY IT AGAIN </h5>

    </div>
    <!--- card-header ends --->

    <!--- card-body starts --->
    <div class="card-body">

        <?php

        $select_orders = "select DISTINCT proposal_id from orders where buyer_id='$login_seller_id' AND order_status='completed' order by 1 DESC LIMIT 0,4";

        $run_orders = mysqli_query($con, $select_orders);

        while ($row_orders = mysqli_fetch_array($run_orders)) {

            $proposal_id = $row_orders['proposal_id'];

            $get_proposals = "select * from proposals where proposal_id='$proposal_id' AND proposal_status='active'";

            $run_proposals = mysqli_query($con, $get_proposals);

            $row_proposals = mysqli_fetch_array($run_proposals);

            $proposal_title = $row_proposals['proposal_title'];

            $proposal_img1 = $row_proposals['proposal_img1'];

            $proposal_url = $row_proposals['proposal_url'];

            ?>

        <!--- row mb-3 Starts --->
        <div class="row mb-3">

            <img class="col-lg-4 col-md-12 col-sm-4 col-4 img-fluid user-home-img-responsive" src="proposals/proposal_files/<?php echo $proposal_img1; ?>">

            <p class="col-lg-8 col-md-12 col-sm-8 col-8 user-home-title-responsive">

                <a href="proposals/<?php echo $proposal_url; ?>">
                    <?php echo $proposal_title; ?>
                </a>

            </p>

        </div>
        <!--- row mb-3 ends --->

        <?php 
    } ?>

    </div>
    <!--- card-body ends --->

</div>
<!--- card rounded-0 mb-3 ends --->


<!--- card rounded-0 mb-3 starts --->
<div class="card rounded-0 mb-3">

    <!--- card-header starts --->
    <div class="card-header">

        <h5> RECENTELY VIEWED </h5>
        <!--- card-header Ends --->

    </div>

    <!--- card-body starts --->
    <div class="card-body">

        <?php

        $select_recent = "select * from recent_proposals where seller_id='$login_seller_id' order by 1 DESC LIMIT 0,4";

        $run_recent = mysqli_query($con, $select_recent);

        while ($row_recent = mysqli_fetch_array($run_recent)) {

            $proposal_id = $row_recent['proposal_id'];

            $get_proposals = "select * from proposals where proposal_id='$proposal_id' AND proposal_status='active'";

            $run_proposals = mysqli_query($con, $get_proposals);

            $row_proposals = mysqli_fetch_array($run_proposals);

            $proposal_title = $row_proposals['proposal_title'];

            $proposal_img1 = $row_proposals['proposal_img1'];

            $proposal_url = $row_proposals['proposal_url'];

            ?>

        <!--- row mb-3 Starts --->
        <div class="row mb-3">

            <img class="col-lg-4 col-md-12 col-sm-4 col-4 img-fluid user-home-img-responsive" src="proposals/proposal_files/<?php echo $proposal_img1; ?>">

            <p class="col-lg-8 col-md-12 col-sm-8 col-8 user-home-title-responsive">

                <a href="proposals/<?php echo $proposal_url; ?>">
                    <?php echo $proposal_title; ?>
                </a>

            </p>

        </div>
        <!--- row mb-3 ends --->

        <?php 
    } ?>

    </div>
    <!--- card-body ends --->

</div>
<!--- card rounded-0 mb-3 ends ---> 