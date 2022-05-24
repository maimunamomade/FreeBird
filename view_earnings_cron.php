<?php

include("includes/db.php");

$proposal_views_cron_query = "update proposals set proposal_views='0'";

$run_proposal_views_cron_query = mysqli_query($con,$proposal_views_cron_query);


$month_earnings_cron_query = "update seller_accounts set month_earnings='0'";

$run_month_earnings_cron_query = mysqli_query($con,$month_earnings_cron_query);

?>