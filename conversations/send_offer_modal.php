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

$receiver_id = $_POST['receiver_id'];

$message = $_POST['message'];

$file = $_POST['file'];

?>

<!-- send-offer-modal modal fade starts -->
<div id="send-offer-modal" class="modal fade">

    <!-- modal-dialog starts -->
    <div class="modal-dialog">

        <!-- modal-content starts -->
        <div class="modal-content">

            <!-- modal-header starts -->
            <div class="modal-header">

                <h5 class="modal-title"> Select A Proposal To Offer </h5>

                <button class="close" data-dismiss="modal">

                    <span> &times; </span>

                </button>

            </div>
            <!-- modal-header ends -->

            <!-- modal-body p-0 starts -->
            <div class="modal-body p-0">

                <!--- request-proposals-list starts --->
                <div class="request-proposals-list">

                    <?php

                    $select_proposals = "select * from proposals where proposal_status='active' AND proposal_seller_id='$login_seller_id'";

                    $run_proposals = mysqli_query($con, $select_proposals);

                    while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                        $proposal_id = $row_proposals['proposal_id'];

                        $proposal_title = $row_proposals['proposal_title'];

                        $proposal_img1 = $row_proposals['proposal_img1'];

                        ?>

                        <!--- proposal-picture starts --->
                        <div class="proposal-picture">

                            <input type="radio" id="radio-<?php echo $proposal_id; ?>" class="radio-custom" name="proposal_id" value="<?php echo $proposal_id; ?>" required>

                            <label for="radio-<?php echo $proposal_id; ?>" class="radio-custom-label"> </label>

                            <img src="<?php echo $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" width="50" height="50">

                        </div>
                        <!--- proposal-picture ends --->


                        <!--- proposal-title starts --->
                        <div class="proposal-title">
                            <p><?php echo $proposal_title; ?></p>
                        </div>
                        <!--- proposal-title ends --->

                        <hr>

                    <?php } ?>

                </div>
                <!--- request-proposals-list ends --->

            </div>
            <!-- modal-body p-0 ends -->


            <!--- modal-footer starts --->
            <div class="modal-footer">

                <button class="btn btn-dark" data-dismiss="modal"> Close </button>

                <button id="submit-proposal" class="btn btn-info" data-toggle="modal" data-dismiss="modal" data-target="#submit-proposal-details">
                    Go Next
                </button>

            </div>
            <!--- modal-footer ends --->

        </div>
        <!-- modal-content ends -->

    </div>
    <!-- modal-dialog ends -->

</div>
<!-- send-offer-modal modal fade ends -->

<!--- modal fade starts --->
<div id="submit-proposal-details" class="modal fade">

    <!--- modal-dialog starts --->
    <div class="modal-dialog">

    </div>
    <!--- modal-dialog ends --->

</div>
<!--- modal fade ends --->

<textarea id="message" class="d-none"> <?php echo $message; ?> </textarea>

<script>
    $(document).ready(function() {

        $("#send-offer-modal").modal('show');

        $("#submit-proposal").attr("disabled", "disabled");

        $(".radio-custom-label").click(function() {

            $("#submit-proposal").removeAttr("disabled");

        });


        $("#submit-proposal").click(function() {

            proposal_id = document.querySelector('input[name="proposal_id"]:checked').value;

            receiver_id = "<?php echo $receiver_id; ?>";

            message = $("#message").val();

            file = "<?php echo $file; ?>";



            $.ajax({

                    method: "POST",

                    url: "<?php echo $site_url; ?>/conversations/submit_proposal_details.php",

                    data: {
                        proposal_id: proposal_id,
                        receiver_id: receiver_id,
                        message: message,
                        file: file
                    }

                })

                .done(function(data) {

                    $("#submit-proposal-details .modal-dialog").html(data);

                });


        });

    });
</script>