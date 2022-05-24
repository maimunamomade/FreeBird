<?php

session_start();

include("includes/db.php");

if (isset($_SESSION['seller_user_name'])) {

    $login_seller_user_name = $_SESSION['seller_user_name'];

    $select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

    $run_login_seller = mysqli_query($con, $select_login_seller);

    $row_login_seller = mysqli_fetch_array($run_login_seller);

    $login_seller_id = $row_login_seller['seller_id'];

    $login_seller_email = $row_login_seller['seller_email'];

    $login_seller_user_name = $row_login_seller['seller_user_name'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird - Customer Support </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="FreeBird is a revolutionary service for independent entrepeneurs to focus on growth and create sucessful business at affordable cost">
    <meta name="keywords" content="freebird, freelance, freelancer, jobs, buyers, sellers, proposals, requests">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleips.com/css?family=Roboto:400,500,700,300.100">

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/header.php"); ?>


    <div class="container">
        <!-- container Starts -->

        <div class="row">
            <!-- row Starts -->

            <div class="col-md-12 mt-4">
                <!-- col-md-12 mt-4 Starts -->

                <?php if (!isset($_SESSION['seller_user_name'])) { ?>

                    <div class="alert alert-warning rounded-0">
                        <!--- alert alert-warning rounded-0 Starts -->

                        <p class="lead mt-1 mb-1">

                            <strong> Warning ! </strong>

                            You can not submit a support request, without logging in to this website.

                        </p>

                    </div>
                    <!--- alert alert-warning rounded-0 Ends -->

                <?php
            } ?>

            </div><!-- col-md-12 mt-4 Ends -->

        </div><!-- row Ends -->


        <div class="row">
            <!--- row Starts --->

            <div class="col-md-12">
                <!--- col-md-12 Starts -->

                <div class="card">
                    <!-- card Starts -->

                    <?php

                    $get_contact_support = "select * from contact_support";

                    $run_contact_support = mysqli_query($con, $get_contact_support);

                    $row_contact_support = mysqli_fetch_array($run_contact_support);

                    $contact_heading = $row_contact_support['contact_heading'];

                    $contact_desc = $row_contact_support['contact_desc'];


                    ?>

                    <div class="card-header text-center ">
                        <!--- card-header text-center  Starts --->

                        <h2> <?php echo $contact_heading; ?> </h2>

                        <p class="text-muted">

                            <?php echo $contact_desc; ?>

                        </p>

                    </div>
                    <!--- card-header text-center Ends --->

                    <div class="card-body">
                        <!-- card-body Starts -->

                        <center>
                            <!--- center Starts --->

                            <form class="col-md-8 contact-form" action="contact.php" method="post" enctype="multipart/form-data">
                                <!--- col-md-8 contact-form Starts -->

                                <div class="form-group">
                                    <!--- form-group Starts -->

                                    <label class="float-left"> Select Enquiry Type </label>

                                    <select name="enquiry_type" class="form-control select_tag" required>
                                        <!--- form-control select_tag Starts -->

                                        <option value="" url="contact.php"> Select Enquiry </option>

                                        <?php

                                        if (isset($_GET['enquiry_id'])) {

                                            $enquiry_id = $_GET['enquiry_id'];

                                            $get_enquiry_type = "select * from enquiry_types where enquiry_id='$enquiry_id'";

                                            $run_enquiry_type = mysqli_query($con, $get_enquiry_type);

                                            $row_enquiry_type = mysqli_fetch_array($run_enquiry_type);

                                            $enquiry_title = $row_enquiry_type['enquiry_title'];

                                            echo "
	
	<option value='$enquiry_id' url='contact.php?enquiry_id=$enquiry_id' selected>
	
	$enquiry_title
	
	</option>
	
	";
                                        }

                                        if (isset($_GET['enquiry_id'])) {

                                            $get_enquiry_type = "select * from enquiry_types where not enquiry_id='$enquiry_id'";
                                        } else {

                                            $get_enquiry_type = "select * from enquiry_types";
                                        }

                                        $run_enquiry_type = mysqli_query($con, $get_enquiry_type);

                                        while ($row_enquiry_types = mysqli_fetch_array($run_enquiry_type)) {


                                            $enquiry_id = $row_enquiry_types['enquiry_id'];

                                            $enquiry_title = $row_enquiry_types['enquiry_title'];

                                            echo "
	
	<option value='$enquiry_id' url='contact.php?enquiry_id=$enquiry_id'>
	
	$enquiry_title
	
	</option>
	
	";
                                        }

                                        ?>

                                    </select>
                                    <!--- form-control select_tag Ends -->

                                </div>
                                <!--- form-group Ends -->

                                <?php if (isset($_GET['enquiry_id'])) { ?>

                                    <div class="form-group">
                                        <!--- form-group Starts -->

                                        <label class="float-left"> Subject * </label>

                                        <input type="text" class="form-control" name="subject" required>

                                    </div>
                                    <!--- form-group Ends -->


                                    <div class="form-group">
                                        <!--- form-group Starts -->

                                        <label class="float-left"> Message * </label>

                                        <textarea class="form-control" rows="6" name="message" required>

    </textarea>

                                    </div>
                                    <!--- form-group Ends -->

                                    <?php if ($_GET['enquiry_id'] == 1 or $_GET['enquiry_id'] == 2) { ?>

                                        <div class="form-group">
                                            <!--- form-group Starts -->

                                            <label class="float-left"> Order Number * </label>

                                            <input type="text" class="form-control" name="order_number" required>

                                        </div>
                                        <!--- form-group Ends -->


                                        <div class="form-group">
                                            <!--- form-group Starts -->

                                            <label class="float-left"> Order Rule * </label>

                                            <select name="order_rule" class="form-control " required>
                                                <!--- form-control Starts -->

                                                <option value="" class="hidden"> Select Order Rule </option>

                                                <option> Buyer </option>

                                                <option> Seller </option>

                                            </select>
                                            <!--- form-control Ends -->

                                        </div>
                                        <!--- form-group Ends -->

                                    <?php
                                } ?>

                                    <div class="form-group">
                                        <!--- form-group Starts -->

                                        <label class="float-left"> Attachment </label>

                                        <input type="file" class="form-control" name="file">

                                    </div>
                                    <!--- form-group Ends -->


                                    <div class="form-group">
                                        <!--- form-group Starts -->

                                        <label> Please Verify That You Are Human </label>

                                        <div class="g-recaptcha" data-sitekey="6Lfm940UAAAAALl6sL8v5PDRPch97wQSFQd6cPs-"></div>

                                    </div>
                                    <!--- form-group Ends -->

                                    <div class="text-center">
                                        <!-- text-center Starts -->

                                        <button type="submit" name="submit" class="btn btn-primary btn-lg">

                                            <i class="fa fa-user-md"></i> Send Message

                                        </button>

                                    </div><!-- text-center Ends -->

                                <?php
                            } ?>

                            </form>
                            <!--- col-md-8 contact-form Ends -->

                        </center>
                        <!--- center Ends --->

                    </div><!-- card-body Ends -->

                </div><!-- card Ends -->

            </div>
            <!--- col-md-12 Ends -->

        </div>
        <!--- row Ends --->




    </div><!-- container Ends -->

    <?php

    if (isset($_POST['submit'])) {

        if (!isset($_SESSION['seller_user_name'])) {

            echo "

<script>
alert('You can not submit a support request, without logging into this website.');
</script>

<script>
window.open('login.php','_self')
</script>

";

            exit();
        } else {

            $secret_key = "6Lfm940UAAAAAEP06L0LbQy1jbwd7RRrLLCWNf6f";

            $response = $_POST['g-recaptcha-response'];

            $remote_ip = $_SERVER['REMOTE_ADDR'];

            $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remote_ip");

            $result = json_decode($url, true);

            if ($result["success"] == 1) {

                $enquiry_type = mysqli_real_escape_string($con, $_POST['enquiry_type']);

                $subject = mysqli_real_escape_string($con, $_POST['subject']);

                $message = mysqli_real_escape_string($con, $_POST['message']);

                if ($enquiry_type == 1 or $enquiry_type == 2) {

                    $order_number = mysqli_real_escape_string($con, $_POST['order_number']);

                    $order_rule = mysqli_real_escape_string($con, $_POST['order_rule']);
                } else {

                    $order_number = "";

                    $order_rule = "";
                }

                $file = $_FILES['file']['name'];

                $file_tmp = $_FILES['file']['tmp_name'];

                move_uploaded_file($file_tmp, "ticket_files/$file");

                $date = date("h:i M d, Y");

                $insert_support_ticket = "insert into support_tickets (enquiry_id,sender_id,subject,message,order_number,order_rule,attachment,date,status) values ('$enquiry_type','$login_seller_id','$subject','$message','$order_number','$order_rule','$file','$date','open')";

                $run_support_ticket = mysqli_query($con, $insert_support_ticket);

                if ($run_support_ticket) {

                    $select_enquiry_type = "select * from enquiry_types where enquiry_id='$enquiry_type'";

                    $run_enquiry_type = mysqli_query($con, $select_enquiry_type);

                    $row_enquiry_type = mysqli_fetch_array($run_enquiry_type);

                    $enquiry_title = $row_enquiry_type['enquiry_title'];

                    // Send Email To Admin Code Starts

                    if (!empty($file)) {

                        $email_message = "


<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
}

.box {
	background: #fff;
	margin: 0px 0px 30px;
	padding: 8px 20px 20px 20px;
	border:1px solid #e6e6e6;
	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	
}


hr{
	margin-top:20px;
	margin-bottom:20px;
	border:1px solid #eee;
	
}

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}

</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img class='logo' src='$site_url/images/logo.png' width='100' >

<h2> Hello FreeBird Administrator </h2>

<h2> This Message Has been Sent From Submit A Request Form </h2>

</center>

<hr>

<table class='table'>

<thead>

<tr>

<th> Enquiry Type </th>

<th> Email Address </th>

<th> Subject </th>

<th> Message </th>

<th> Attachment </th>

<th> Sender Username </th>

</tr>

</thead>

<tbody>

<tr>

<td> $enquiry_title </td>

<td> $login_seller_email </td>

<td> $subject </td>

<td> $message </td>

<td> $file </td>

<td> $login_seller_user_name </td>

</tr>

</tbody>

</table>

</div>

</div>

</body>

</html>



";
                    } else {

                        $email_message = "


<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
}

.box {
	background: #fff;
	margin: 0px 0px 30px;
	padding: 8px 20px 20px 20px;
	border:1px solid #e6e6e6;
	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	
}

hr{
	margin-top:20px;
	margin-bottom:20px;
	border:1px solid #eee;
	
}

.table {
	
max-width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img class='logo' src='$site_url/images/logo.png' width='100' >

<h2> Hello FreeBird Administrator </h2>

<h2> This Message Has been Sent From Submit A Request Form </h2>

</center>

<hr>

<table class='table'>

<thead>

<tr>

<th> Enquiry Type </th>

<th> Email Address </th>

<th> Subject </th>

<th> Message </th>

<th> Sender Username </th>

</tr>

</thead>

<tbody>

<tr>

<td> $enquiry_title </td>

<td> $login_seller_email </td>

<td> $subject </td>

<td> $message </td>

<td> $login_seller_user_name </td>

</tr>

</tbody>

</table>

</div>

</div>

</body>

</html>



";
                    }

                    $headers = "From: FreeBird.com\r\n";

                    $headers .= "Reply-To: $login_seller_email\r\n";

                    $headers .= "Content-Type: text/html\r\n";

                    $get_contact_support = "select * from contact_support";

                    $run_contact_support = mysqli_query($con, $get_contact_support);

                    $row_contact_support = mysqli_fetch_array($run_contact_support);

                    $contact_email = $row_contact_support['contact_email'];

                    mail($contact_email, $subject, $email_message, $headers);

                    // Send Email To Admin Code Ends


                    /// Send Email To Sender Code Starts 

                    $subject = "Welcome To FreeBird Dear $login_seller_user_name";

                    $message = "

<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
}

.box {
	background: #fff;
	margin: 0px 0px 30px;
	padding: 8px 20px 20px 20px;
	border:1px solid #e6e6e6;
	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	
}

hr{
	margin-top:20px;
	margin-bottom:20px;
	border:1px solid #eee;
	
}

.lead {
	
	font-size:16px;
	
}

</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/logo.png' width='100'>

<h2> Hi $login_seller_user_name, Welcome To FreeBird </h2>

<p class='lead'> Thanks For Contacting Us. </p>

<hr>

<p class='lead'>

We Shall Contact You Soon, Thanks For Using Our Customer Support.

</p>

</center>

</div>

</div>

</body>

</html>

";

                    $headers = "From: FreeBird.com\r\n";

                    $headers .= "Reply-To: $contact_email\r\n";

                    $headers .= "Content-Type: text/html\r\n";

                    mail($login_seller_email, $subject, $message, $headers);

                    /// Send Email To Sender Code Ends 	

                    echo "

<script>

alert(' Your Message Has Been Successfully Sent, We Shall Contact You Soon. ');

</script>

";
                }
            } else {

                echo "

<script>

alert('Please Select Captcha, And Try Again.');

</script>

";
            }
        }
    }


    ?>

    <?php include("includes/footer.php"); ?>

    <script>
        $(document).ready(function() {

            $(".select_tag").change(function() {

                url = $(".select_tag option:selected").attr('url');


                window.location.href = url;


            });


        });
    </script>

</body>

</html>