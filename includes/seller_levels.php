<?php

$seller_user_name = $_SESSION['seller_user_name'];

$select_seller = "select * from sellers where seller_user_name='$seller_user_name'";

$run_seller = mysqli_query($con, $select_seller);

$row_seller = mysqli_fetch_array($run_seller);

$seller_id = $row_seller['seller_id'];

$seller_level = $row_seller['seller_level'];

$seller_rating = $row_seller['seller_rating'];

$select_orders = "select * from orders where seller_id='$seller_id' AND order_status='completed'";


$run_orders = mysqli_query($con, $select_orders);

$count_orders = mysqli_num_rows($run_orders);

$select_general_settings = "select * from general_settings";

$run_general_settings = mysqli_query($con, $select_general_settings);

$row_general_settings = mysqli_fetch_array($run_general_settings);

$level_one_rating = $row_general_settings['level_one_rating'];

$level_one_orders = $row_general_settings['level_one_orders'];

$level_two_rating = $row_general_settings['level_two_rating'];

$level_two_orders = $row_general_settings['level_two_orders'];

$level_top_rating = $row_general_settings['level_top_rating'];

$level_top_orders = $row_general_settings['level_top_orders'];

?>


<?php 

if ($seller_level == 1) {

    if ($seller_rating >= $level_one_rating and $count_orders >= $level_one_orders) {

        $update_seller_level = "update sellers set seller_level='2' where seller_id='$seller_id'";

        $run_seller_level = mysqli_query($con, $update_seller_level);

        $update_proposals_level = "update proposals set level_id='2' where proposal_seller_id='$seller_id'";

        $run_proposals_level = mysqli_query($con, $update_proposals_level);

        if ($run_seller_level) {

            ?>

<!-- level-one-modal modal fade starts -->
<div id="level-one-modal" class="modal fade">

    <!-- modal-dialog starts -->
    <div class="modal-dialog">

        <!-- modal-content starts -->
        <div class="modal-content">

            <!-- modal-header starts -->
            <div class="modal-header">

                <h5 class="modal-title"> Level One Promoted </h5>

                <button class="close" data-dismiss="modal">
                    <span> &times; </span>
                </button>

            </div>
            <!-- modal-header ends -->

            <!-- modal-body text-center starts -->
            <div class="modal-body text-center">

                <h2> Bombastic </h2>

                <p class="lead">
                    We Have Some Bombastic News For You!<br>
                    You've Become a Level One Seller
                </p>

                <img src="images/level_badge_1.png">

            </div>
            <!-- modal-body text-center ends -->

            <!-- modal-footer starts -->
            <div class="modal-footer">

                <button class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

            </div>
            <!-- modal-footer ends -->

        </div>
        <!-- modal-content ends -->

    </div>
    <!-- modal-dialog ends -->

</div>
<!-- level-one-modal modal fade ends -->

<script>
    $(document).ready(function() {


        $("#level-one-modal").modal('show');

    });
</script>

<?php

}
}
}

?>

<?php 

if ($seller_level == 2) {

    if ($seller_rating >= $level_two_rating and $count_orders >= $level_two_orders) {

        $update_seller_level = "update sellers set seller_level='3' where seller_id='$seller_id'";

        $run_seller_level = mysqli_query($con, $update_seller_level);

        $update_proposals_level = "update proposals set level_id='3' where proposal_seller_id='$seller_id'";

        $run_proposals_level = mysqli_query($con, $update_proposals_level);

        if ($run_seller_level) {

            ?>


<!-- level-two-modal modal fade starts -->
<div id="level-two-modal" class="modal fade">

    <!-- modal-dialog starts -->
    <div class="modal-dialog">

        <!-- modal-content starts -->
        <div class="modal-content">

            <!-- modal-header starts -->
            <div class="modal-header">

                <h5 class="modal-title"> Level Two Promoted </h5>

                <button class="close" data-dismiss="modal">
                    <span> &times; </span>
                </button>

            </div>
            <!-- modal-header ends -->

            <!-- modal-body text-center starts -->
            <div class="modal-body text-center">

                <h2> Awesome </h2>

                <p class="lead">
                    We Have Some Awesome News For You!<br>
                    You've Become a Level Two Seller.
                </p>

                <img src="images/level_badge_2.png">

            </div>
            <!-- modal-body text-center ends -->

            <!-- modal-footer starts -->
            <div class="modal-footer">

                <button class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

            </div>
            <!-- modal-footer ends -->

        </div>
        <!-- modal-content ends -->

    </div>
    <!-- modal-dialog ends -->

</div>
<!-- level-two-modal modal fade ends -->

<script>
    $(document).ready(function() {


        $("#level-two-modal").modal('show');

    });
</script>

<?php

}
}
}

?>

<?php 

if ($seller_level == 3) {

    if ($seller_rating >= $level_top_rating and $count_orders >= $level_top_orders) {

        $update_seller_level = "update sellers set seller_level='4' where seller_id='$seller_id'";

        $run_seller_level = mysqli_query($con, $update_seller_level);

        $update_proposals_level = "update proposals set level_id='4' where proposal_seller_id='$seller_id'";

        $run_proposals_level = mysqli_query($con, $update_proposals_level);

        if ($run_seller_level) {

            ?>

<!-- top-rated-modal modal fade starts -->
<div id="top-rated-modal" class="modal fade">

    <!-- modal-dialog starts -->
    <div class="modal-dialog">

        <!-- modal-content starts -->
        <div class="modal-content">

            <!-- modal-header starts -->
            <div class="modal-header">

                <h5 class="modal-title"> Top Rated Promoted </h5>

                <button class="close" data-dismiss="modal">
                    <span> &times; </span>
                </button>

            </div>
            <!-- modal-header ends -->

            <!-- modal-body text-center starts -->
            <div class="modal-body text-center">

                <h2> Fantastic </h2>

                <p class="lead">
                    We Have Some Fantastic News For You!<br>
                    You've Become a Top Rated Seller
                </p>

                <img src="images/level_badge_3.png">

            </div>
            <!-- modal-body text-center ends -->

            <!-- modal-footer starts -->
            <div class="modal-footer">

                <button class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

            </div>
            <!-- modal-footer ends -->

        </div>
        <!-- modal-content ends -->

    </div>
    <!-- modal-dialog ends -->

</div>
<!-- top-rated-modal modal fade ends -->

<script>
    $(document).ready(function() {

        $("#top-rated-modal").modal('show');

    });
</script>

<?php

}
}
}

?> 