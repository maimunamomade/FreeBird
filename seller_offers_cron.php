<?php

include("includes/db.php");

$seller_offers_cron_query = "update sellers set seller_offers='10'";

$run_seller_offers_cron_query = mysqli_query($con,$seller_offers_cron_query);

?>