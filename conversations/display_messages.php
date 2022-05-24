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

?>

<?php

$single_message_id = $_GET['single_message_id'];


$get_inbox_messages = "select * from inbox_messages where message_group_id='$single_message_id'";

$run_inbox_messages = mysqli_query($con, $get_inbox_messages);

while ($row_inbox_messages = mysqli_fetch_array($run_inbox_messages)) {

    $message_id = $row_inbox_messages['message_id'];

    $message_sender = $row_inbox_messages['message_sender'];

    $message_desc = $row_inbox_messages['message_desc'];

    $message_date = $row_inbox_messages['message_date'];

    $message_file = $row_inbox_messages['message_file'];

    $message_offer_id = $row_inbox_messages['message_offer_id'];


    if (!$message_offer_id == 0) {

        $select_offer = "select * from messages_offers where offer_id='$message_offer_id'";

        $run_offer = mysqli_query($con, $select_offer);

        $row_offer = mysqli_fetch_array($run_offer);

        $sender_id = $row_offer['sender_id'];

        $proposal_id = $row_offer['proposal_id'];

        $description = $row_offer['description'];

        $order_id = $row_offer['order_id'];

        $delivery_time = $row_offer['delivery_time'];

        $amount = $row_offer['amount'];

        $offer_status = $row_offer['status'];

        $select_proposals = "select * from proposals where proposal_id='$proposal_id'";

        $run_proposals = mysqli_query($con, $select_proposals);

        $row_proposals = mysqli_fetch_array($run_proposals);

        $proposal_title = $row_proposals['proposal_title'];

        $proposal_img1 = $row_proposals['proposal_img1'];
    }


    $select_sender = "select * from sellers where seller_id='$message_sender'";

    $run_sender = mysqli_query($con, $select_sender);

    $row_sender = mysqli_fetch_array($run_sender);

    $sender_image = $row_sender['seller_image'];

    $sender_user_name = $row_sender['seller_user_name'];


    ?>

    <!-- message-div-hover starts -->
    <div class="
                                <?php

                                if ($login_seller_id == $message_sender) {

                                    echo "message-div-hover";
                                } else {

                                    echo "message-div";
                                }

                                ?>
                                ">

        <?php if (!empty($sender_image)) { ?>

            <img src="../user_images/<?php echo $sender_image; ?>" class="message-image">

        <?php } else { ?>

            <img src="../user_images/empty-image.png" class="message-image">

        <?php } ?>

        <h5> <?php echo $sender_user_name; ?> </h5>

        <p class="message-desc">

            <?php echo $message_desc; ?>

            <?php if (!empty($message_file)) { ?>

                <a href="conversations_files/<?php echo $message_file; ?>" download class="d-block mt-2 ml-1">
                    <i class="fa fa-download"></i> <?php echo $message_file; ?>
                </a>

            <?php } else { ?>


            <?php } ?>

        </p>

        <?php if (!$message_offer_id == 0) { ?>

            <!-- message-offer starts -->
            <div class="message-offer">

                <!-- row starts -->
                <div class="row">

                    <!-- col-lg-2 col-md-3 starts -->
                    <div class="col-lg-2 col-md-3">

                        <img src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">

                    </div>
                    <!-- col-lg-2 col-md-3 ends -->

                    <!-- col-lg-10 col-md-9 starts -->
                    <div class="col-lg-10 col-md-9">

                        <h5 class="mt-md-0 mt-2">

                            <?php echo $proposal_title; ?>

                            <span class="price float-right d-sm-block d-none"> ₹<?php echo $amount; ?> </span>

                        </h5>

                        <p> <?php echo $description; ?> </p>

                        <p class="d-block d-sm-none"> <b> Price / Amount : </b> <?php echo $amount; ?> </p>

                        <p> <b> Delivery Time : </b> <?php echo $delivery_time; ?> </p>

                        <?php if ($offer_status == "active") { ?>

                            <?php if ($login_seller_id == $sender_id) { ?>


                            <?php } else { ?>

                                <button id="accept-offer-<?php echo $message_offer_id; ?>" class="btn btn-success rounded-0 float-right">

                                    Accept Offer | Order Now

                                </button>


                                <script>
                                    $("#accept-offer-<?php echo $message_offer_id; ?>").click(function() {

                                        single_message_id = "<?php echo $single_message_id; ?>";

                                        offer_id = "<?php echo $message_offer_id; ?>";

                                        $.ajax({

                                                method: "POST",

                                                url: "accept_offer_modal.php",

                                                data: {
                                                    single_message_id: single_message_id,
                                                    offer_id: offer_id
                                                }

                                            })
                                            .done(function(data) {

                                                $("#accept-offer-div").html(data);

                                            });


                                    });
                                </script>

                            <?php } ?>


                        <?php } elseif ($offer_status == "accepted") { ?>

                            <button class="btn btn-success rounded-0 mt-2 float-right" disabled>

                                Offer Accepted

                            </button>

                            <a href="../order_details.php?order_id=<?php echo $order_id; ?>" class="mt-3 mr-3 float-right">

                                View Order

                            </a>

                        <?php } ?>

                    </div>
                    <!-- col-lg-10 col-md-9 ends -->

                </div>
                <!-- row ends -->

            </div>
            <!-- message-offer ends -->

        <?php } ?>
        <p class="text-right text-muted mb-0"> <?php echo $message_date; ?> </p>

    </div>
    <!-- message-div-hover ends -->

<?php } ?>