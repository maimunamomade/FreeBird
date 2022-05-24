<?php

session_start();

include("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login.php','_self')</script>";
	
}


echo "<option value=''> Select A Sub Category </option>";

$category_id = $_POST['category_id'];

$get_c_cats = "select * from categories_childs where child_parent_id='$category_id'";

$run_c_cats = mysqli_query($con,$get_c_cats);

while($row_c_cats = mysqli_fetch_array($run_c_cats)){
	
$child_id = $row_c_cats['child_id'];

$child_title = $row_c_cats['child_title'];

echo "<option value='$child_id'> $child_title </option>";
	
}

?>