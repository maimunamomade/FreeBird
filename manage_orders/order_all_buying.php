<!--- table-responsive box-table mt-3 starts --->
<div class="table-responsive box-table mt-3">

    <!--- table table-hover starts --->
    <table class="table table-hover">

        <!--- thead starts --->
        <thead>

            <tr>

                <th> ORDER SUMMARY </th>

                <th> ORDER DATE </th>

                <th> DUE ON </th>

                <th> TOTAL </th>

                <th> STATUS </th>

            </tr>

        </thead>
        <!--- thead ends --->

        <tbody>

            <?php

            $sel_orders = "select * from orders where buyer_id='$login_seller_id' order by 1 DESC";

            $run_orders = mysqli_query($con, $sel_orders);

            while ($row_orders = mysqli_fetch_array($run_orders)) {

                $order_id = $row_orders['order_id'];

                $proposal_id = $row_orders['proposal_id'];

                $order_price = $row_orders['order_price'];

                $order_status = $row_orders['order_status'];

                $order_number = $row_orders['order_number'];

                $order_duration = substr($row_orders['order_duration'], 0, 1);

                $order_date = $row_orders['order_date'];

                $order_due = date("F d, Y", strtotime($order_date . " + $order_duration days"));


                $get_proposals = "select * from proposals where proposal_id='$proposal_id'";

                $run_proposals = mysqli_query($con, $get_proposals);

                $row_proposals = mysqli_fetch_array($run_proposals);

                $proposal_img1 = $row_proposals['proposal_img1'];

                $proposal_title = $row_proposals['proposal_title'];


                ?>

                <tr>

                    <td>

                        <a href="order_details.php?order_id=<?php echo $order_id; ?>">

                            <img class="order-proposal-image" src="proposals/proposal_files/<?php echo $proposal_img1; ?>">

                            <p class="order-proposal-title"> <?php echo $proposal_title; ?> </p>

                        </a>

                    </td>

                    <td> <?php echo $order_date; ?> </td>

                    <td> <?php echo $order_due; ?> </td>

                    <td> ₹<?php echo $order_price; ?> </td>

                    <td> <button class="btn btn-success"> <?php echo ucwords($order_status); ?> </button> </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>
    <!--- table table-hover ends --->

</div>
<!--- table-responsive box-table mt-3 ends --->