<?php
$search_query = @$_SESSION['search_query'];

$select_categories = "select * from categories where cat_title like '%$search_query%'";

$run_categories = mysqli_query($con, $select_categories);

$count_categories = mysqli_num_rows($run_categories);

if ($count_categories > 0) {

    $row_categories = mysqli_fetch_array($run_categories);

    $category_id = $row_categories["cat_id"];

    echo "<script> window.open('$site_url/category.php?cat_id=$category_id','_self') </script>";
} else {

    $get_child_cats = "select * from categories_childs where child_title like '%$search_query%'";

    $run_child_cats = mysqli_query($con, $get_child_cats);

    $count_child_cats = mysqli_num_rows($run_child_cats);

    if ($count_child_cats > 0) {

        $row_child_cats = mysqli_fetch_array($run_child_cats);

        $child_id = $row_child_cats['child_id'];

        echo "<script> window.open('$site_url/category.php?cat_child_id=$child_id','_self') 
        </script>";
    }
}

$online_sellers = array();

$cat_id = array();

$delivery_time = array();

$seller_level = array();

$seller_language = array();

if (isset($_GET['online_sellers'])) {

    foreach ($_GET['online_sellers'] as $value) {

        $online_sellers[$value] = $value;
    }
}

if (isset($_GET['cat_id'])) {

    foreach ($_GET['cat_id'] as $value) {

        $cat_id[$value] = $value;
    }
}

if (isset($_GET['delivery_time'])) {

    foreach ($_GET['delivery_time'] as $value) {

        $delivery_time[$value] = $value;
    }
}

if (isset($_GET['seller_level'])) {

    foreach ($_GET['seller_level'] as $value) {

        $seller_level[$value] = $value;
    }
}

if (isset($_GET['seller_language'])) {

    foreach ($_GET['seller_language'] as $value) {

        $seller_language[$value] = $value;
    }
}

?>

<!-- card border-primary mb-3 starts -->
<div class="card border-primary mb-3">

    <!-- card-body pb-2 pt-3 starts -->
    <div class="card-body pb-2 pt-3">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column">

            <li class="nav-item checkbox checkbox-primary">
                <label>
                    <input type="checkbox" value="1" class="get_online_sellers" <?php if (isset($online_sellers["1"])) {
                                                                                    echo "checked";
                                                                                } ?>>

                    <span> Show Online Sellers </span>
                </label>

            </li>

        </ul>
        <!-- nav flex-column ends -->

    </div>
    <!-- card-body pb-2 pt-3 ends -->

</div>
<!-- card border-primary mb-3 ends -->


<!-- card border-primary mb-3 starts -->
<div class="card border-primary mb-3">

    <!-- card-header bg-primary starts -->
    <div class="card-header bg-primary">

        <h3 class="float-left text-white h5"> Categories </h3>

        <button class="btn btn-secondary btn-sm float-right clear_cat_id clearlink" onclick="clearCat()">
            <i class="fa fa-times-circle"> </i> Clear Filter
        </button>

    </div>
    <!-- card-header bg-primary ends -->

    <!-- card-body starts -->
    <div class="card-body">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column">

            <?php

            $get_proposals = "select DISTINCT proposal_cat_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active' ";

            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $proposal_cat_id = $row_proposals['proposal_cat_id'];

                $get_categories = "select * from categories where cat_id='$proposal_cat_id'";

                $run_categories = mysqli_query($con, $get_categories);

                $row_categories = mysqli_fetch_array($run_categories);

                $category_id = $row_categories['cat_id'];

                $category_title = $row_categories['cat_title'];

                ?>

            <li class="nav-item checkbox checkbox-primary">
                <label>
                    <input type="checkbox" value="<?php echo $category_id; ?>" class="get_cat_id" <?php if (isset($cat_id[$category_id])) {
                                                                                                        echo "checked";
                                                                                                    } ?>>

                    <span> <?php echo $category_title; ?> </span>

                </label>
            </li>

            <?php 
        } ?>

        </ul>
        <!-- nav flex-column ends -->

    </div>
    <!-- card-body ends -->

</div>
<!-- card border-primary mb-3 ends -->


