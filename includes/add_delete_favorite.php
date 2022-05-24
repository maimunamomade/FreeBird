<?php

session_start();

include("db.php");

if (isset($_SESSION['seller_user_name'])) {

	$seller_id = $_POST['seller_id'];

	$proposal_id = $_POST['proposal_id'];

	if ($_POST['favorite'] == "add_favorite") {

		$select_favorite = "select * from favorites where proposal_id='$proposal_id' AND seller_id='$seller_id'";

		$run_favorite = mysqli_query($con, $select_favorite);

		$count_favorite = mysqli_num_rows($run_favorite);

		if ($count_favorite == 0) {

			$insert_favorite = "insert into favorites (seller_id,proposal_id) values ('$seller_id','$proposal_id')";

			$run_favorite = mysqli_query($con, $insert_favorite);
		}
	}

	if ($_POST['favorite'] == "delete_favorite") {

		$delete_favorite = "delete from favorites where proposal_id='$proposal_id' AND seller_id='$seller_id'";

		$run_delete_favorite = mysqli_query($con, $delete_favorite);
	}
}
 