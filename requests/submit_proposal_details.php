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

$proposal_id = $_POST['proposal_id'];

$request_id = $_POST['request_id'];


$get_requests = "select * from buyer_requests where request_id='$request_id'";

$run_requests = mysqli_query($con, $get_requests);

$row_requets = mysqli_fetch_array($run_requests);

$request_title = $row_requets['request_title'];

$request_description = $row_requets['request_description'];

$request_seller_id = $row_requets['seller_id'];


$select_request_seller = "select * from sellers where seller_id='$request_seller_id'";

$run_requets_seller = mysqli_query($con, $select_request_seller);

$row_requets_seller = mysqli_fetch_array($run_requets_seller);

$request_seller_image = $row_requets_seller['seller_image'];


$get_proposals = "select * from proposals where proposal_status='active' AND proposal_seller_id='$login_seller_id' AND proposal_id='$proposal_id'";

$run_proposals = mysqli_query($con, $get_proposals);

$row_proposals = mysqli_fetch_array($run_proposals);

$proposal_title = $row_proposals['proposal_title'];

?>

<!--- modal-content starts --->
<div class="modal-content">

    <!--- modal-header starts --->
    <div class="modal-header">

        <h5 class="modal-title h5"> Specify Your Proposal Details </h5>

        <button class="close" data-dismiss="modal"> &times; </button>

    </div>
    <!--- modal-header ends --->


    <!--- modal-body p-0 starts --->
    <div class="modal-body p-0">

        <!--- request-summary starts --->
        <div class="request-summary">

            <?php if (!empty($request_seller_image)) { ?>

            <img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">

            <?php 
        } else { ?>

            <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="rounded-circle">

            <?php 
        } ?>

            <!--- request-description starts --->
            <div id="request-description">

                <h6 class="text-primary mb-1"> <?php echo $request_title; ?> </h6>

                <p> <?php echo $request_description; ?> </p>

            </div>
            <!--- request-description ends --->

        </div>
        <!--- request-summary ends --->


        <!--- proposal-details-form starts --->
        <form id="proposal-details-form">

            <!--- selected-proposal p-3 starts --->
            <div class="selected-proposal p-3">

                <h5> <?php echo $proposal_title; ?> </h5>

                <hr>

                <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

                <input type="hidden" name="request_id" value="<?php echo $request_id; ?>">

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

                        <?php 

                        $get_delivery_times = "select * from delivery_times";

                        $run_delivery_times = mysqli_query($con, $get_delivery_times);

                        while ($row_delivery_times = mysqli_fetch_array($run_delivery_times)) {

                            $delivery_proposal_title = $row_delivery_times['delivery_proposal_title'];

                            echo "<option value='$delivery_proposal_title'> $delivery_proposal_title </option>";
                        }

                        ?>

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

            <!--- modal-footer starts --->
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
    <!--- modal-body p-0 ends --->

</div>
<!--- modal-content ends --->


<div id="insert_offer"></div>


<script>
    $(document).ready(function() {

        $("#proposal-details-form").submit(function(event) {

            event.preventDefault();

            $.ajax({

                    method: "POST",
                    url: "<?php echo $site_url; ?>/requests/insert_offer.php",
                    data: $('#proposal-details-form').serialize()

                })

                .done(function(data) {

                    $("#submit-proposal-details").modal('hide');

                    $("#insert_offer").html(data);


                });

        });

    });
</script> 