<!-- card border-primary mb-3 starts -->
<div class="card border-primary mb-3">

    <!-- card-header bg-primary starts -->
    <div class="card-header bg-primary">

        <h3 class="float-left text-white h5"> Delivery Time </h3>

        <button class="btn btn-secondary btn-sm float-right clear_delivery_time clearlink" onclick="clearDelivery()">
            <i class="fa fa-times-circle"> </i> Clear Filter
        </button>

    </div>
    <!-- card-header bg-primary ends -->

    <!-- card-body starts -->
    <div class="card-body">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column">

            <?php

            $get_proposals = "select DISTINCT delivery_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active'";

            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $delivery_id = $row_proposals['delivery_id'];

                $get_delivery_times = "select * from delivery_times where delivery_id='$delivery_id'";

                $run_delivery_times = mysqli_query($con, $get_delivery_times);

                $row_delivery_times = mysqli_fetch_array($run_delivery_times);

                $delivery_id = $row_delivery_times['delivery_id'];

                $delivery_title = $row_delivery_times['delivery_title'];

                ?>

            <li class="nav-item checkbox checkbox-primary">
                <label>
                    <input type="checkbox" value="<?php echo $delivery_id; ?>" class="get_delivery_time" <?php if (isset($delivery_time[$delivery_id])) {
                                                                                                                echo "checked";
                                                                                                            } ?>>

                    <span> <?php echo $delivery_title; ?> </span>
                </label>
            </li>

            <?php 
        } ?>

        </ul>
        <!-- nav flex-column ends -->

    </div>
    <!-- card-body ends -->

</div>
<!-- card border-primary mb-3 ends -->


<!-- card border-primary mb-3 starts -->
<div class="card border-primary mb-3">

    <!-- card-header bg-primary starts -->
    <div class="card-header bg-primary">

        <h3 class="float-left text-white h5"> Seller Level </h3>

        <button class="btn btn-secondary btn-sm float-right clear_seller_level clearlink" onclick="clearLevel()">
            <i class="fa fa-times-circle"> </i> Clear Filter
        </button>

    </div>
    <!-- card-header bg-primary ends -->

    <!-- card-body starts -->
    <div class="card-body">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column">

            <?php

            $get_proposals = "select DISTINCT level_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active'";

            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $level_id = $row_proposals['level_id'];

                $get_seller_levels = "select * from seller_levels where level_id='$level_id'";

                $run_seller_levels = mysqli_query($con, $get_seller_levels);

                $row_seller_levels = mysqli_fetch_array($run_seller_levels);

                $level_id = $row_seller_levels['level_id'];

                $level_title = $row_seller_levels['level_title'];

                ?>

            <li class="nav-item checkbox checkbox-primary">
                <label>

                    <input type="checkbox" value="<?php echo $level_id; ?>" class="get_seller_level" <?php if (isset($seller_level[$level_id])) {
                                                                                                            echo "checked";
                                                                                                        } ?>>

                    <span> <?php echo $level_title; ?> </span>

                </label>
            </li>

            <?php 
        } ?>

        </ul>
        <!-- nav flex-column ends -->

    </div>
    <!-- card-body ends -->

</div>
<!-- card border-primary mb-3 ends -->


<!-- card border-primary mb-3 starts -->
<div class="card border-primary mb-3">

    <!-- card-header bg-primary starts -->
    <div class="card-header bg-primary">

        <h3 class="float-left text-white h5"> Seller Language </h3>

        <button class="btn btn-secondary btn-sm float-right clear_seller_language clearlink" onclick="clearLanguage()">
            <i class="fa fa-times-circle"> </i> Clear Filter
        </button>

    </div>
    <!-- card-header bg-primary ends -->

    <!-- card-body starts -->
    <div class="card-body">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column">

            <?php

            $get_proposals = "select DISTINCT language_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active'";

            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $language_id = $row_proposals['language_id'];

                $get_seller_languages = "select * from seller_languages where language_id='$language_id'";

                $run_seller_languages = mysqli_query($con, $get_seller_languages);

                $row_seller_languages = mysqli_fetch_array($run_seller_languages);

                $language_id = $row_seller_languages['language_id'];

                $language_title = $row_seller_languages['language_title'];

                ?>

            <li class="nav-item checkbox checkbox-primary">
                <label>
                    <input type="checkbox" value="<?php echo $language_id; ?>" class="get_seller_language" <?php if (isset($seller_language[$language_id])) {
                                                                                                                echo "checked";
                                                                                                            } ?>>

                    <span> <?php echo $language_title; ?> </span>
                </label>
            </li>

            <?php 
        } ?>

        </ul>
        <!-- nav flex-column ends -->

    </div>
    <!-- card-body ends -->

</div>
<!-- card border-primary mb-3 ends --> 