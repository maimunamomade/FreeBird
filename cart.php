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

$count_cart = mysqli_num_rows($run_cart);

if (isset($_GET['remove_proposal'])) {

    $proposal_id =     $_GET['remove_proposal'];

    $delete_cart_proposal = "delete from cart where proposal_id='$proposal_id' AND seller_id='$login_seller_id'";

    $run_delete_cart_proposal = mysqli_query($con, $delete_cart_proposal);

    if ($run_delete_cart_proposal) {

        echo "<script>window.open('cart.php','_self')</script>";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Shopping Cart </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/header.php"); ?>


    <!--- container mt-5 mb-3 starts --->
    <div class="container mt-5 mb-3">

        <!--- row starts --->
        <div class="row">

            <!--- col-md-12 starts --->
            <div class="col-md-12">

                <!--- card mb-3 starts --->
                <div class="card mb-3">

                    <!--- card-body starts --->
                    <div class="card-body">

                        <h5 class="float-left">
                            Your Cart (<?php echo $count_cart; ?>)
                        </h5>

                        <h5 class="float-right">
                            <a href="index.php">
                                Continue Shopping
                            </a>
                        </h5>

                    </div>
                    <!--- card-body ends --->

                </div>
                <!--- card mb-3 ends --->

            </div>
            <!--- col-md-12 ends --->

        </div>
        <!--- row ends --->


        <!--- cart-show row starts --->
        <div class="row" id="cart-show">

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

                            <!--- cart-proposal starts --->
                            <div class="cart-proposal">

                                <!--- row starts --->
                                <div class="row">

                                    <!--- col-lg-3 mb-2 starts --->
                                    <div class="col-lg-3 mb-2">

                                        <a href="proposals/<?php echo $proposal_url; ?>">
                                            <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">
                                        </a>

                                    </div>
                                    <!--- col-lg-3 mb-2 ends --->


                                    <!--- col-lg-9 starts --->
                                    <div class="col-lg-9">

                                        <a href="proposals/<?php echo $proposal_url; ?>">
                                            <h6>
                                                <?php echo $proposal_title; ?>
                                            </h6>
                                        </a>

                                        <a href="cart.php?remove_proposal=<?php echo $proposal_id; ?>" class="remove-link text-muted">
                                            Remove Proposal
                                        </a>

                                    </div>
                                    <!--- col-lg-9 ends --->

                                </div>
                                <!--- row ends --->

                                <hr>

                                <h6 class="clearfix">

                                    Proposal Quantity

                                    <strong class="float-right price ml-2 mt-2">
                                        ₹<?php echo $sub_total; ?>
                                    </strong>

                                    <input type="text" name="quantity" class="float-right form-control quantity" data-proposal_id="<?php echo $proposal_id; ?>" value="<?php echo $proposal_qty; ?>">

                                </h6>

                                <hr>

                            </div>
                            <!--- cart-proposal ends --->

                        <?php } ?>

                        <h3 class="float-right">
                            Total : ₹<?php echo $total; ?>
                        </h3>

                    </div>
                    <!--- card-body ends --->

                </div>
                <!--- card mb-3 ends --->

            </div>
            <!--- col-md-7 ends --->


            <!--- col-md-5 starts --->
            <div class="col-md-5">

                <!--- card starts --->
                <div class="card">

                    <!--- card-body cart-order-details starts --->
                    <div class="card-body cart-order-details">

                        <p>
                            Cart Subtotal
                            <span class="float-right">
                                ₹<?php echo $total; ?>
                            </span>
                        </p>

                        <hr>

                        <p> Apply Coupon Code </p>

                        <!--- input-group starts --->
                        <form class="input-group" method="post">

                            <input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">

                            <button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">
                                Apply
                            </button>

                        </form>
                        <!--- input-group ends --->

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
	
	$('.coupon-response').html('Your Coupon Code Is Not Right For The Proposals In Cart.').attr('class','coupon-response p-2 mt-3 bg-danger text-white');
	
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

                        <p>
                            Processing Fee
                            <span class="float-right">
                                ₹<?php echo $processing_fee; ?>
                            </span>
                        </p>

                        <hr>

                        <p>
                            Total
                            <span class="font-weight-bold float-right">
                                ₹<?php echo $total + $processing_fee; ?>
                            </span>
                        </p>

                        <hr>

                        <?php if ($count_cart == 0) { ?>

                            <h5 class="text-center"> You Have No Proposals Into The Cart. </h5>

                        <?php } else { ?>

                            <a href="cart_payment_options.php" class="btn btn-lg btn-success btn-block">
                                Proceed To Payment
                            </a>

                        <?php } ?>

                    </div>
                    <!--- card-body cart-order-details ends --->

                </div>
                <!--- card ends --->

            </div>
            <!--- col-md-5 ends --->

        </div>
        <!--- cart-show row ends --->

    </div>
    <!--- container mt-5 mb-3 ends --->


    <?php include("includes/footer.php"); ?>

    <script>
        $(document).ready(function() {


            $(document).on('keyup', '.quantity', function() {

                var seller_id = "<?php echo $login_seller_id; ?>";

                var proposal_id = $(this).data("proposal_id");

                var quantity = $(this).val();

                if (quantity != "") {

                    $.ajax({

                        url: "change_qty.php",

                        method: "POST",

                        data: {
                            seller_id: seller_id,
                            proposal_id: proposal_id,
                            proposal_qty: quantity
                        },

                        success: function(data) {

                            $("#cart-show").load("cart_show.php");

                        }


                    });



                }



            });




        });
    </script>

</body>

</html>