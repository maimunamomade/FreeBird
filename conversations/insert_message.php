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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / fixmywebsite / Conversation with miss_digimarket </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">
    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="../js/jquery.min.js"> </script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <?php

            $single_message_id = $_GET['single_message_id'];

            $update_inbox_sellers = "update inbox_sellers set message_status='read' where receiver_id='$login_seller_id' AND message_status='unread' AND message_group_id='$single_message_id'";

            $run_update_inbox_sellers = mysqli_query($con, $update_inbox_sellers);


            $update_inbox_messages = "update inbox_messages set message_status='read' where message_receiver='$login_seller_id' AND message_status='unread' AND message_group_id='$single_message_id'";

            $run_update_inbox_messages = mysqli_query($con, $update_inbox_messages);


            $get_inbox_sellers = "select * from inbox_sellers where message_group_id='$single_message_id'";

            $run_inbox_sellers = mysqli_query($con, $get_inbox_sellers);

            $row_inbox_sellers = mysqli_fetch_array($run_inbox_sellers);

            $offer_id = $row_inbox_sellers['offer_id'];

            $sender_id = $row_inbox_sellers['sender_id'];

            $receiver_id = $row_inbox_sellers['receiver_id'];


            if ($login_seller_id == $sender_id) {

                $seller_id = $receiver_id;
            } else {

                $seller_id = $sender_id;
            }

            $select_seller = "select * from sellers where seller_id='$seller_id'";

            $run_seller = mysqli_query($con, $select_seller);

            $row_seller = mysqli_fetch_array($run_seller);

            $seller_image = $row_seller['seller_image'];

            $seller_user_name = $row_seller['seller_user_name'];

            $seller_level = $row_seller['seller_level'];

            $seller_vacation = $row_seller['seller_vacation'];

            $seller_recent_delivery = $row_seller['seller_recent_delivery'];

            $seller_rating = $row_seller['seller_rating'];

            $seller_status = $row_seller['seller_status'];


            $get_seller_level = "select * from seller_levels where level_id='$seller_level'";

            $run_seller_level = mysqli_query($con, $get_seller_level);

            $row_seller_level = mysqli_fetch_array($run_seller_level);

            $level_title = $row_seller_level['level_title'];

            ?>

            <!-- col-md-12 mt-5 mb-3 starts -->
            <div class="col-md-12 mt-5 mb-3">

                <!-- row insert-message starts -->
                <div class="row insert-message">

                    <!-- col-md-3 starts -->
                    <div class="col-md-3">

                        <!-- row starts -->
                        <div class="row">

                            <!-- col-lg-5 col-md-12 text-center starts -->
                            <div class="col-lg-5 col-md-12 text-center">

                                <?php if (!empty($seller_image)) { ?>

                                    <img src="../user_images/<?php echo $seller_image; ?>" class="seller-image">

                                <?php } else { ?>

                                    <img src="../user_images/empty-image.png" class="seller-image">

                                <?php } ?>

                                <?php if ($seller_level == 2) { ?>

                                    <img src="../images/level_badge_1.png" class="seller-level-image">

                                <?php } elseif ($seller_level == 3) { ?>

                                    <img src="../images/level_badge_2.png" class="seller-level-image">

                                <?php } elseif ($seller_level == 4) { ?>

                                    <img src="../images/level_badge_3.png" class="seller-level-image">

                                <?php } ?>
                            </div>
                            <!-- col-lg-5 col-md-12 text-center ends -->


                            <!-- col-lg-7 col-md-12 mt-lg-0 mt-3 text-lg-left text-center starts -->
                            <div class="col-lg-7 col-md-12 mt-lg-0 mt-3 text-lg-left text-center">

                                <h4>
                                    <a href="../<?php echo $seller_user_name; ?>" target="blank">
                                        <?php echo $seller_user_name; ?>
                                    </a>
                                </h4>

                                <p> <?php echo $level_title; ?> </p>

                            </div>
                            <!-- col-lg-7 col-md-12 mt-lg-0 mt-3 text-lg-left text-center snds -->

                        </div>
                        <!-- row ends -->

                    </div>
                    <!-- col-md-3 ends -->


                    <!-- col-md-9 responsive-border mt-lg-0 mt-3 text-md-left text-center starts -->
                    <div class="col-md-9 responsive-border mt-lg-0 mt-3 text-md-left text-center">

                        <p class="p-style mt-md-0 mt-3">

                            <i class="fa fa-clock-o"></i> Recent Delivery <b>

                                <?php

                                if ($seller_recent_delivery == "none") {

                                    echo "No Orders Delivered Yet.";
                                } else {

                                    echo $seller_recent_delivery;
                                }

                                ?>

                            </b>

                        </p>

                        <p class="p-style">

                            <i class="fa fa-comments-o"></i> Speaks

                            <?php

                            $sel_languages_relation = "select * from languages_relation where seller_id='$seller_id'";

                            $run_languages_relation = mysqli_query($con, $sel_languages_relation);

                            $count_languages_relation = mysqli_num_rows($run_languages_relation);

                            if (!$count_languages_relation == 0) {

                                while ($row_languages_relation = mysqli_fetch_array($run_languages_relation)) {

                                    $language_id = $row_languages_relation['language_id'];

                                    $language_level = $row_languages_relation['language_level'];


                                    $get_seller_languages = "select * from seller_languages where language_id='$language_id'";

                                    $run_seller_languages = mysqli_query($con, $get_seller_languages);

                                    $row_seller_languages = mysqli_fetch_array($run_seller_languages);

                                    $language_title = $row_seller_languages['language_title'];

                                    ?>

                                    <b>
                                        <?php echo $language_title; ?>
                                    </b>
                                    (<?php echo $language_level; ?>)

                                <?php

                            }
                        }

                        ?>

                        </p>

                        <p class="p-style">

                            <i class="fa fa-smile-o"></i>
                            Positive Ratings
                            <b> <?php echo $seller_rating; ?>% </b>

                        </p>

                    </div>
                    <!-- col-md-9 responsive-border mt-lg-0 mt-3 text-md-left text-center ends -->

                </div>
                <!-- row insert-message ends -->

            </div>
            <!-- col-md-12 mt-5 mb-3 ends -->


            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <!-- display-request starts -->
                <div id="display-request">

                    <?php

                    if (!empty($offer_id)) {

                        $select_offers = "select * from send_offers where offer_id='$offer_id'";

                        $run_offers = mysqli_query($con, $select_offers);

                        $row_offers = mysqli_fetch_array($run_offers);

                        $request_id = $row_offers['request_id'];

                        $proposal_id = $row_offers['proposal_id'];

                        $description = $row_offers['description'];

                        $delivery_time = $row_offers['delivery_time'];

                        $amount = $row_offers['amount'];


                        $get_requests = "select * from buyer_requests where request_id='$request_id'";

                        $run_requests = mysqli_query($con, $get_requests);

                        $row_requests = mysqli_fetch_array($run_requests);

                        $request_description = $row_requests['request_description'];


                        $select_proposals = "select * from proposals where proposal_id='$proposal_id'";

                        $run_proposals = mysqli_query($con, $select_proposals);

                        $row_proposals = mysqli_fetch_array($run_proposals);

                        $proposal_title = $row_proposals['proposal_title'];

                        ?>

                        <!-- request-div starts -->
                        <div class="request-div">

                            <h5>

                                THIS MESSAGE IS RELATED TO THE FOLLOWING REQUEST:
                                <span class="btn-close float-right">x</span>

                            </h5>

                            <p>
                                "<?php echo $request_description; ?>"
                            </p>

                            <span class="arrow">
                                View Offer <i class="fa fa-caret-down"></i>
                            </span>

                        </div>
                        <!-- request-div ends -->


                        <!-- offer-div starts -->
                        <div class="offer-div">

                            <h5>
                                <?php echo $proposal_title; ?>
                                <span class="price float-right">
                                    ₹<?php echo $amount; ?>
                                </span>
                            </h5>

                            <p>
                                <?php echo $description; ?>
                            </p>

                            <p>
                                <strong>
                                    <i class="fa fa-clock-o"></i>
                                    Delivery Time:
                                </strong>
                                <?php echo $delivery_time; ?>
                            </p>

                        </div>
                        <!-- offer-div ends -->


                        <script>
                            $(".offer-div").hide();

                            $(".arrow").click(function() {

                                $(".offer-div").slideToggle();

                            });

                            $(".btn-close").click(function() {

                                $(".request-div").fadeOut().remove();

                                $(".offer-div").fadeOut().remove();

                            });
                        </script>

                    <?php } ?>

                </div>
                <!-- display-request ends -->


                <!-- display-messages starts -->
                <div id="display-messages" class="bg-white">

                    <?php include("display_messages.php") ?>

                </div>
                <!-- display-messages ends -->


                <?php if ($seller_vacation == "on") { ?>

                    <!-- seller-vacation-div starts -->
                    <div id="seller-vacation-div">

                        <h3> <?php echo $seller_user_name; ?> </h3>

                        <p class="lead">

                            You Can Not Send A Message. This Person Is On Vacation Mode.

                        </p>

                    </div>
                    <!-- seller-vacation-div ends -->

                <?php } elseif ($seller_vacation == "off") { ?>


                    <!-- insert-message-box starts -->
                    <div class="insert-message-box">

                        <div class="float-right">

                            <p class="text-muted mt-1">

                                <?php echo $seller_user_name; ?>

                                <span class="text-success"> <?php echo ucfirst($seller_status); ?> </span>

                                | Local Time

                                <i class="fa fa-clock-o"></i>

                                <?php

                                date_default_timezone_set("Asia/Kolkata");

                                echo date("h:i A");

                                ?>
                            </p>

                        </div>

                        <!-- insert-message-form starts -->
                        <form id="insert-message-form">

                            <textarea class="form-control mb-2" rows="5" id="message" placeholder="Type your Message Here..."></textarea>

                            <button type="submit" class="btn btn-success ml-2 float-right">
                                Send
                            </button>

                            <button type="button" id="send-offer" class="btn btn-success float-right">
                                Create An Offer
                            </button>

                        </form>
                        <!-- insert-message-form ends -->

                        <div class="clearfix"></div>

                        <p class="mt-lg-0 mt-2 mb-0">

                            <span class="font-weight-bold"> Accepted File Formats: </span>

                            jpeg, jpg, gif, png, tif, avi, mpeg, mpg, mov, rm, 3gp, flv, mp4, zip, rar, mp3, wav

                        </p>

                        <!-- form-row align-items-center message-attacment starts -->
                        <div class="form-row align-items-center message-attacment">

                            <label class="h6 ml-2 mt-1"> Attach File (optional) </label>

                            <input type="file" id="file" class="form-control-file p-1 mb-2 mb-sm-0">

                        </div>
                        <!-- form-row align-items-center message-attacment ends -->

                    </div>
                    <!-- insert-message-box ends -->

                <?php } ?>

            </div>
            <!-- col-md-12 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

    <div id="upload_file_div"></div>

    <div id="accept-offer-div"></div>

    <div id="send-offer-div"></div>


    <script>
        $(document).ready(function() {

            $("#send-offer").click(function() {

                receiver_id = "<?php echo $seller_id; ?>";

                message = $("#message").val();

                file = $("#file").val();

                if (file == "") {
                    message_file = file;
                } else {
                    message_file = document.getElementById("file").files[0].name;
                }



                $.ajax({
                    method: 'POST',
                    url: 'send_offer_modal.php',
                    data: {
                        receiver_id: receiver_id,
                        message: message,
                        file: message_file
                    }
                }).done(function(data) {

                    $("#send-offer-div").html(data);

                });

            });

            single_message_id = <?php echo $single_message_id; ?>;


            $(document).on('change', '#file', function() {

                var form_data = new FormData();

                form_data.append("file", document.getElementById('file').files[0]);

                $.ajax({

                    url: "upload_file.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,


                }).done(function(data) {

                    $("#upload_file_div").empty();

                    $("#upload_file_div").append(data);


                });

            });


            $('#insert-message-form').submit(function(e) {

                e.preventDefault();

                message = $('#message').val();

                if (message == "") {


                } else {

                    file = $('#file').val();

                    if (file == "") {

                        message_file = file;

                    } else {

                        message_file = document.getElementById("file").files[0].name;


                    }

                    $.ajax({

                        method: "POST",

                        url: "insert_inbox_message.php",

                        data: {
                            single_message_id: single_message_id,
                            message: message,
                            file: message_file
                        },

                        success: function(data) {

                            $('#message').val('');

                            $('#file').val('');

                        }

                    });


                }


            });



            setInterval(function() {

                $.ajax({

                        method: "GET",
                        url: "display_messages.php",
                        data: {
                            single_message_id: single_message_id
                        }

                    })
                    .done(function(data) {

                        $('#display-messages').empty();

                        $('#display-messages').append(data);

                    });


            }, 1000);



        });
    </script>

    <?php include("../includes/footer.php"); ?>


</body>

</html>