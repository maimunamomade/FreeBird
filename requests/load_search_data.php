<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

$run_login_seller = mysqli_query($con,$select_login_seller);

$row_login_seller = mysqli_fetch_array($run_login_seller);

$login_seller_id = $row_login_seller['seller_id'];

$login_seller_offers = $row_login_seller['seller_offers'];

?>


<?php 

$search = $_POST['search'];

$requests_query = $_POST['requests_query'];
	
if($search == ""){
	
$select_requests = "select * from buyer_requests where request_status='active'" . $requests_query . " AND NOT seller_id='$login_seller_id' order by 1 DESC";

}else{
	
$select_requests = "select * from buyer_requests where request_status='active'" . $requests_query . " AND request_description LIKE '%$search%' AND NOT seller_id='$login_seller_id' order by 1 DESC";
	
}


$run_requests = mysqli_query($con,$select_requests);

while($row_requests = mysqli_fetch_array($run_requests)){
	
$request_id = $row_requests['request_id'];

$seller_id = $row_requests['seller_id'];

$cat_id = $row_requests['cat_id'];

$child_id = $row_requests['child_id'];

$request_title = $row_requests['request_title'];

$request_description = $row_requests['request_description'];

$delivery_time = $row_requests['delivery_time'];

$request_budget = $row_requests['request_budget'];

$request_file = $row_requests['request_file'];

$request_date = $row_requests['request_date'];


$get_cats = "select * from categories where cat_id='$cat_id'";

$run_cats = mysqli_query($con,$get_cats);

$row_cats = mysqli_fetch_array($run_cats);

$cat_title = $row_cats['cat_title'];


$get_c_cats = "select * from categories_childs where child_id='$child_id'";

$run_c_cats = mysqli_query($con,$get_c_cats);

$row_c_cats = mysqli_fetch_array($run_c_cats);

$child_title = $row_c_cats['child_title'];


$select_request_seller = "select * from sellers where seller_id='$seller_id'";

$run_request_seller = mysqli_query($con,$select_request_seller);

$row_request_seller = mysqli_fetch_array($run_request_seller);

$request_seller_user_name = $row_request_seller['seller_user_name'];

$request_seller_image = $row_request_seller['seller_image'];

$select_send_offers = "select * from send_offers where request_id='$request_id'";

$run_send_offers = mysqli_query($con,$select_send_offers);

$count_send_offers = mysqli_num_rows($run_send_offers);

$select_offers = "select * from send_offers where request_id='$request_id' AND sender_id='$login_seller_id'";

$run_offers = mysqli_query($con,$select_offers);

$count_offers = mysqli_num_rows($run_offers);

if($count_offers == 0){


?>

<tr id="request_tr_<?php echo $request_id; ?>">

<td>

<?php if(!empty($request_seller_image)){ ?>

<img src="../user_images/<?php echo $request_seller_image; ?>" class="request-img rounded-circle" >

<?php }else{ ?>

<img src="../user_images/empty-image.png" class="request-img rounded-circle" >

<?php } ?>

<div class="request-description"><!-- request-description Starts -->

<h6> <?php echo $request_seller_user_name; ?> </h6>

<h5 class="text-primary"> <?php echo $request_title; ?> </h5>

<p class="lead mb-2"> <?php echo $request_description; ?> </p>

<?php if(!empty($request_file)){ ?>

<a href="request_files/ <?php echo $request_file; ?>" download>

<i class="fa fa-arrow-circle-down"></i>  <?php echo $request_file; ?>

</a>

<?php } ?>

<ul class="request-category">

<li> <?php echo $cat_title; ?> </li>

<li> <?php echo $child_title; ?> </li>

</ul>

</div><!-- request-description Ends -->

</td>

<td><?php echo $count_send_offers; ?></td>

<td> <?php echo $request_date; ?> </td>

<td> 

<?php echo $delivery_time; ?> <a href="#" class="remove-link remove_request_<?php echo $request_id; ?>"> Remove Request </a>

</td>

<td class="text-success font-weight-bold">

$<?php if(!empty($request_budget)){ ?> 

<?php echo $request_budget; ?>

<?php }else{ ?>

---

<?php } ?>

<br>

<?php if($login_seller_offers == "0"){ ?>

<button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>" data-toggle="modal" data-target="#quota-finish">
Send Offer
</button>

<?php }else{ ?>

<button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>">
Send Offer
</button>

<?php } ?>

</td>


<script>

$(".send_button_<?php echo $request_id; ?>").css("visibility","hidden");

$(".remove_request_<?php echo $request_id; ?>").css("visibility","hidden");


$(document).on("mouseenter", "#request_tr_<?php echo $request_id; ?>", function(){
	
	$(".send_button_<?php echo $request_id; ?>").css("visibility","visible");
	
	$(".remove_request_<?php echo $request_id; ?>").css("visibility","visible");
	
});

$(document).on("mouseleave", "#request_tr_<?php echo $request_id; ?>", function(){
	
	$(".send_button_<?php echo $request_id; ?>").css("visibility","hidden");
	
	$(".remove_request_<?php echo $request_id; ?>").css("visibility","hidden");
	
});

$(".remove_request_<?php echo $request_id; ?>").click(function(event){
	
	event.preventDefault();
	
	$("#request_tr_<?php echo $request_id; ?>").fadeOut().remove();
	
});


<?php if($login_seller_offers == "0"){ ?>


<?php }else{ ?>

$(".send_button_<?php echo $request_id; ?>").click(function(){
	
request_id = "<?php echo $request_id; ?>";
	
$.ajax({
	
method: "POST",
url: "send_offer_modal.php",
data: {request_id: request_id}
})
.done(function(data){
	
$(".append-modal").html(data);
	
});
	
});

<?php } ?>

</script>

</tr>

<?php 

}

}


?>


