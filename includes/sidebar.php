<?php

@session_start();

if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login.php','_self');</script>";
} else {



    ?>

    <!--- navbar navbar-expand-lg navbar-dark bg-success fixed-top mb-5 Starts --->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-5" id="mainNav" style="background:#e040fb;">

        <a class="navbar-brand" href="index.php?dashboard"> FreeBird Admin Panel </a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSidebar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!--- navbarSidebar collapse navbar-collapse Starts --->
        <div class="collapse navbar-collapse" id="navbarSidebar">

            <!--- navbar-nav side-nav nav Starts --->
            <ul class="navbar-nav side-nav nav">


                <li class="nav-item">
                    <!-- li Starts --->

                    <a class="nav-link" href="index.php?dashboard">

                        <i class="fa fa-fw fa-tachometer-alt"></i> Dashboard

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#settings">

                        <i class="fa fa-fw fa-cog"></i> Settings

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="settings" class="collapse">

                        <li>

                            <a href="index.php?general_settings"> General Settings </a>

                        </li>

                        <li>

                            <a href="index.php?layout_settings"> Layout Settings </a>

                        </li>

                        <li>

                            <a href="index.php?payment_settings"> Payment Settings </a>

                        </li>

                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?view_proposals">

                        <i class="fa fa-fw fa-table"></i> Proposals

                        <?php

                        if (!$count_proposals == 0) {

                            ?>

                            <span class="badge badge-secondary"><?php echo $count_proposals ?></span>

                        <?php } ?>

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?inbox_conversations">

                        <i class="fa fa-fw fa-envelope-square"></i> Inbox Conversations

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts
                            <li class="nav-item">

                                <a class="nav-link" href="index.php?view_adds">

                                    <i class="fa fa-fw fa-plus-square"></i> View Adds

                                </a>

                            </li>
                            li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#reviews">

                        <i class="fa fa-fw fa-comments"></i> Reviews

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="reviews" class="collapse">

                        <li>

                            <a href="index.php?insert_review"> Insert Review </a>

                        </li>

                        <li>

                            <a href="index.php?view_buyer_reviews"> View Reviews </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?buyer_requests">

                        <i class="fa fa-fw fa-bars"></i> Buyer Requests

                        <?php

                        if (!$count_requests == 0) {

                            ?>

                            <span class="badge badge-secondary"><?php echo $count_requests; ?></span>

                        <?php } ?>

                    </a>

                </li>
                <!-- li Ends --->



                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#cats">

                        <i class="fa fa-fw fa-cubes"></i> Categories

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="cats" class="collapse">

                        <li>

                            <a href="index.php?insert_cat"> Insert Category </a>

                        </li>

                        <li>

                            <a href="index.php?view_cats"> View Categories </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#child-cats">

                        <i class="fa fa-fw fa-camera"></i> Sub Categories

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="child-cats" class="collapse">

                        <li>

                            <a href="index.php?insert_child_cat"> Insert Sub Category </a>

                        </li>

                        <li>

                            <a href="index.php?view_child_cats"> View Sub Categories </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->



                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#delivery-times">

                        <i class="fa fa-fw fa-motorcycle"></i> Delivery Times

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="delivery-times" class="collapse">

                        <li>

                            <a href="index.php?insert_delivery_time"> Insert Delivery Time </a>

                        </li>

                        <li>

                            <a href="index.php?view_delivery_times"> View Delivery Times </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->

                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#seller-languages">

                        <i class="fa fa-fw fa-language"></i> Seller Languages

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="seller-languages" class="collapse">

                        <li>

                            <a href="index.php?insert_seller_language"> Insert Seller Language </a>

                        </li>

                        <li>

                            <a href="index.php?view_seller_languages"> View Seller Languages </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#seller-skills">

                        <i class="fa fa-fw fa-globe"></i> Seller Skills

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="seller-skills" class="collapse">

                        <li>

                            <a href="index.php?insert_seller_skill"> Insert Seller Skill </a>

                        </li>

                        <li>

                            <a href="index.php?view_seller_skills"> View Seller Skills </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#support_center">

                        <i class="fa fa-fw fa-phone-square"></i> Customer Support

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="support_center" class="collapse">

                        <li>

                            <a href="index.php?customer_support_settings"> Customer Support Settings </a>

                        </li>

                        <li>

                            <a href="index.php?view_support_requests">

                                View Support Requests

                                <?php

                                if (!$count_support_tickets == 0) {

                                    ?>

                                    <span class="badge badge-secondary"><?php echo $count_support_tickets; ?></span>

                                <?php } ?>

                            </a>

                        </li>


                        <li>

                            <a href="index.php?insert_enquiry_type"> Insert Enquiry Type </a>

                        </li>


                        <li>

                            <a href="index.php?view_enquiry_types"> View Enquiry Types </a>

                        </li>

                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#coupons">

                        <i class="fa fa-fw fa-gift"></i> Coupons

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="coupons" class="collapse">

                        <li>

                            <a href="index.php?insert_coupon"> Insert Coupon </a>

                        </li>

                        <li>

                            <a href="index.php?view_coupons"> View Coupons </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#slides">

                        <i class="fa fa-fw fa-sliders-h"></i> Slides

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="slides" class="collapse">

                        <li>

                            <a href="index.php?insert_slide"> Insert Slide </a>

                        </li>

                        <li>

                            <a href="index.php?view_slides"> View Slides </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->



                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#terms">

                        <i class="fa fa-fw fa-table"></i> Terms

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="terms" class="collapse">

                        <li>

                            <a href="index.php?insert_term"> Insert Term </a>

                        </li>

                        <li>

                            <a href="index.php?view_terms"> View Terms </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?view_sellers">

                        <i class="fa fa-fw fa-list"></i> View Sellers

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?view_orders">

                        <i class="fa fa-fw fa-plane"></i> View Orders

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="index.php?view_referrals">

                        <i class="fa fa-fw fa-universal-access"></i> View Referrals

                        <?php

                        if (!$count_referrals == 0) {

                            ?>

                            <span class="badge badge-secondary"><?php echo $count_referrals; ?></span>

                        <?php } ?>

                    </a>

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#files">

                        <i class="fa fa-fw fa-file"></i> Files

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="files" class="collapse">

                        <li>

                            <a href="index.php?view_proposals_files"> Proposals Files </a>

                        </li>

                        <li>

                            <a href="index.php?view_inbox_files"> Inbox Conversations Files </a>

                        </li>

                        <li>

                            <a href="index.php?view_order_files"> Orders Conversations Files </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#users">

                        <i class="fa fa-fw fa-users"></i> Users

                        <i class="fa fa-fw fa-caret-down"></i>

                    </a>

                    <!--- ul collapse Starts --->
                    <ul id="users" class="collapse">

                        <li>

                            <a href="index.php?insert_user"> Insert User </a>

                        </li>

                        <li>

                            <a href="index.php?view_users"> View Users </a>

                        </li>

                        <li>

                            <a href="index.php?user_profile=<?php echo $login_admin_id; ?>"> Edit Profile </a>

                        </li>


                    </ul>
                    <!--- ul collapse Ends --->

                </li>
                <!-- li Ends --->


                <!-- li Starts --->
                <li class="nav-item">

                    <a class="nav-link" href="logout.php">

                        <i class="fa fa-fw fa-sign-out-alt"></i> Log Out

                    </a>

                </li>
                <!-- li Ends --->


            </ul>
            <!--- navbar-nav side-nav nav Ends --->


            <!--- navbar-nav ml-auto Starts --->
            <ul class="navbar-nav ml-auto">

                <!--- nav-item mr-3 Starts --->
                <li class="nav-item mr-3">

                    <!--- dropdown Starts --->
                    <div class="dropdown">


                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown">

                            <img src="admin_images/<?php echo $admin_image; ?>" width="30" height="30" class="rounded-circle">

                            &nbsp; <?php echo $admin_name; ?> &nbsp; <span class="caret"></span>

                        </button>


                        <!--- dropdown-menu user-menu Starts --->
                        <div class="dropdown-menu user-menu">

                            <a class="dropdown-item" href="index.php?user_profile=<?php echo $admin_id; ?>">

                                <i class="fa fa-fw fa-users"></i> Your Profile

                            </a>

                            <a class="dropdown-item" href="index.php?view_proposals">

                                <i class="fa fa-fw fa-table"></i>

                                <span class="text-danger"> Pending </span><br>

                                Proposals <span class="badge badge-secondary"><?php echo $count_proposals; ?></span>

                            </a>


                            <a class="dropdown-item" href="index.php?view_sellers">

                                <i class="fa fa-fw fa-list"></i> Sellers

                                <span class="badge badge-secondary"><?php echo $count_sellers; ?></span>

                            </a>


                            <a class="dropdown-item" href="index.php?view_orders">

                                <i class="fa fa-fw fa-plane"></i> Active Orders

                                <span class="badge badge-secondary"><?php echo $count_orders; ?></span>

                            </a>


                            <a class="dropdown-item" href="index.php?view_support_requests">

                                <i class="fa fa-fw fa-phone-square"></i>

                                <span class="text-danger"> Open </span><br>

                                Support Requests <span class="badge badge-secondary"><?php echo $count_support_tickets; ?></span>

                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="logout.php">

                                <i class="fa fa-fw fa-sign-out-alt"></i> Log Out

                            </a>

                        </div>
                        <!--- dropdown-menu user-menu Ends --->


                    </div>
                    <!--- dropdown Ends --->

                </li>
                <!--- nav-item mr-3 Ends --->

            </ul>
            <!--- navbar-nav ml-auto Ends --->

        </div>
        <!--- navbarSidebar collapse navbar-collapse Ends --->

    </nav>
    <!--- navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-5 Ends --->



<?php } ?>