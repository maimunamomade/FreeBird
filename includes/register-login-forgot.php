<?php

if (isset($_POST['register'])) {

    $get_general_settings = "select * from general_settings";

    $run_general_settings = mysqli_query($con, $get_general_settings);

    $row_general_settings = mysqli_fetch_array($run_general_settings);

    $referral_money = $row_general_settings['referral_money'];



    $name = mysqli_real_escape_string($con, $_POST['name']);

    $u_name = mysqli_real_escape_string($con, $_POST['u_name']);

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $pass = mysqli_real_escape_string($con, $_POST['pass']);

    $con_pass = mysqli_real_escape_string($con, $_POST['con_pass']);

    $referral = mysqli_real_escape_string($con, $_POST['referral']);

    $regsiter_date = date("F d, Y");

    $date = date("F d, Y");

    $get_seller_username = "select * from sellers where seller_user_name='$u_name'";

    $run_seller_username = mysqli_query($con, $get_seller_username);

    $check_seller_username = mysqli_num_rows($run_seller_username);

    $get_seller_email = "select * from sellers where seller_email='$email'";

    $run_seller_email = mysqli_query($con, $get_seller_email);

    $check_seller_email = mysqli_num_rows($run_seller_email);

    if ($check_seller_username > 0) {

        echo "
		
		<script>
		 alert('This Username Has Been Already Chosen, Please Try Another One.');
		</script>
		
		";
    } else {

        if ($check_seller_email > 0) {

            echo "
		
		<script>
		 alert('This Email Has Been Already Chosen, Please Try Another One.');
		</script>
		
		";
        } else {

            if ($pass != $con_pass) {

                echo "
		
		<script>
		 alert('Your Passwords Don't Match, Please Try Again.');
		</script>
		
		";
            } else {

                $referral_code = mt_rand();

                $verification_code = mt_rand();

                $encrypted_password = password_hash($pass, PASSWORD_DEFAULT);

                $insert_seller = "insert into sellers (seller_name,seller_user_name,seller_email,seller_pass,seller_level,seller_recent_delivery,seller_rating,seller_offers,seller_referral,seller_ip,seller_verification,seller_vacation,seller_register_date,seller_status) values ('$name','$u_name','$email','$encrypted_password','1','none','100','10','$referral_code','$ip','$verification_code','off','$regsiter_date','online')";

                $run_seller = mysqli_query($con, $insert_seller);

                $regsiter_seller_id = mysqli_insert_id($con);

                if ($run_seller) {

                    $_SESSION['seller_user_name'] = $u_name;

                    $insert_seller_account = "insert into seller_accounts (seller_id) values ('$regsiter_seller_id')";

                    $run_seller_account = mysqli_query($con, $insert_seller_account);

                    if (!empty($referral)) {

                        $sel_seller = "select * from sellers where seller_referral='$referral'";

                        $run_seller = mysqli_query($con, $sel_seller);

                        $row_seller = mysqli_fetch_array($run_seller);

                        $seller_id = $row_seller['seller_id'];

                        $seller_ip = $row_seller['seller_ip'];

                        if ($seller_ip == $ip) {

                            echo "<script>alert('You Cannot Reffer Yourself To Make Money.');</script>";
                        } else {

                            $sel_referrals = "select * from referrals where ip='$ip'";

                            $run_referrals = mysqli_query($con, $sel_referrals);

                            $count_referrals = mysqli_num_rows($run_referrals);

                            if ($count_referrals == 1) {

                                echo "<script>alert('You are trying to reffer yourself more than one time.');</script>";
                            } else {

                                $insert_referral = "insert into referrals (seller_id,referred_id,comission,date,ip,status) values ('$seller_id','$regsiter_seller_id','$referral_money','$date','$ip','pending')";

                                $run_referral = mysqli_query($con, $insert_referral);
                            }
                        }
                    }


                    if ($run_seller_account) {

                        echo "
			
			<script>
			 alert('You Have Been Registered Successfully.');
			 window.open('$site_url/index.php','_self');
			</script>
			
			";
                    }
                }
            }
        }
    }
}


if (isset($_POST['login'])) {

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
			
			alert('You Have Successfuly Logged Into Your Account.');
			window.open('$site_url/index.php','_self');
			
			</script>
			
			";
            }
        }
    }
}


if (isset($_POST['forgot'])) {

    $forgot_email = mysqli_real_escape_string($con, $_POST['forgot_email']);

    $select_seller_email = "select * from sellers where seller_email='$forgot_email'";

    $run_seller_email = mysqli_query($con, $select_seller_email);

    $count_seller_email = mysqli_num_rows($run_seller_email);

    if ($count_seller_email == 0) {

        echo "
		
		<script>
		
		alert('Sorry, We Do Not Have Your Email Address.');
		
		</script>
		
		";
    } else {

        $row_seller_email = mysqli_fetch_array($run_seller_email);

        $seller_user_name = $row_seller_email['seller_user_name'];

        $seller_pass = $row_seller_email['seller_pass'];

        $from = "maimunamomade@gmail.com";

        $subject = "!Important FreeBird Forgot Your Password";

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
		
		.lead {
			font-size:16px;
			
		}
		
		.btn{
			background:green;
			margin-top:20px;
			color:white;
			text-decoration:none;
			padding:10px 16px;
			font-size:18px;
			border-radius:3px;
			
		}
		
		hr{
			margin-top:20px;
			margin-bottom:20px;
			border:1px solid #eee;
			
		}
		
		
		</style>
		
		</head>
		
		<body>
		
		<div class='container'>
		
		<div class='box'>
		
		<center>
		
		<img class='logo' src='$site_url/images/logo.png' width='100' >
		
		<h2> Dear $seller_user_name </h2>
		
		<p class='lead'> Are You Ready To Change Your Password. </p>
		
		<br>
		
		<a href='$site_url/change_pass.php?code=$seller_pass' class='btn'>
		 Click Here To Change Your Password 
		</a>
		
		<hr>
		
		<p class='lead'>
		If clicking the button above doesn't work, copy and paste the following url in a new browser window: $site_url/change_pass.php?code=$seller_pass
		</p>
		
		</center>
		
		</div>
		
		</div>
		
		</body>
		
		</html>
		
		";

        $headers = "From: $from\r\n";

        $headers .= "content-type: text/html\r\n";

        mail($forgot_email, $subject, $message, $headers);

        echo "
		
		<script>
		
		alert('An e-mail has been sent to your email address with instructions to change your password.');
		
		window.open('$site_url/index.php','_self');
		
		</script>
		
		";
    }
}
