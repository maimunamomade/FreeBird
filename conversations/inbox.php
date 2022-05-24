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


if (isset($_GET['hide_seller'])) {

    $hide_seller_id = $_GET['hide_seller'];

    $hider_seller_messages = "insert into hide_seller_messages (hider_id,hide_seller_id) values ('$login_seller_id','$hide_seller_id')";

    $run_hider_seller_messages = mysqli_query($con, $hider_seller_messages);

    if ($run_hider_seller_messages) {

        echo "<script>window.open('inbox.php','_self')</script>";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Inbox Conversations </title>

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
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mt-5 starts -->
            <div class="col-md-12 mt-5">

                <h2> Inbox Conversations </h2>

                <!-- table-responsive box-table mt-5 starts -->
                <div class="table-responsive box-table mt-5">

                    <h2 class="mt-3 mb-3 ml-3"> All Messages </h2>

                    <!-- table table-hover inbox-conversations starts -->
                    <table class="table table-hover inbox-conversations">

                        <thead>

                            <tr>

                                <th>Sender</th>

                                <th>Last Message</th>

                                <th>Last Updated </th>

                                <th> Delete </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $get_inbox_sellers = "select * from inbox_sellers where sender_id='$login_seller_id' AND NOT message_status='empty' or receiver_id='$login_seller_id' AND NOT message_status='empty'";

                            $run_inbox_sellers = mysqli_query($con, $get_inbox_sellers);

                            while ($row_inbox_sellers = mysqli_fetch_array($run_inbox_sellers)) {

                                $message_sender = $row_inbox_sellers['sender_id'];

                                $message_receiver = $row_inbox_sellers['receiver_id'];

                                $message_id = $row_inbox_sellers['message_id'];

                                $message_status = $row_inbox_sellers['message_status'];

                                $message_group_id = $row_inbox_sellers['message_group_id'];

                                if ($login_seller_id == $message_sender) {

                                    $sender_id = $message_receiver;
                                } else {

                                    $sender_id = $message_sender;
                                }

                                $get_inbox_messages = "select * from inbox_messages where message_id='$message_id'";

                                $run_inbox_messages = mysqli_query($con, $get_inbox_messages);

                                $row_inbox_messages = mysqli_fetch_array($run_inbox_messages);

                                $message_desc = $row_inbox_messages['message_desc'];

                                $message_date = $row_inbox_messages['message_date'];


                                $select_sender = "select * from sellers where seller_id='$sender_id'";

                                $run_sender = mysqli_query($con, $select_sender);

                                $row_sender = mysqli_fetch_array($run_sender);

                                $sender_image = $row_sender['seller_image'];

                                $sender_user_name = $row_sender['seller_user_name'];


                                $select_hide_seller_messages = "select * from hide_seller_messages where hider_id='$login_seller_id' AND hide_seller_id='$sender_id'";

                                $run_hide_seller_messages = mysqli_query($con, $select_hide_seller_messages);

                                $count_hide_seller_messages = mysqli_num_rows($run_hide_seller_messages);


                                ?>

                                <tr <?php

                                    if ($count_hide_seller_messages == 1) {

                                        echo "style='display:none;'";
                                    }

                                    ?> class="
            <?php

            if ($login_seller_id == $message_receiver) {

                if ($message_status == "unread") {

                    echo "table-active";
                }
            }

            ?>
            ">

                                    <td class="inbox-seller">

                                        <?php if (!empty($sender_image)) { ?>

                                            <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle">

                                        <?php } else { ?>

                                            <img src="../user_images/empty-image.png" class="rounded-circle">

                                        <?php } ?>

                                        <h6 class="mb-3">

                                            <a href="insert_message.php?single_message_id=<?php echo $message_group_id; ?>">

                                                <?php echo $sender_user_name; ?>

                                            </a>

                                        </h6>

                                    </td>

                                    <td width="400">

                                        <a href="insert_message.php?single_message_id=<?php echo $message_group_id; ?>">
                                            <?php echo $message_desc; ?>
                                        </a>

                                    </td>

                                    <td> <?php echo $message_date; ?> </td>

                                    <td>

                                        <a href="inbox.php?hide_seller=<?php echo $sender_id; ?>" class="text-white btn btn-danger">

                                            <i class="fa fa-trash-o"></i>

                                        </a>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                    <!-- table table-hover inbox-conversations ends -->

                </div>
                <!-- table-responsive box-table mt-5 ends -->

            </div>
            <!-- col-md-12 mt-5 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

    <?php include("../includes/footer.php"); ?>


</body>

</html>