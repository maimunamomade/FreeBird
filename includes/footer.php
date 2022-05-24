<!-- footer starts -->
<div class="mt-2" id="footer">
    <!-- container starts -->
    <div class="container">
        <!-- row starts -->
        <div class="row">
            <!-- col-md-3 col-sm-6 starts -->
            <div class="col-md-3 col-sm-6">
                <h4>
                    <strong> CATEGORIES </strong>
                </h4>

                <!-- ul starts -->
                <ul>

                    <?php

                    $get_links = "select * from footer_links where link_section='categories'";

                    $run_links = mysqli_query($con, $get_links);

                    while ($row_links = mysqli_fetch_array($run_links)) {

                        $link_title = $row_links['link_title'];

                        $link_url = $row_links['link_url'];

                        ?>

                    <li>
                        <a href="<?php echo $link_url; ?>">
                            <?php echo $link_title; ?>
                        </a>
                    </li>

                    <?php 
                } ?>

                </ul>
                <!-- ul ends -->

            </div>
            <!-- col-md-3 col-sm-6 ends -->


            <!-- col-md-3 col-sm-6 starts -->
            <div class="col-md-3 col-sm-6">
                <h4>
                    <strong> ABOUT </strong>
                </h4>

                <!-- ul starts -->
                <ul>

                    <?php

                    $get_links = "select * from footer_links where link_section='about'";

                    $run_links = mysqli_query($con, $get_links);

                    while ($row_links = mysqli_fetch_array($run_links)) {

                        $link_title = $row_links['link_title'];

                        $link_url = $row_links['link_url'];

                        ?>

                    <li>
                        <a href="<?php echo $link_url; ?>">
                            <?php echo $link_title; ?>
                        </a>
                    </li>

                    <?php 
                } ?>

                </ul>
                <!-- ul ends -->

            </div>
            <!-- col-md-3 col-sm-6 ends -->


            <!-- col-md-3 col-sm-6 starts -->
            <div class="col-md-3 col-sm-6">
                <h4>
                    <strong> SUPPORT </strong>
                </h4>

                <!-- ul starts -->
                <ul>

                    <?php

                    $get_links = "select * from footer_links where link_section='support'";

                    $run_links = mysqli_query($con, $get_links);

                    while ($row_links = mysqli_fetch_array($run_links)) {

                        $link_title = $row_links['link_title'];

                        $link_url = $row_links['link_url'];

                        ?>

                    <li>
                        <a href="<?php echo $link_url; ?>">
                            <?php echo $link_title; ?>
                        </a>
                    </li>

                    <?php 
                } ?>

                </ul>
                <!-- ul ends -->

            </div>
            <!-- col-md-3 col-sm-6 ends -->


            <!-- col-md-3 col-sm-6 starts -->
            <div class="col-md-3 col-sm-6">
                <h4>
                    <strong> Follow Us </strong>
                </h4>

                <!-- ul starts -->
                <ul>

                    <?php

                    $get_links = "select * from footer_links where link_section='follow'";

                    $run_links = mysqli_query($con, $get_links);

                    while ($row_links = mysqli_fetch_array($run_links)) {

                        $link_title = $row_links['link_title'];

                        $link_url = $row_links['link_url'];

                        ?>

                    <li>
                        <a href="<?php echo $link_url; ?>">
                            <?php echo $link_title; ?>
                        </a>
                    </li>

                    <?php 
                } ?>

                </ul>
                <!-- ul ends -->

            </div>
            <!-- col-md-3 col-sm-6 ends -->

        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

</div>
<!-- footer ends -->

<!-- copyright starts -->
<div id="copyright">

    <!-- container starts -->
    <div class="container">

        <!-- row starts -->
        <div class="row">

            <!-- col-md-6 starts -->
            <div class="col-md-6">

                <p class="text-lg-left text-center font-wheight-bold">
                    &copy; Maimuna Manuel Momade. All Rights Reserved.
                </p>

            </div>
            <!-- col-md-6 ends -->

            <!-- col-md-6 starts -->
            <div class="col-md-6">

                <p class="text-lg-right text-center ">
                    Template By
                    <a class="text-white font-wheight-bold" href="#">
                        Maimuna M. Momade
                    </a>
                </p>

            </div>
            <!-- col-md-6 ends -->


        </div>
        <!-- row ends -->

    </div>
    <!-- container ends -->

</div>
<!-- copyright ends -->



<script src="<?php echo $site_url; ?>/js/jquery.sticky.js"> </script>
<script src="<?php echo $site_url; ?>/js/popper.min.js"> </script>
<script src="<?php echo $site_url; ?>/js/bootstrap.min.js"> </script>
<script src="<?php echo $site_url; ?>/js/owl.carousel.min.js"> </script>
<script src="<?php echo $site_url; ?>/js/custom.js"> </script> 