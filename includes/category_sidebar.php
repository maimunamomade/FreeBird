<?php

if (isset($_SESSION['cat_id'])) {

    $session_cat_id = $_SESSION['cat_id'];
}

if (isset($_SESSION['cat_child_id'])) {

    $session_cat_child_id = $_SESSION['cat_child_id'];

    $get_child_cats = "select * from categories_childs where child_id='$session_cat_child_id'";

    $run_child_cats = mysqli_query($con, $get_child_cats);

    $row_child_cats = mysqli_fetch_array($run_child_cats);

    $child_parent_id = $row_child_cats['child_parent_id'];
}

$online_sellers = array();

$delivery_time = array();

$seller_level = array();

$seller_language = array();

if (isset($_GET['online_sellers'])) {

    foreach ($_GET['online_sellers'] as $value) {

        $online_sellers[$value] = $value;
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

    <!-- card-header bg-primary starts -->
    <div class="card-header bg-primary">

        <h3 class="text-white h5"> Categories </h3>

    </div>
    <!-- card-header bg-primary ends -->

    <!-- card-body starts -->
    <div class="card-body">

        <!-- nav flex-column starts -->
        <ul class="nav flex-column" id="proposal_category">

            <?php

            $get_cats = "select * from categories";

            $run_cats = mysqli_query($con, $get_cats);

            while ($row_cats = mysqli_fetch_array($run_cats)) {

                $cat_id = $row_cats['cat_id'];

                $cat_title = $row_cats['cat_title'];

                ?>

            <!-- nav-item starts -->
            <li class="nav-item">

                <!-- nav-link active starts -->
                <span class="nav-link 
<?php

if ($cat_id == @$_SESSION['cat_id']) {
    echo "active";
}

if ($cat_id == @$child_parent_id) {
    echo "active";
}
?>
">
                    <a href="category.php?cat_id=<?php echo $cat_id; ?>">

                        <?php echo $cat_title; ?>

                    </a>

                    <a href="#" class="h5 text-success pull-right" data-toggle="collapse" data-target="#cat_<?php echo $cat_id; ?>">

                        <i class="fa fa-arrow-circle-down"></i>

                    </a>

                </span>
                <!-- nav-link active ends -->

                <!-- collapse starts -->
                <ul id="cat_<?php echo $cat_id; ?>" class="collapse">

                    <?php

                    $get_child_cats = "select * from categories_childs where child_parent_id='$cat_id'";

                    $run_child_cats = mysqli_query($con, $get_child_cats);

                    while ($row_child_cats = mysqli_fetch_array($run_child_cats)) {

                        $child_id = $row_child_cats['child_id'];

                        $child_title = $row_child_cats['child_title'];

                        ?>

                    <li>
                        <a class="nav-link 

<?php if ($child_id == @$_SESSION['cat_child_id']) {
    echo "active";
} ?>

" href="category.php?cat_child_id=<?php echo $child_id; ?>">

                            <?php echo $child_title; ?>

                        </a>
                    </li>

                    <?php 
                } ?>

                </ul>
                <!-- collapse ends -->

            </li>
            <!-- nav-item ends -->

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

            if (isset($_SESSION['cat_id'])) {

                $get_proposals = "select DISTINCT delivery_id from proposals where proposal_cat_id='$session_cat_id' AND proposal_status='active'";
            } elseif (isset($_SESSION['cat_child_id'])) {

                $get_proposals = "select DISTINCT delivery_id from proposals where proposal_child_id='$session_cat_child_id' AND proposal_status='active'";
            }


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

            if (isset($_SESSION['cat_id'])) {

                $get_proposals = "select DISTINCT level_id from proposals where proposal_cat_id='$session_cat_id' AND proposal_status='active'";
            } elseif (isset($_SESSION['cat_child_id'])) {

                $get_proposals = "select DISTINCT level_id from proposals where proposal_child_id='$session_cat_child_id' AND proposal_status='active'";
            }


            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $level_id = $row_proposals['level_id'];

                $select_seller_levels = "select * from seller_levels where level_id='$level_id'";

                $run_seller_levels = mysqli_query($con, $select_seller_levels);

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

            if (isset($_SESSION['cat_id'])) {

                $get_proposals = "select DISTINCT language_id from proposals where proposal_cat_id='$session_cat_id' AND proposal_status='active'";
            } elseif (isset($_SESSION['cat_child_id'])) {

                $get_proposals = "select DISTINCT language_id from proposals where proposal_child_id='$session_cat_child_id' AND proposal_status='active'";
            }


            $run_proposals = mysqli_query($con, $get_proposals);

            while ($row_proposals = mysqli_fetch_array($run_proposals)) {

                $language_id = $row_proposals['language_id'];

                $select_seller_languges = "select * from seller_languages where language_id='$language_id'";

                $run_seller_languges = mysqli_query($con, $select_seller_languges);

                $row_seller_languges = mysqli_fetch_array($run_seller_languges);

                $language_id = $row_seller_languges['language_id'];

                $language_title = $row_seller_languges['language_title'];

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