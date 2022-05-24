<?php

$con = mysqli_connect("localhost", "root", "", "freebird");

$get_general_settings = "select * from general_settings";

$run_general_settings = mysqli_query($con, $get_general_settings);

$row_general_settings = mysqli_fetch_array($run_general_settings);

$site_url = $row_general_settings["site_url"];
 