<?php

@session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('login.php','_self')</script>";
}

?>

<h1 class="mb-4"> Account Settings </h1>

<h5 class="mb-4"> Paypal For Withdrawing Revenues </h5>

<!-- form clearfix mb-3 starts -->
<form method="post" class="clearfix mb-3">

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-4 col-form-label"> Enter Paypal Email </label>

        <div class="col-md-8">

            <input type="text" name="seller_paypal_email" value="<?php echo $login_seller_paypal_email; ?>" placeholder="Enter Paypal Email Address Where Your Revenues Should Be Sent To" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <button type="submit" name="submit_paypal_email" class="btn btn-success float-right">

        <i class="fa fa-user-md"></i> Change Paypal Email

    </button>

</form>
<!-- form clearfix mb-3 ends -->

<?php

if (isset($_POST['submit_paypal_email'])) {

    $seller_paypal_email = $_POST['seller_paypal_email'];

    $update_seller = "update sellers set seller_paypal_email='$seller_paypal_email' where seller_id='$login_seller_id'";

    $run_seller = mysqli_query($con, $update_seller);

    if ($run_seller) {

        echo "<script>alert(' Your Paypal Email Address Has Been Updated. ');</script>";

        echo "<script>window.open('settings.php?account_settings','_self')</script>";
    }
}

?>

<hr>

<h5 class="mb-4"> Change Password </h5>

<!-- form clearfix mb-3 starts -->
<form method="post" class="clearfix mb-3">

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-4 col-form-label"> Enter Your Current Password </label>

        <div class="col-md-8">

            <input type="text" name="old_pass" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-4 col-form-label"> Enter Your New Password </label>

        <div class="col-md-8">

            <input type="text" name="new_pass" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <!-- form-group row starts -->
    <div class="form-group row">

        <label class="col-md-4 col-form-label"> Enter Your New Password Again </label>

        <div class="col-md-8">

            <input type="text" name="new_pass_again" class="form-control" required>

        </div>

    </div>
    <!-- form-group row ends -->

    <button type="submit" name="change_password" class="btn btn-success float-right">

        <i class="fa fa-user-md"></i> Change Password

    </button>

</form>
<!-- form clearfix mb-3 ends -->

<?php

if (isset($_POST['change_password'])) {

    $old_pass = $_POST['old_pass'];

    $new_pass = $_POST['new_pass'];

    $new_pass_again = $_POST['new_pass_again'];


    $select_seller = "select * from sellers where seller_id='$login_seller_id'";

    $run_seller = mysqli_query($con, $select_seller);

    $row_seller = mysqli_fetch_array($run_seller);

    $hash_password = $row_seller['seller_pass'];


    $decrypt_password = password_verify($old_pass, $hash_password);


    if ($decrypt_password == 0) {

        echo "<script>alert(' Your Current Password Is Not Valid, Please Try Again. ');</script>";
    } else {

        if ($new_pass != $new_pass_again) {

            echo "<script>alert(' Your New Password dose not match. ');</script>";
        } else {

            $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);

            $update_pass = "update sellers set seller_pass='$encrypted_password' where seller_id='$login_seller_id'";

            $run_pass = mysqli_query($con, $update_pass);

            echo "<script>alert(' Your Password Has Been Successfully Changed, Login Again With New Password. ');</script>";

            echo "<script>window.open('logout.php','_self')</script>";
        }
    }
}


?>

<hr>

<h5 class="mb-1"> ACCOUNT DEACTIVATION </h5>


<!-- list-unstyled mb-3 float-right starts -->
<ul class="list-unstyled mb-3 float-right">

    <li class="lead">

        <strong> What happens when you deactivate your account? </strong>

    </li>

    <li>
        <b class="mr-2"> * </b> Your profile and proposals won't be shown on FreeBird anymore.
    </li>

    <li>
        <b class="mr-2"> * </b> Any open orders will be automatically cancelled and refunded.
    </li>

    <li>
        <b class="mr-2"> * </b> You won't be able to re-activate your proposals.
    </li>

    <li>
        <b class="mr-2"> * </b> You won't be able to restore your account.
    </li>

</ul>
<!-- list-unstyled mb-3 float-right ends -->

<div class="clearfix"></div>

<form method="post">

    <?php

    if (!$current_balance == 0) {

        ?>

        <div class="form-group">
            <!-- form-group Starts -->

            <h5> Please withdraw your revenues before deactivating your account. </h5>

        </div><!-- form-group Ends -->

        <button type="submit" name="deactivate_account" disabled class="btn btn-danger float-right">

            <i class="fa fa-user-md"></i> Deactivate Account

        </button>


    <?php } elseif ($current_balance == 0) { ?>

        <!-- form-group starts -->
        <div class="form-group">


            <label> Why Are You Leaving? </label>

            <select name="deactivate_reason" class="form-control" required>

                <option class="hidden"> Choose A Reason </option>

                <option>
                    The quality of service are less than expected
                </option>

                <option>
                    I have no time to use it
                </option>

                <option>
                    I can’t find what I am looking for
                </option>

                <option>
                    I had a negative experience with a seller / buyer
                </option>

                <option>
                    I found the site difficult to use
                </option>

                <option>
                    The level of customer service was less than expected
                </option>

                <option>
                    I have another FreeBird account
                </option>

                <option>
                    I'm not receiving enough orders
                </option>

                <option>
                    Other
                </option>

            </select>

        </div>
        <!-- form-group ends -->

        <button type="submit" name="deactivate_account" class="btn btn-danger float-right">

            <i class="fa fa-user-md"></i> Deactivate Account

        </button>

    <?php } ?>

</form>

<?php

if (isset($_POST['deactivate_account'])) {

    $update_seller = "update sellers set seller_status='deactivated' where seller_id='$login_seller_id'";

    $run_update_seller = mysqli_query($con, $update_seller);

    if ($run_update_seller) {

        $sel_orders = "select * from orders where seller_id='$login_seller_id' AND order_active='yes'";

        $run_orders = mysqli_query($con, $sel_orders);

        while ($row_orders = mysqli_fetch_array($run_orders)) {

            $order_id = $row_orders['order_id'];

            $seller_id = $row_orders['seller_id'];

            $buyer_id = $row_orders['buyer_id'];

            $order_price = $row_orders['order_price'];

            $notification_date = date("h:i: M d, Y");

            $purchase_date = date("F d, Y");


            $insert_notification = "insert into notifications (receiver_id,sender_id,order_id,reason,date,status) values ('$buyer_id','$seller_id','$order_id','order_cancelled','$notification_date','unread')";

            $run_notification = mysqli_query($con, $insert_notification);

            $insert_purchase = "insert into purchases (seller_id,order_id,amount,date,method) values ('$buyer_id','$order_id','$order_price','$purchase_date','order_cancellation')";

            $run_purchase = mysqli_query($con, $insert_purchase);

            $update_balance = "update seller_accounts set used_purchases=used_purchases-$order_price,current_balance=current_balance+$order_price where seller_id='$buyer_id'";

            $run_update_balance = mysqli_query($con, $update_balance);

            $update_order_status = "update orders set order_status='cancelled',order_active='no' where order_id='$order_id'";

            $run_update_order_status = mysqli_query($con, $update_order_status);
        }

        $pause_proposals = "update proposals set proposal_status='pause' where proposal_seller_id='$login_seller_id'";

        $run_pause_proposals = mysqli_query($con, $pause_proposals);

        unset($_SESSION['seller_user_name']);

        echo "<script>alert(' Your Account Has Been Deactivated ! Good Bye. ');</script>";

        echo "<script>window.open('index.php','_self')</script>";
    }
}


?>