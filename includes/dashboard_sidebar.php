<!--- card mb-3 starts --->
<div class="card mb-3">
    <!--- card-header starts --->
    <div class="card-header">

        <h5 class="h5"> My Contacts </h5>

        <!--- nav nav-tabs card-header-tabs starts --->
        <ul class="nav nav-tabs card-header-tabs">

            <li class="nav-item">
                <a href="#my_buyers" data-toggle="tab" class="nav-link active">
                    My Buyers
                </a>
            </li>

            <li class="nav-item">
                <a href="#my_sellers" data-toggle="tab" class="nav-link">
                    My Sellers
                </a>
            </li>

        </ul>
        <!--- nav nav-tabs card-header-tabs ends --->

    </div>
    <!--- card-header ends --->


    <!--- card-body starts --->
    <div class="card-body">

        <!--- tab-content starts --->
        <div class="tab-content">

            <!--- tab-pane fade show active starts --->
            <div id="my_buyers" class="tab-pane fade show active">

                <!--- table-responsive starts --->
                <div class="table-responsive">

                    <!--- table table-hover starts --->
                    <table class="table table-hover">

                        <!--- thead starts --->
                        <thead>

                            <tr>
                                <th class="gray">
                                    Buyer Names
                                </th>
                            </tr>

                        </thead>
                        <!--- thead ends --->

                        <!--- tbody starts --->
                        <tbody>

                            <?php

                            $sel_my_buyers = "select * from my_buyers where seller_id='$login_seller_id'";

                            $run_my_buyers = mysqli_query($con, $sel_my_buyers);

                            while ($row_my_buyers = mysqli_fetch_array($run_my_buyers)) {

                                $buyer_id = $row_my_buyers['buyer_id'];

                                $select_buyer = "select * from sellers where seller_id='$buyer_id'";

                                $run_buyer = mysqli_query($con, $select_buyer);

                                $row_buyer = mysqli_fetch_array($run_buyer);

                                $buyer_id = $row_buyer['seller_id'];

                                $buyer_user_name = $row_buyer['seller_user_name'];

                                $buyer_image = $row_buyer['seller_image'];



                                ?>

                                <tr>
                                    <td>
                                        <img src="user_images/<?php echo $buyer_image; ?>" class="rounded-circle" width="50" height="50">

                                        <!--- contact-title starts --->
                                        <div class="contact-title">
                                            <h6> <?php echo $buyer_user_name; ?> </h6>

                                            <a href="<?php echo $buyer_user_name; ?>" target="_blank">
                                                User Profile
                                            </a>
                                            |
                                            <a href="conversations/message.php?seller_id=<?php echo $buyer_id; ?>" target="_blank">
                                                History
                                            </a>

                                        </div>
                                        <!--- contact-title ends --->

                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                        <!--- tbody ends --->

                    </table>
                    <!--- table table-hover ends --->

                </div>
                <!--- table-responsive Ends --->

            </div>
            <!--- tab-pane fade show active ends --->


            <!--- tab-pane fade starts --->
            <div id="my_sellers" class="tab-pane fade">

                <!--- table-responsive starts --->
                <div class="table-responsive">

                    <!--- table table-hover starts --->
                    <table class="table table-hover">

                        <!--- thead starts --->
                        <thead>
                            <tr>
                                <th class="gray">
                                    Seller Names
                                </th>
                            </tr>
                        </thead>
                        <!--- thead ends --->

                        <!--- tbody starts --->
                        <tbody>

                            <?php

                            $sel_my_sellers = "select * from my_sellers where buyer_id='$login_seller_id'";

                            $run_my_sellers = mysqli_query($con, $sel_my_sellers);

                            while ($row_my_sellers = mysqli_fetch_array($run_my_sellers)) {

                                $seller_id = $row_my_sellers['seller_id'];


                                $select_seller = "select * from sellers where seller_id='$seller_id'";

                                $run_seller = mysqli_query($con, $select_seller);

                                $row_seller = mysqli_fetch_array($run_seller);

                                $seller_id = $row_seller['seller_id'];

                                $seller_user_name = $row_seller['seller_user_name'];

                                $seller_image = $row_seller['seller_image'];

                                ?>

                                <tr>
                                    <td>
                                        <img src="user_images/<?php echo $seller_image; ?>" class="rounded-circle" width="50" height="50">

                                        <!--- contact-title starts --->
                                        <div class="contact-title">
                                            <h6> <?php echo $seller_user_name; ?> </h6>

                                            <a href="<?php echo $seller_user_name; ?>" target="_blank">
                                                User Profile
                                            </a>
                                            |
                                            <a href="conversations/message.php?seller_id=<?php echo $seller_id; ?>" target="_blank">
                                                History
                                            </a>

                                        </div>
                                        <!--- contact-title ends --->

                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                        <!--- tbody ends --->

                    </table>
                    <!--- table table-hover ends --->

                </div>
                <!--- table-responsive ends --->

            </div>
            <!--- tab-pane fade ends --->

        </div>
        <!--- tab-content ends --->

    </div>
    <!--- card-body ends --->

</div>
<!--- card mb-3 ends --->


<!--- card mt-3 mb-3 starts --->
<div class="card mt-3 mb-3">
    <!--- card-body starts --->
    <div class="card-body">
        <h2 align="center">
            Place Your Add Here
        </h2>
    </div>
    <!--- card-body ends --->

</div>
<!--- card mt-3 mb-3 ends --->