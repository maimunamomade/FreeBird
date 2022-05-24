<?php

@session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('../login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$proposal_id = $_POST['proposal_id'];

$message = $_POST['message'];

$file = $_POST['file'];

$receiver_id = $_POST['receiver_id'];


$select_proposals = "select * from proposals where proposal_id='$proposal_id'";

$run_proposals = mysqli_query($con, $select_proposals);

$row_proposals = mysqli_fetch_array($run_proposals);

$proposal_title = $row_proposals['proposal_title'];

?>

<!-- modal-content starts -->
<div class="modal-content">

    <!-- modal-header starts -->
    <div class="modal-header">

        <h5 class="modal-title"> Specify Your Proposal Details </h5>

        <button class="close" data-dismiss="modal">
            <span> &times; </span>
        </button>

    </div>
    <!-- modal-header ends -->

    <!-- modal-body p-0 starts -->
    <div class="modal-body p-0">

        <!--- proposal-details-form starts --->
        <form id="proposal-details-form">

            <!--- selected-proposal p-3 starts --->
            <div class="selected-proposal p-3">

                <h5> <?php echo $proposal_title; ?> </h5>

                <hr>

                <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">

                <input type="hidden" name="message" value="<?php echo $message; ?>">

                <input type="hidden" name="file" value="<?php echo $file; ?>">

                <!--- form-group starts --->
                <div class="form-group">

                    <label class="font-weight-bold"> Description : </label>

                    <textarea name="description" class="form-control" required></textarea>

                </div>
                <!--- form-group ends --->

                <hr>

                <!--- form-group starts --->
                <div class="form-group">

                    <label class="font-weight-bold"> Delivery Time : </label>

                    <select class="form-control float-right" name="delivery_time">

                        <option value="1 Day"> 1 Day </option>

                        <option value="2 Days"> 2 Days </option>

                        <option value="3 Days"> 3 Days </option>


                    </select>

                </div>
                <!--- form-group ends --->

                <hr>


                <!--- form-group starts --->
                <div class="form-group">

                    <label class="font-weight-bold"> Total Offer Amount : </label>

                    <div class="input-group float-right">

                        <span class="input-group-addon font-weight-bold"> ₹ </span>

                        <input type="number" name="amount" class="form-control" min="50" placeholder="50 Minimum">

                    </div>

                </div>
                <!--- form-group ends --->


            </div>
            <!--- selected-proposal p-3 ends --->

            <!--- modal-footer Starts --->
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#send-offer-modal">

                    Back

                </button>

                <button type="submit" class="btn btn-success">

                    Submit Offer

                </button>

            </div>
            <!--- modal-footer ends --->

        </form>
        <!--- proposal-details-form ends --->

    </div>
    <!-- modal-body p-0 ends -->

</div>
<!-- modal-content ends -->


<div id="insert_offer"></div>


<script>
    $(document).ready(function() {

        $("#proposal-details-form").submit(function(event) {

            event.preventDefault();

            $.ajax({

                    method: "POST",
                    url: "<?php echo $site_url; ?>/conversations/insert_offer.php",
                    data: $('#proposal-details-form').serialize()

                })

                .done(function(data) {

                    $("#submit-proposal-details").modal('hide');

                    $("#insert_offer").html(data);


                });

        });



    });
</script>