<?php

@session_start();

include("db.php");

$get_featured_proposals = "select * from featured_proposals";

$run_featured_proposals = mysqli_query($con, $get_featured_proposals);

while ($row_featured_proposals = mysqli_fetch_array($run_featured_proposals)) {

    $featured_id = $row_featured_proposals['featured_id'];

    $featured_proposal_id = $row_featured_proposals['proposal_id'];

    $end_date = $row_featured_proposals['end_date'];

    $current_date = date("F d, Y h:i:s");

    if ($current_date >= $end_date) {

        $update_proposal = "update proposals set proposal_featured='no' where proposal_id='$featured_proposal_id'";

        $run_proposal = mysqli_query($con, $update_proposal);

        $delete_featured_proposal = "delete from featured_proposals where featured_id='$featured_id'";

        $run_delete = mysqli_query($con, $delete_featured_proposal);
    }
}


if (isset($_SESSION['seller_user_name'])) {

    $login_seller_user_name = $_SESSION['seller_user_name'];

    $select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

    $run_login_seller = mysqli_query($con, $select_login_seller);

    $row_login_seller = mysqli_fetch_array($run_login_seller);

    $login_seller_id = $row_login_seller['seller_id'];


    $get_revenues = "select * from revenues where seller_id='$login_seller_id' AND status='pending' order by 1 DESC";

    $run_revenues = mysqli_query($con, $get_revenues);

    while ($row_revenues = mysqli_fetch_array($run_revenues)) {

        $revenue_id = $row_revenues['revenue_id'];

        $amount = $row_revenues['amount'];

        $end_date = $row_revenues['end_date'];

        date_default_timezone_set("UTC");

        $current_date = date("F d, Y h:i:s");

        if ($current_date >= $end_date) {

            $update_seller_accounts = "update seller_accounts set pending_clearance=pending_clearance-$amount,current_balance=current_balance+$amount where seller_id='$login_seller_id'";

            $run_seller_accounts = mysqli_query($con, $update_seller_accounts);


            $update_revenues = "update revenues set status='cleared' where revenue_id='$revenue_id'";

            $update_run_revenues = mysqli_query($con, $update_revenues);
        }
    }
}
