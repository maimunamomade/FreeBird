<?php

session_start();

include("includes/db.php");

if (isset($_SESSION['seller_user_name'])) {

    echo "<script> window.open('index.php','_self'); </script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Login </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fonts.googleips.com/css?family=Roboto:400,500,700,300.100">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/header.php"); ?>

    <!--- container mt-5 starts -->
    <div class="container mt-5">

        <!--- row justify-content-center Starts -->
        <div class="row justify-content-center">

            <!--- col-lg-5 col-md-7 starts -->
            <div class="col-lg-5 col-md-7">

                <h2 class="text-center"> Login To FreeBird </h2>

                <!--- box-login mt-4 starts -->
                <div class="box-login mt-4">

                    <img class="logo img-fluid rounded mb-3 mt-2" src="images/logo.png">

                    <!--- form Starts -->
                    <form action="" method="post">

                        <!--- form-group starts -->
                        <div class="form-group">

                            <input type="text" name="seller_user_name" placeholder="Username" class="form-control">

                        </div>
                        <!--- form-group ends -->

                        <!--- form-group Starts -->
                        <div class="form-group">

                            <input type="password" name="seller_pass" placeholder="Password" class="form-control">

                        </div>
                        <!--- form-group ends -->

                        <!--- form-group Starts -->
                        <div class="form-group">

                            <input type="submit" name="login" class="btn btn-success btn-block" value="Login">

                        </div>
                        <!--- form-group ends -->

                    </form>
                    <!--- form ends -->

                    <!-- text-center mt-3 starts -->
                    <div class="text-center mt-3">

                        <a href="#" data-toggle="modal" data-target="#register-modal">
                            Register
                        </a>

                        <span class="ml-2 mr-2"> | </span>

                        <a href="#" data-toggle="modal" data-target="#forgot-modal">
                            Forgot Password
                        </a>

                    </div>
                    <!-- text-center mt-3 ends -->

                </div>
                <!--- box-login mt-4 Ends -->

            </div>
            <!--- col-lg-5 col-md-7 Ends -->

        </div>
        <!--- row justify-content-center Ends -->

    </div>
    <!--- container mt-5 ends -->

    <?php

    if (isset($_POST['logged_id'])) {

        $seller_user_name = mysqli_real_escape_string($con, $_POST['seller_user_name']);

        $seller_pass = mysqli_real_escape_string($con, $_POST['seller_pass']);

        $select_seller = "select * from sellers where seller_user_name='$seller_user_name' AND NOT seller_status='deactivated'";

        $run_seller = mysqli_query($con, $select_seller);

        $row_seller = mysqli_fetch_array($run_seller);

        $hashed_password = $row_seller['seller_pass'];

        $seller_status = $row_seller['seller_status'];

        $decrypt_password = password_verify($seller_pass, $hashed_password);

        if ($decrypt_password == 0) {

            echo "
		
		<script>
		
		alert('Password Or Username Is Wrong, Please Try Again.');
		
		</script>
		
		";
        } else {

            if ($seller_status == "block-ban") {

                echo "
			
			<script>
			
			alert('You Have Been Blocked By Admin Please Contact Our Customer Support.');
			window.open('$site_url/index.php','_self');
			
			</script>
			
			";
            } else {

                $select_seller = "select * from sellers where seller_user_name='$seller_user_name' AND seller_pass='$hashed_password'";

                $run_seller = mysqli_query($con, $select_seller);

                if ($run_seller) {

                    $_SESSION['seller_user_name'] = $seller_user_name;

                    $update_seller_status = "update sellers set seller_status='online',seller_ip='$ip' where seller_user_name='$seller_user_name' AND seller_pass='$hashed_password'";

                    $run_seller_status = mysqli_query($con, $update_seller_status);

                    echo "
			
			<script>
			
			alert('You are Logged Into Your Account.');
			window.open('$site_url/index.php','_self');
			
			</script>
			
			";
                }
            }
        }
    }

    ?>


    <?php include("includes/footer.php"); ?>


</body>

</html>