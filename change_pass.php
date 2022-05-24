<?php

session_start();

include("includes/db.php");

if (isset($_SESSION['seller_user_name'])) {

    echo " <script> window.open('index.php','_self'); <script> ";
}

$code = $_GET['code'];

$select_seller = "select * from sellers where seller_pass='$code'";

$run_seller = mysqli_query($con, $select_seller);

$count_seller = mysqli_num_rows($run_seller);

if ($count_seller == 0) {

    echo "
	
	<script>
	
	alert('Your Change Password Link Is Invalid.');
	
	window.open('index.php','_self');
	
	</script>
	
	
	";
}

$row_seller = mysqli_fetch_array($run_seller);

$seller_id = $row_seller['seller_id'];

$seller_user_name = $row_seller['seller_user_name'];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Change Password </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>

    <?php include("includes/header.php"); ?>

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mt-5 mb-5 starts -->
            <div class="col-md-12 mt-5 mb-5">

                <!-- card change-pass starts -->
                <div class="card change-pass">

                    <!-- card-header text-center starts -->
                    <div class="card-header text-center">

                        <h3> Change Your Password </h3>

                    </div>
                    <!-- card-header text-center ends -->

                    <!-- card-body d-flex justify-content-center starts -->
                    <div class="card-body d-flex justify-content-center">

                        <!-- col-md-8 starts -->
                        <form method="post" class="col-md-8">

                            <!-- form-group starts -->
                            <div class="form-group">
                                <label> Enter Your New Password </label>

                                <!-- input-group starts -->
                                <div class="input-group">

                                    <!-- input-group-addon starts -->
                                    <span class="input-group-addon">

                                        <i class="fa fa-check tick1 text-success"> </i>
                                        <i class="fa fa-times cross1 text-danger"> </i>

                                    </span>
                                    <!-- input-group-addon ends -->

                                    <input type="password" name="new_pass" id="password" class="form-control" required>

                                    <!-- input-group-addon starts -->
                                    <span class="input-group-addon">

                                        <!-- meter_wrapper starts -->
                                        <div id="meter_wrapper">

                                            <span id="pass_type"> </span>

                                            <div id="meter"> </div>

                                        </div>
                                        <!-- meter_wrapper ends -->

                                    </span>
                                    <!-- input-group-addon ends -->

                                </div>
                                <!-- input-group ends -->

                            </div>
                            <!-- form-group ends -->


                            <!-- form-group starts -->
                            <div class="form-group">

                                <label> Confirm Your New Password </label>

                                <!-- input-group starts -->
                                <div class="input-group">

                                    <!-- input-group-addon starts -->
                                    <span class="input-group-addon">

                                        <i class="fa fa-check tick2 text-success"> </i>
                                        <i class="fa fa-times cross2 text-danger"> </i>

                                    </span>
                                    <!-- input-group-addon ends -->

                                    <input type="password" name="new_pass_again" id="confirm_password" class="form-control" required>

                                </div>
                                <!-- input-group ends -->

                            </div>
                            <!-- form-group ends -->


                            <!-- text-center starts -->
                            <div class="text-center">

                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fa fa-user-md"> Change Password </i>
                                </button>

                            </div>
                            <!-- text-center ends -->

                        </form>
                        <!-- col-md-8 ends -->

                    </div>
                    <!-- card-body d-flex justify-content-center ends -->

                </div>
                <!-- card change-pass ends -->

            </div>
            <!-- col-md-12 mt-5 mb-5 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

    <?php

    if (isset($_POST['submit'])) {

        $new_pass = $_POST['new_pass'];

        $new_pass_again = $_POST['new_pass_again'];

        if ($new_pass != $new_pass_again) {

            echo "
		
		<script>
		 alert('Your New Passwords Don't Match, Please Try Again.');
		</script>
		
		";
        } else {

            $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);

            $upadte_password = "update sellers set seller_pass='$encrypted_password' where seller_id='$seller_id'";

            $run_password = mysqli_query($con, $upadte_password);

            if ($run_password) {

                echo "
		
		<script>
		
		alert('Your Password Has Been Successfully Changed.');
		
		window.open('login.php','_self');
		
		</script>
		
		";
            }
        }
    }

    ?>

    <?php include("includes/footer.php"); ?>

    <!--- Password Strength checker code starts  --->

    <script>
        $(document).ready(function() {

            $("#password").keyup(function() {

                check_pass();

            });

        });

        function check_pass() {

            var val = document.getElementById("password").value;

            var meter = document.getElementById("meter");

            var no = 0;

            if (val != "") {

                // If the password length is less than or equal to 6
                if (val.length <= 6) no = 1;

                // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
                if (val.length > 6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))) no = 2;

                // If the password length is greater than 6 and contain alphabet,number,special character respectively
                if (val.length > 6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) no = 3;

                // If the password length is greater than 6 and must contain alphabets,numbers and special characters
                if (val.length > 6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) no = 4;

                if (no == 1) {

                    $("#meter").animate({
                        width: '50px'
                    }, 300);

                    meter.style.backgroundColor = "red";

                    document.getElementById("pass_type").innerHTML = "Very Weak";

                }

                if (no == 2) {

                    $("#meter").animate({
                        width: '100px'
                    }, 300);

                    meter.style.backgroundColor = "#F5BCA9";

                    document.getElementById("pass_type").innerHTML = "Weak";

                }

                if (no == 3) {

                    $("#meter").animate({
                        width: '150px'
                    }, 300);

                    meter.style.backgroundColor = "#FF8000";

                    document.getElementById("pass_type").innerHTML = "Good";

                }

                if (no == 4) {

                    $("#meter").animate({
                        width: '200px'
                    }, 300);

                    meter.style.backgroundColor = "#00FF40";

                    document.getElementById("pass_type").innerHTML = "Strong";

                }

            } else {

                meter.style.backgroundColor = "";

                document.getElementById("pass_type").innerHTML = "";

            }

        }
    </script>

    <!--- Password Strength checker code Ends  --->



    <!--- Tick and Cross code starts  --->

    <script>
        $(document).ready(function() {

            $('.tick1').hide();

            $('.cross1').hide();

            $('.tick2').hide();

            $('.cross2').hide();

            $('#confirm_password').focusout(function() {

                var password = $('#password').val();

                var confirmPassword = $('#confirm_password').val();

                if (password == confirmPassword) {

                    $('.tick1').show();

                    $('.cross1').hide();

                    $('.tick2').show();

                    $('.cross2').hide();

                } else {

                    $('.tick1').hide();

                    $('.cross1').show();

                    $('.tick2').hide();

                    $('.cross2').show();

                }

            });

        });
    </script>



    <!--- Tick and Cross code Ends  --->

</body>

</html>