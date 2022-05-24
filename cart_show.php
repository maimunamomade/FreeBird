<?php

session_start();

include("includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

	echo "<script>window.open('login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$get_payment_settings = "select * from payment_settings";

$run_payment_setttings = mysqli_query($con, $get_payment_settings);

$row_payment_settings = mysqli_fetch_array($run_payment_setttings);

$processing_fee = $row_payment_settings['processing_fee'];

$select_cart = "select * from cart where seller_id='$login_seller_id'";

$run_cart = mysqli_query($con, $select_cart);

?>

<!--- col-md-7 starts --->
<div class="col-md-7">

	<!--- card mb-3 starts --->
	<div class="card mb-3">

		<!--- card-body starts --->
		<div class="card-body">

			<?php

			$total = 0;


			while ($row_cart = mysqli_fetch_array($run_cart)) {

				$proposal_id = $row_cart['proposal_id'];

				$proposal_price = $row_cart['proposal_price'];

				$proposal_qty = $row_cart['proposal_qty'];

				$select_proposal = "select * from proposals where proposal_id='$proposal_id'";

				$run_proposal = mysqli_query($con, $select_proposal);

				$row_proposal = mysqli_fetch_array($run_proposal);

				$proposal_title = $row_proposal['proposal_title'];

				$proposal_url = $row_proposal['proposal_url'];

				$proposal_img1 = $row_proposal['proposal_img1'];

				$sub_total = $proposal_price * $proposal_qty;

				$total += $sub_total;

				?>

				<div class="cart-proposal">
					<!--- cart-proposal Starts --->

					<div class="row">
						<!--- row Starts --->

						<div class="col-lg-3 mb-2">
							<!--- col-lg-3 mb-2 Starts --->

							<a href="proposals/<?php echo $proposal_url; ?>">

								<img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">

							</a>

						</div>
						<!--- col-lg-3 mb-2 Ends --->


						<div class="col-lg-9">
							<!--- col-lg-9 Starts --->

							<a href="proposals/<?php echo $proposal_url; ?>">

								<h6> <?php echo $proposal_title; ?> </h6>

							</a>


							<a href="cart.php?remove_proposal=<?php echo $proposal_id; ?>" class="remove-link text-muted">

								Remove Proposal

							</a>

						</div>
						<!--- col-lg-9 Ends --->


					</div>
					<!--- row Ends --->

					<hr>

					<h6 class="clearfix">

						Proposal Quantity

						<strong class="float-right price ml-2 mt-2"> $<?php echo $sub_total; ?> </strong>

						<input type="text" name="quantity" class="float-right form-control quantity" data-proposal_id="<?php echo $proposal_id; ?>" value="<?php echo $proposal_qty; ?>">

					</h6>

					<hr>

				</div>
				<!--- cart-proposal Ends --->

			<?php } ?>

			<h3 class="float-right"> Total : $<?php echo $total; ?> </h3>


		</div>
		<!--- card-body Ends --->

	</div>
	<!--- card mb-3 Ends --->

</div>
<!--- col-md-7 Ends --->


<div class="col-md-5">
	<!--- col-md-5 Starts --->

	<div class="card">
		<!--- card Starts --->

		<div class="card-body cart-order-details">
			<!--- card-body cart-order-details Starts --->

			<p> Cart Subtotal <span class="float-right">$<?php echo $total; ?></span> </p>

			<hr>

			<p> Apply Coupon Code </p>

			<form class="input-group" method="post">
				<!--- input-group Starts --->

				<input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">

				<button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">

					Apply

				</button>

			</form>
			<!--- input-group Ends --->

			<?php if (!isset($_GET['coupon_applied'])) { ?>

				<p class="coupon-response"></p>

			<?php } else { ?>

				<p class="coupon-response p-2 mt-3 bg-success text-white">

					Your Coupon Has Been Applied.

				</p>


			<?php } ?>

			<?php

			if (isset($_POST['coupon_submit'])) {

				$coupon_code = $_POST['code'];

				if (!empty($coupon_code)) {

					$select_coupon = "select * from coupons where coupon_code='$coupon_code'";

					$run_coupon = mysqli_query($con, $select_coupon);

					$count_coupon = mysqli_num_rows($run_coupon);

					if ($count_coupon == 1) {

						$row_coupon = mysqli_fetch_array($run_coupon);

						$coupon_proposal = $row_coupon['proposal_id'];

						$coupon_limit = $row_coupon['coupon_limit'];

						$coupon_used = $row_coupon['coupon_used'];

						$coupon_price = $row_coupon['coupon_price'];

						if ($coupon_limit <= $coupon_used) {

							echo "
	
	<script>
	
	$('.coupon-response').html('Your Coupon Code Has Been Expired.').attr('class','coupon-response p-2 mt-3 bg-danger text-white');
	
	</script>
	
	";
						} else {

							$select_cart = "select * from cart where proposal_id='$coupon_proposal' AND seller_id='$login_seller_id'";

							$run_cart = mysqli_query($con, $select_cart);

							$count_cart = mysqli_num_rows($run_cart);

							if ($count_cart == 1) {

								$update_coupon = "update coupons set coupon_used=coupon_used+1 where coupon_code=
			'$coupon_code'";

								$run_update_coupon = mysqli_query($con, $update_coupon);

								$update_cart = "update cart set proposal_price='$coupon_price' where proposal_id='$coupon_proposal' AND seller_id='$login_seller_id'";

								$run_update_cart = mysqli_query($con, $update_cart);

								echo "<script>window.open('cart.php?coupon_applied','_self')</script>";
							} else {

								echo "
	
	<script>
	
	$('.coupon-response').html('Your Coupon Code Is Not Right For Proposals In Cart.').attr('class','coupon-response p-2 mt-3 bg-danger text-white');
	
	</script>
	
	";
							}
						}
					} else {

						echo "
	
	<script>
	
	$('.coupon-response').html('Your Coupon Code Is Not Valid.').attr('class','coupon-response p-2 mt-3 bg-danger text-white');
	
	</script>
	
	";
					}
				}
			}


			?>

			<hr>

			<p> Processing Fee <span class="float-right">$<?php echo $processing_fee; ?></span> </p>

			<hr>

			<p> Total <span class="font-weight-bold float-right"> $<?php echo $total + $processing_fee; ?> </span> </p>

			<hr>

			<a href="cart_payment_options.php" class="btn btn-lg btn-success btn-block">

				Proceed To Payment

			</a>

		</div>
		<!--- card-body cart-order-details Ends --->

	</div>
	<!--- card Ends --->

</div>
<!--- col-md-5 Ends --->