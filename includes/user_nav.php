<!--- mp-box mp-box-white notop d-lg-block d-none starts --->
<div class="mp-box mp-box-white notop d-lg-block d-none">
    <!--- box-row starts --->
    <div class="box-row">
        <!--- main-cat-list active starts --->
        <ul class="main-cat-list active">

            <!--- main li starts --->
            <li>
                <a href="<?php echo $site_url; ?>/dashboard.php">
                    Dashboard
                </a>
            </li>
            <!--- main li ends --->


            <!--- main li starts --->
            <li>
                <a href="#">
                    Selling <i class="fa fa-fw fa-caret-down"></i>
                </a>

                <!--- menu-cont starts --->
                <div class="menu-cont">
                    <!--- ul starts --->
                    <ul>
                        <li>
                            <a href="<?php echo $site_url; ?>/selling_orders.php">
                                Orders
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/proposals/view_proposals.php">
                                View Proposals
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/requests/buyer_requests.php">
                                Buyer Requests
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/revenue.php">
                                Revenues
                            </a>
                        </li>

                    </ul>
                    <!--- ul ends --->

                </div>
                <!--- menu-cont ends --->

            </li>
            <!--- main li ends --->


            <!--- main li starts --->
            <li>
                <a href="#">
                    Buying <i class="fa fa-fw fa-caret-down"></i>
                </a>

                <!--- menu-cont starts --->
                <div class="menu-cont">
                    <!--- ul Starts --->
                    <ul>

                        <li>
                            <a href="<?php echo $site_url; ?>/buying_orders.php">
                                Orders
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/purchases.php">
                                Payments
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/favourites.php">
                                Favourites
                            </a>
                        </li>

                    </ul>
                    <!--- ul ends --->

                </div>
                <!--- menu-cont ends --->

            </li>
            <!--- main li ends --->


            <!--- main li Starts --->
            <li>
                <a href="#">
                    Requests <i class="fa fa-fw fa-caret-down"></i>
                </a>

                <!--- menu-cont Starts --->
                <div class="menu-cont">
                    <!--- ul Starts --->
                    <ul>

                        <li>
                            <a href="<?php echo $site_url; ?>/requests/manage_requests.php">
                                Manage Requests
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/requests/post_request.php">
                                Post A Request
                            </a>
                        </li>

                    </ul>
                    <!--- ul ends --->

                </div>
                <!--- menu-cont ends --->

            </li>
            <!--- main li ends --->


            <!--- main li starts --->
            <li>
                <a href="#">
                    Contacts <i class="fa fa-fw fa-caret-down"></i>
                </a>

                <!--- menu-cont starts --->
                <div class="menu-cont">
                    <!--- ul Starts --->
                    <ul>
                        <li>
                            <a href="<?php echo $site_url; ?>/manage_contacts.php?my_buyers">
                                My Buyers
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $site_url; ?>/manage_contacts.php?my_sellers">
                                My Sellers
                            </a>
                        </li>

                    </ul>
                    <!--- ul ends --->

                </div>
                <!--- menu-cont ends --->

            </li>
            <!--- main li ends --->

            <?php if ($enable_referrals == "yes") { ?>

                <!--- main li starts --->
                <li>
                    <a href="<?php echo $site_url; ?>/my_referrals.php">
                        My Referrals
                    </a>
                </li>
                <!--- main li ends --->

            <?php } ?>

            <!--- main li starts --->
            <li>
                <a href="<?php echo $site_url; ?>/conversations/inbox.php">
                    Inbox
                </a>
            </li>
            <!--- main li ends --->


            <!--- main li starts --->
            <li>
                <a href="<?php echo $site_url; ?>/<?php echo $_SESSION['seller_user_name']; ?>">
                    My Profile
                </a>
            </li>
            <!--- main li ends --->


            <!--- main li starts --->
            <li>
                <a href="<?php echo $site_url; ?>/settings.php">
                    Settings
                </a>
            </li>
            <!--- main li ends --->

        </ul>
        <!--- main-cat-list active ends --->

    </div>
    <!--- box-row ends --->

</div>
<!--- mp-box mp-box-white notop d-lg-block d-none ends --->


<div class="d-lg-none d-block mt-5">
    &nbsp;
</div>