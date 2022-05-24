<?php

session_start();

include("../includes/db.php");

if (!isset($_SESSION['seller_user_name'])) {

    echo "<script>window.open('../login.php','_self')</script>";
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>FreeBird / Edit Your Proposal </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="Author" content="Maimuna Manuel Momade">

    <link href="../styles/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="../styles/user_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="../styles/custom.css" rel="stylesheet">
    <link href="../styles/bootstrap-tokenfield.min.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <script src="../js/jquery.min.js"> </script>
    <script src="../js/bootstrap-tokenfield.min.js"> </script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=gq1oawghp3wbsf6kpxxy3yatq931ealyg354sptnmpns5s4b"></script>

    <script>
        tinymce.init({
            selector: '.proposal-desc'
        });
    </script>
</head>

<body>
    <?php include("../includes/user_header.php"); ?>

    <?php

    $proposal_id = $_GET['proposal_id'];

    $select_proposal = "select * from proposals where proposal_id='$proposal_id'";

    $run_proposal = mysqli_query($con, $select_proposal);

    $row_proposal = mysqli_fetch_array($run_proposal);

    $d_proposal_title = $row_proposal['proposal_title'];

    $d_proposal_cat_id = $row_proposal['proposal_cat_id'];

    $d_proposal_child_id = $row_proposal['proposal_child_id'];

    $d_proposal_price = $row_proposal['proposal_price'];

    $d_proposal_desc = $row_proposal['proposal_desc'];

    $d_buyer_instruction = $row_proposal['buyer_instruction'];

    $d_proposal_tags = $row_proposal['proposal_tags'];

    $d_proposal_video = $row_proposal['proposal_video'];

    $d_proposal_img1 = $row_proposal['proposal_img1'];

    $d_proposal_img2 = $row_proposal['proposal_img2'];

    $d_proposal_img3 = $row_proposal['proposal_img3'];

    $d_proposal_img4 = $row_proposal['proposal_img4'];

    $d_delivery_id = $row_proposal['delivery_id'];


    $get_delivery_time = "select * from delivery_times where delivery_id='$d_delivery_id'";

    $run_delivery_time = mysqli_query($con, $get_delivery_time);

    $row_delivery_time = mysqli_fetch_array($run_delivery_time);

    $delivery_proposal_title = $row_delivery_time['delivery_proposal_title'];


    $get_cat = "select * from categories where cat_id='$d_proposal_cat_id'";

    $run_cat = mysqli_query($con, $get_cat);

    $row_cat = mysqli_fetch_array($run_cat);

    $cat_title = $row_cat['cat_title'];


    $get_c_cat = "select * from categories_childs where child_id='$d_proposal_child_id'";

    $run_c_cat = mysqli_query($con, $get_c_cat);

    $row_c_cat = mysqli_fetch_array($run_c_cat);

    $child_title = $row_c_cat['child_title'];

    ?>

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-12 mb-5 mt-5 starts -->
            <div class="col-md-12 mb-5 mt-5">

                <h1> Edit Your Proposal </h1>

            </div>
            <!-- col-md-12 mb-5 mt-5 ends -->

            <!-- col-md-12 starts -->
            <div class="col-md-12">

                <!-- card rounded-0 mb-5 starts -->
                <div class="card rounded-0 mb-5">

                    <!-- card-body starts -->
                    <div class="card-body">

                        <!-- form starts -->
                        <form method="post" enctype="multipart/form-data">

                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6">
                                    Proposal Title
                                </div>

                                <div class="col-md-8">

                                    <input type="text" name="proposal_title" maxlength="70" class="form-control" value="<?php echo $d_proposal_title; ?>" required>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6">
                                    Proposal Category
                                </div>

                                <div class="col-md-8">

                                    <select name="proposal_category" id="category" class="form-control mb-3" required>

                                        <option value="<?php echo $d_proposal_cat_id; ?>" selected>
                                            <?php echo $cat_title; ?>
                                        </option>

                                        <?php

                                        $get_cats = "select * from categories where not cat_id='$d_proposal_cat_id'";

                                        $run_cats = mysqli_query($con, $get_cats);

                                        while ($row_cats = mysqli_fetch_array($run_cats)) {

                                            $cat_id = $row_cats['cat_id'];

                                            $cat_title = $row_cats['cat_title'];

                                            ?>

                                            <option value="<?php echo $cat_id; ?>"> <?php echo $cat_title; ?> </option>

                                        <?php } ?>

                                    </select>

                                    <select name="proposal_sub_category" id="sub-category" class="form-control" required>

                                        <option value="<?php echo $d_proposal_child_id; ?>" selected>
                                            <?php echo $child_title; ?>
                                        </option>

                                    </select>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Proposal Price </div>

                                <div class="col-md-8">

                                    <select name="proposal_price" class="form-control" required>

                                        <option value="<?php echo $d_proposal_price; ?>"> ₹<?php echo $d_proposal_price; ?> </option>

                                        <option value="250"> ₹250 </option>

                                        <option value="300" selected> ₹300 </option>

                                        <option value="350"> ₹350 </option>

                                        <option value="400"> ₹400 </option>

                                    </select>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6">

                                    Proposal Description <br>
                                    <small> Briefly Describe Your Proposal. </small>

                                </div>

                                <div class="col-md-8">

                                    <textarea name="proposal_description" rows="7" placeholder="Enter Your Proposal Description" class="form-control proposal-desc">
                                        <?php echo $d_proposal_desc; ?>
                                    </textarea>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6">

                                    Instructions to Buyer <br> <small> Give Buyer a head start. </small>

                                    <br>

                                    <small>
                                        If you need to obtain information, files or other material from the buyer prior to starting your work, please add your instructions here. For example: Please send me your company name or Please send me the photo you need me to edit.
                                    </small>

                                </div>

                                <div class="col-md-8">

                                    <textarea name="buyer_instruction" rows="7" class="form-control">
                                        <?php echo $d_buyer_instruction; ?>
                                    </textarea>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row Starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Proposal Tags </div>

                                <div class="col-md-8">

                                    <input type="text" name="proposal_tags" placeholder="Tags" class="form-control" value="<?php echo $d_proposal_tags; ?>" id="tags" required>

                                </div>

                            </div>
                            <!-- form-group row ends -->

                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Proposal Delivery Time </div>

                                <div class="col-md-8">

                                    <select name="delivery_id" class="form-control" required>

                                        <option value="<?php echo $d_delivery_id; ?>"> <?php echo $delivery_proposal_title; ?> </option>

                                        <?php

                                        $get_delivery_times = "select * from delivery_times where not delivery_id='$d_delivery_id'";

                                        $run_delivery_times = mysqli_query($con, $get_delivery_times);

                                        while ($row_delivery_times = mysqli_fetch_array($run_delivery_times)) {

                                            $delivery_id = $row_delivery_times['delivery_id'];

                                            $delivery_proposal_title = $row_delivery_times['delivery_proposal_title'];

                                            echo "<option value='$delivery_id'>$delivery_proposal_title</option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Add Proposal Image </div>

                                <div class="col-md-8">

                                    <input type="file" name="proposal_img1" class="form-control mb-3" required>

                                    <img src="proposal_files/<?php

                                                                if (empty($d_proposal_img1)) {

                                                                    echo "no-image.jpg";
                                                                } else {

                                                                    echo $d_proposal_img1;
                                                                }

                                                                ?>" width="60" height="70">
                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row Starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Add Proposal More Images </div>

                                <div class="col-md-8">

                                    <a href="#" data-toggle="collapse" data-target="#more-images" class="btn btn-success btn-block">
                                        Add More Images
                                    </a>

                                    <!-- more-images collapse starts -->
                                    <div id="more-images" class="collapse">

                                        <input type="file" name="proposal_img2" class="form-control mt-3 mb-2">

                                        <img src="proposal_files/<?php

                                                                    if (empty($d_proposal_img2)) {

                                                                        echo "no-image.jpg";
                                                                    } else {

                                                                        echo $d_proposal_img2;
                                                                    }

                                                                    ?>" width="60" height="70">

                                        <input type="file" name="proposal_img3" class="form-control mt-3 mb-2">

                                        <img src="proposal_files/<?php

                                                                    if (empty($d_proposal_img3)) {

                                                                        echo "no-image.jpg";
                                                                    } else {

                                                                        echo $d_proposal_img3;
                                                                    }

                                                                    ?>" width="60" height="70">

                                        <input type="file" name="proposal_img4" class="form-control mt-3 mb-2">

                                        <img src="proposal_files/<?php

                                                                    if (empty($d_proposal_img4)) {

                                                                        echo "no-image.jpg";
                                                                    } else {

                                                                        echo $d_proposal_img4;
                                                                    }

                                                                    ?>" width="60" height="70">

                                    </div>
                                    <!-- more-images collapse ends -->

                                </div>

                            </div>
                            <!-- form-group row ends -->


                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> Add Proposal Video (Optional) </div>

                                <div class="col-md-8">

                                    <input type="file" name="proposal_video" class="form-control">

                                    <?php if (empty($d_proposal_video)) { ?>

                                        <img src="proposal_files/no-video.jpg" width="60" height="70" class="mt-3">

                                    <?php } else { ?>

                                        <br>

                                        <video width="150" height="150" controls>

                                            <source src="proposal_files/<?php echo $d_proposal_video; ?>">

                                        </video>

                                    <?php } ?>

                                </div>

                            </div>
                            <!-- form-group row ends -->

                            <!-- form-group row starts -->
                            <div class="form-group row">

                                <div class="col-md-3 control-label h6"> </div>

                                <div class="col-md-8">

                                    <button type="submit" name="update" class="btn btn-success form-control"> Update Proposal </button>

                                </div>

                            </div><!-- form-group row ends -->

                        </form><!-- form ends -->

                    </div><!-- card-body ends -->

                </div><!-- card rounded-0 mb-5 ends -->

            </div><!-- col-md-12 ends -->

        </div><!-- row ends -->

    </div><!-- container ends -->

    <script>
        $(document).ready(function() {


            $("#category").change(function() {

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


            $("#tags").tokenfield();

        });
    </script>

    <?php


    if (isset($_POST['update'])) {

        $proposal_title = mysqli_real_escape_string($con, $_POST['proposal_title']);

        $proposal_category = mysqli_real_escape_string($con, $_POST['proposal_category']);

        $proposal_sub_category = mysqli_real_escape_string($con, $_POST['proposal_sub_category']);

        $proposal_price = mysqli_real_escape_string($con, $_POST['proposal_price']);

        $proposal_description = mysqli_real_escape_string($con, $_POST['proposal_description']);

        $buyer_instruction = mysqli_real_escape_string($con, $_POST['buyer_instruction']);

        $proposal_tags = mysqli_real_escape_string($con, $_POST['proposal_tags']);

        $delivery_id = mysqli_real_escape_string($con, $_POST['delivery_id']);


        $proposal_img1 = $_FILES['proposal_img1']['name'];

        $proposal_img2 = $_FILES['proposal_img2']['name'];

        $proposal_img3 = $_FILES['proposal_img3']['name'];

        $proposal_img4 = $_FILES['proposal_img4']['name'];

        $proposal_video = $_FILES['proposal_video']['name'];



        $tmp_proposal_img1 = $_FILES['proposal_img1']['tmp_name'];

        $tmp_proposal_img2 = $_FILES['proposal_img2']['tmp_name'];

        $tmp_proposal_img3 = $_FILES['proposal_img3']['tmp_name'];

        $tmp_proposal_img4 = $_FILES['proposal_img4']['tmp_name'];

        $tmp_proposal_video = $_FILES['proposal_video']['tmp_name'];

        $allowed_img = array('gif', 'png', 'jpg', 'jpeg', 'tif');

        $allowed_video = array('mp4', 'mov', 'avi', 'flv', 'wmv');


        $proposal_img1_extension = pathinfo($proposal_img1, PATHINFO_EXTENSION);

        $proposal_img2_extension = pathinfo($proposal_img2, PATHINFO_EXTENSION);

        $proposal_img3_extension = pathinfo($proposal_img3, PATHINFO_EXTENSION);

        $proposal_img4_extension = pathinfo($proposal_img4, PATHINFO_EXTENSION);

        $proposal_video_extension = pathinfo($proposal_video, PATHINFO_EXTENSION);

        if (!empty($proposal_img1)) {

            if (!in_array($proposal_img1_extension, $allowed_img)) {

                echo "<script>alert('Your proposal image 1 file extension is not supported.')</script>";

                exit();
            }
        } else {

            $proposal_img1 = $d_proposal_img1;
        }


        if (!empty($proposal_img2)) {


            if (!in_array($proposal_img2_extension, $allowed_img)) {

                echo "<script>alert('Your proposal image 2 file extension is not supported.')</script>";

                exit();
            }
        } else {

            $proposal_img2 = $d_proposal_img2;
        }



        if (!empty($proposal_img3)) {


            if (!in_array($proposal_img3_extension, $allowed_img)) {

                echo "<script>alert('Your proposal image 3 file extension is not supported.')</script>";

                exit();
            }
        } else {

            $proposal_img3 = $d_proposal_img3;
        }



        if (!empty($proposal_img4)) {


            if (!in_array($proposal_img4_extension, $allowed_img)) {

                echo "<script>alert('Your proposal image 4 file extension is not supported.')</script>";

                exit();
            }
        } else {

            $proposal_img4 = $d_proposal_img4;
        }


        if (!empty($proposal_video)) {


            if (!in_array($proposal_video_extension, $allowed_video)) {

                echo "<script>alert('Your proposal video file extension is not supported.')</script>";

                exit();
            }
        } else {

            $proposal_video = $d_proposal_video;
        }


        move_uploaded_file($tmp_proposal_img1, "proposal_files/$proposal_img1");

        move_uploaded_file($tmp_proposal_img2, "proposal_files/$proposal_img2");

        move_uploaded_file($tmp_proposal_img3, "proposal_files/$proposal_img3");

        move_uploaded_file($tmp_proposal_img4, "proposal_files/$proposal_img4");

        move_uploaded_file($tmp_proposal_video, "proposal_files/$proposal_video");

        $update_proposal = "update proposals set proposal_title='$proposal_title',proposal_cat_id='$proposal_category',proposal_child_id='$proposal_sub_category',proposal_price='$proposal_price',proposal_img1='$proposal_img1',proposal_img2='$proposal_img2',proposal_img3='$proposal_img3',proposal_img4='$proposal_img4',proposal_video='$proposal_video',proposal_desc='$proposal_description',buyer_instruction='$buyer_instruction',proposal_tags='$proposal_tags',delivery_id='$delivery_id' where proposal_id='$proposal_id'";


        $run_proposal = mysqli_query($con, $update_proposal);

        if ($run_proposal) {

            echo "<script>alert('Your proposal has been updated successfully.');</script>";

            echo "<script>window.open('view_proposals.php','_self');</script>";
        }
    }


    ?>


    <?php include("../includes/footer.php"); ?>


</body>

</html>