<?php

session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('../login.php','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con, $select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Post A New Request </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="../js/jquery.min.js"> </script>
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <!-- container-fluid mt-5 mb-5 starts -->
    <div class="container-fluid mt-5 mb-5">

        <!-- row starts -->
        <div class="row">

            <!-- col-lg-9 col-md-11 starts -->
            <div class="col-lg-9 col-md-11">

                <h1 class="mb-4"> Post A New Request To The Seller Community </h1>

                <!-- card rounded-0 starts -->
                <div class="card rounded-0">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- form starts -->
                        <form method="post" enctype="multipart/form-data">

                            <!-- row Starts -->
                            <div class="row">

                                <div class="col-md-2 d-md-block d-none">

                                    <i class="fa fa-pencil-square-o fa-4x"></i>

                                </div>

                                <!-- col-md-10 col-sm-12 starts -->
                                <div class="col-md-10 col-sm-12">

                                    <!-- row starts -->
                                    <div class="row">

                                        <!-- col-lg-8 starts -->
                                        <div class="col-lg-8">

                                            <!-- form-group starts -->
                                            <div class="form-group">

                                                <input type="text" name="request_title" placeholder="Request Title" class="form-control input-lg" required>

                                            </div>
                                            <!-- form-group ends -->

                                            <!-- form-group starts -->
                                            <div class="form-group">

                                                <textarea name="request_textarea" id="textarea" rows="5" cols="73" maxlength="380" class="form-control" placeholder="Request Description" required></textarea>

                                            </div>
                                            <!-- form-group ends -->

                                            <!-- form-group starts -->
                                            <div class="form-group">

                                                <input type="file" name="request_file" id="file">

                                                <div class="font-weight-bold pull-right">

                                                    <span class="count"> 0 </span> / 380 Max

                                                </div>

                                            </div>
                                            <!-- form-group ends -->

                                        </div>
                                        <!-- col-lg-8 ends -->

                                    </div>
                                    <!-- row ends -->

                                </div>
                                <!-- col-md-10 col-sm-12 ends -->

                            </div>
                            <!-- row ends -->

                            <hr class="card-hr">

                            <h5> Chose A Category </h5>


                            <!-- row mb-2 starts -->
                            <div class="row mb-2">

                                <!-- col-md-2 d-md-block d-none starts -->
                                <div class="col-md-2 d-md-block d-none">

                                    <i class="fa fa-folder-open fa-4x"></i>

                                </div>
                                <!-- col-md-2 d-md-block d-none ends -->

                                <!-- col-md-10 col-sm-12 starts -->
                                <div class="col-md-10 col-sm-12">

                                    <!-- row starts -->
                                    <div class="row">

                                        <!-- col-md-4 mb-2 starts -->
                                        <div class="col-md-4 mb-2">

                                            <select class="form-control" name="cat_id" id="category" required>

                                                <option value="" class="hidden"> Select A Category </option>

                                                <?php

                                                $get_cats = "select * from categories";

                                                $run_cats = mysqli_query($con, $get_cats);

                                                while ($row_cats = mysqli_fetch_array($run_cats)) {

                                                    $cat_id = $row_cats['cat_id'];

                                                    $cat_title = $row_cats['cat_title'];

                                                    ?>

                                                    <option value="<?php echo $cat_id; ?>"> <?php echo $cat_title; ?> </option>

                                                <?php } ?>

                                            </select>

                                        </div>
                                        <!-- col-md-4 mb-2 ends -->


                                        <!-- col-md-4 mb-2 starts -->
                                        <div class="col-md-4 mb-2">

                                            <select class="form-control" name="child_id" id="sub-category" required>

                                                <option value="" class="hidden"> Select A Sub Category </option>

                                            </select>

                                        </div>
                                        <!-- col-md-4 mb-2 ends -->

                                    </div>
                                    <!-- row ends -->

                                </div>
                                <!-- col-md-10 col-sm-12 ends -->

                            </div>
                            <!-- row mb-2 ends -->

                            <hr class="card-hr">

                            <h5> Once you place your order, when would you like your service to be delivered? </h5>

                            <!-- row mb-4 starts -->
                            <div class="row mb-4">

                                <!-- col-md-1 d-md-block d-none starts -->
                                <div class="col-md-1 d-md-block d-none">

                                    <i class="fa fa-clock-o fa-4x"></i>

                                </div>
                                <!-- col-md-1 d-md-block d-none ends -->

                                <!-- col-md-11 col-sm-12 mt-3 starts -->
                                <div class="col-md-11 col-sm-12 mt-3">

                                    <?php

                                    $get_delivery_times = "select * from delivery_times";

                                    $run_delivery_times = mysqli_query($con, $get_delivery_times);

                                    while ($row_delivery_times = mysqli_fetch_array($run_delivery_times)) {

                                        $delivery_proposal_title = $row_delivery_times['delivery_proposal_title'];

                                        ?>

                                        <!-- custom-control custom-radio starts -->
                                        <label class="custom-control custom-radio">

                                            <input type="radio" name="delivery_time" value="<?php echo $delivery_proposal_title; ?>" required>

                                            <span class="custom-control-indicator"></span>

                                            <span class="custom-control-description"> <?php echo $delivery_proposal_title; ?> </span>

                                        </label>
                                        <!-- custom-control custom-radio ends -->

                                    <?php } ?>

                                </div>
                                <!-- col-md-11 col-sm-12 mt-3 ends -->

                            </div>
                            <!-- row mb-4 ends -->


                            <hr class="card-hr">

                            <h5> What is your budget for this service? </h5>

                            <!-- col-md-4 mb-2 starts -->
                            <div class="col-md-4 mb-2">

                                <!-- input-group starts -->
                                <div class="input-group">

                                    <span class="input-group-addon font-weight-bold"> ₹ </span>

                                    <input type="number" name="request_budget" min="50" placeholder="50 Minimum" class="form-control input-lg">

                                </div>
                                <!-- input-group ends -->

                            </div>
                            <!-- col-md-4 mb-2 ends -->

                            <input type="submit" name="submit" value="Post Request" class="btn btn-outline-success btn-lg pull-right">

                        </form>
                        <!-- form ends -->

                    </div>
                    <!-- card-body ends -->

                </div>
                <!-- card rounded-0 ends -->

            </div>
            <!-- col-lg-9 col-md-11 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container-fluid mt-5 mb-5 ends -->

    <script>
        $(document).ready(function() {

            $("#textarea").keydown(function() {

                var textarea = $("#textarea").val();

                $(".count").text(textarea.length);

            });

            $("#sub-category").hide();

            $("#category").change(function() {

                $("#sub-category").show();


                var category_id = $(this).val();

                $.ajax({

                    url: "fetch_subcategory.php",

                    method: "POST",

                    data: {
                        category_id: category_id
                    },

                    success: function(data) {

                        $("#sub-category").html(data);

                    }

                });


            });

        });
    </script>

    <?php

    if (isset($_POST['submit'])) {

        $request_title = mysqli_real_escape_string($con, $_POST['request_title']);

        $request_description = mysqli_real_escape_string($con, $_POST['request_description']);

        $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);

        $child_id = mysqli_real_escape_string($con, $_POST['child_id']);

        $request_budget = mysqli_real_escape_string($con, $_POST['request_budget']);

        $delivery_time = mysqli_real_escape_string($con, $_POST['delivery_time']);


        $request_file = $_FILES['request_file']['name'];

        $request_file_tmp = $_FILES['request_file']['tmp_name'];

        $request_date = date("F d, Y");

        move_uploaded_file($request_file_tmp, "request_files/$request_file");

        $insert_request = "insert into buyer_requests (seller_id,cat_id,child_id,request_title,request_description,request_file,delivery_time,request_budget,request_date,request_status) values ('$login_seller_id','$cat_id','$child_id','$request_title','$request_description','$request_file','$delivery_time','$request_budget','$request_date','pending')";

        $run_request = mysqli_query($con, $insert_request);


        if ($run_request) {

            echo "<script>alert('The Request has been Posted successfully.');</script>";

            echo "<script>window.open('manage_requests.php','_self')</script>";
        }
    }

    ?>

    <?php include("../includes/footer.php"); ?>


</body>

</html>