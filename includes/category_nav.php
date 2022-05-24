<!-- mp-box div starts-->
<div class="mp-box mp-box-white notop d-lg-block d-none">

    <!-- box-row starts-->
    <div class="box-row">

        <!--main category list starts-->
        <ul class="main-cat-list active">

            <?php

            $get_categories = "select * from categories where cat_featured='yes' LIMIT 0,8";

            $run_categories = mysqli_query($con, $get_categories);

            while ($row_categories = mysqli_fetch_array($run_categories)) {

                $cat_id = $row_categories['cat_id'];

                $cat_title = $row_categories['cat_title'];

                ?>

            <!-- list items starts-->
            <li>
                <a href="<?php echo $site_url; ?>/category.php?cat_id=<?php echo $cat_id; ?>">

                    <?php echo $cat_title; ?>

                </a>

                <!-- menu contents starts-->
                <div class="menu-cont">
                    <ul>

                        <?php

                        $get_child_cats = "select * from categories_childs where child_parent_id='$cat_id' LIMIT 0,7";

                        $run_child_cats = mysqli_query($con, $get_child_cats);

                        while ($row_child_cats = mysqli_fetch_array($run_child_cats)) {

                            $child_id = $row_child_cats['child_id'];

                            $child_title = $row_child_cats['child_title'];

                            ?>

                        <li>
                            <a href="<?php echo $site_url; ?>/category.php?cat_child_id=<?php echo $child_id; ?>">

                                <?php echo $child_title; ?>

                            </a>
                        </li>

                        <?php 
                    } ?>

                    </ul>

                    <?php

                    $get_child_cats = "select * from categories_childs where child_parent_id='$cat_id'";

                    $run_child_cats = mysqli_query($con, $get_child_cats);

                    $count = mysqli_num_rows($run_child_cats);

                    if ($count > 7) {

                        ?>

                    <ul>
                        <?php

                        $get_child_cats = "select * from categories_childs where child_parent_id='$cat_id' LIMIT 7,$count";

                        $run_child_cats = mysqli_query($con, $get_child_cats);

                        while ($row_child_cats = mysqli_fetch_array($run_child_cats)) {

                            $child_id = $row_child_cats['child_id'];

                            $child_title = $row_child_cats['child_title'];

                            ?>

                        <li>

                            <a href="<?php echo $site_url; ?>/category.php?cat_child_id=<?php echo $child_id; ?>">

                                <?php echo $child_title; ?>

                            </a>

                        </li>
                        <?php 
                    } ?>

                    </ul>

                    <?php 
                } ?>

                </div>
                <!-- menu content ends-->

            </li>
            <!-- list items ends-->

            <?php 
        } ?>

        </ul>
        <!--main category list ends-->

    </div>
    <!-- box-row starts-->

</div>
<!-- mp-box div starts-->

<div class="d-lg-none d-block mt-5"> &nbsp; </div> 