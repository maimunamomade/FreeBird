<?php

if (isset($_SESSION['seller_user_name'])) {

	$login_seller_user_name = $_SESSION['seller_user_name'];

	$select_login_seller = "select * from sellers where seller_user_name='$login_seller_user_name'";

	$run_login_seller = mysqli_query($con, $select_login_seller);

	$row_login_seller = mysqli_fetch_array($run_login_seller);

	$login_seller_id = $row_login_seller['seller_id'];
}

/// get_search_proposals Function starts ///

function get_search_proposals()
{

	global $con;

	global $login_seller_id;

	$search_query = $_SESSION['search_query'];

	$online_sellers = array();

	$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active'";

	$run_proposals = mysqli_query($con, $get_proposals);

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_status = $row_seller['seller_status'];

		if ($seller_status == "online") {

			array_push($online_sellers, $proposal_seller_id);
		}
	}

	$where_online = array();

	$where_cat = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	if (isset($_REQUEST['online_sellers'])) {

		foreach ($_REQUEST['online_sellers'] as $value) {

			if ($value != 0) {

				foreach ($online_sellers as $seller_id) {

					$where_online[] = "proposal_seller_id=" . $seller_id;
				}
			}
		}
	}

	if (isset($_REQUEST['cat_id'])) {

		foreach ($_REQUEST['cat_id'] as $value) {

			if ($value != 0) {

				$where_cat[] = "proposal_cat_id=" . $value;
			}
		}
	}

	if (isset($_REQUEST['delivery_time'])) {

		foreach ($_REQUEST['delivery_time'] as $value) {

			if ($value != 0) {

				$where_delivery_times[] = "delivery_id=" . $value;
			}
		}
	}

	if (isset($_REQUEST['seller_level'])) {

		foreach ($_REQUEST['seller_level'] as $value) {

			if ($value != 0) {

				$where_level[] = "level_id=" . $value;
			}
		}
	}

	if (isset($_REQUEST['seller_language'])) {

		foreach ($_REQUEST['seller_language'] as $value) {

			if ($value != 0) {

				$where_language[] = "language_id=" . $value;
			}
		}
	}

	$query_where = "where proposal_title like '%$search_query%' AND proposal_status='active' ";

	if (count($where_online) > 0) {

		$query_where .= " and (" . implode(" or ", $where_online) . ")";
	}

	if (count($where_cat) > 0) {

		$query_where .= " and (" . implode(" or ", $where_cat) . ")";
	}

	if (count($where_delivery_times) > 0) {

		$query_where .= " and (" . implode(" or ", $where_delivery_times) . ")";
	}

	if (count($where_level) > 0) {

		$query_where .= " and (" . implode(" or ", $where_level) . ")";
	}

	if (count($where_language) > 0) {

		$query_where .= " and (" . implode(" or ", $where_language) . ")";
	}

	$per_page = 9;

	if (isset($_GET['page'])) {

		$page = $_GET['page'];
	} else {

		$page = 1;
	}

	$start_from = ($page - 1) * $per_page;

	$where_limit = " order by proposal_featured='yes' DESC LIMIT $start_from,$per_page";

	$get_proposals = "select * from proposals " . $query_where . $where_limit;

	$run_proposals = mysqli_query($con, $get_proposals);

	$count_proposals = mysqli_num_rows($run_proposals);

	if ($count_proposals == 0) {

		echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'> We Have Not Found Any Proposals </h1>
	
	</div>
	
	
	";
	}

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {


		$proposal_id = $row_proposals['proposal_id'];

		$proposal_title = $row_proposals['proposal_title'];

		$proposal_price = $row_proposals['proposal_price'];

		$proposal_img1 = $row_proposals['proposal_img1'];

		$proposal_video = $row_proposals['proposal_video'];

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$proposal_rating = $row_proposals['proposal_rating'];

		$proposal_url = $row_proposals['proposal_url'];

		$proposal_featured = $row_proposals['proposal_featured'];

		if (empty($proposal_video)) {

			$video_class = "";
		} else {

			$video_class = "video-img";
		}

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_user_name = $row_seller['seller_user_name'];

		$select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

		$run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

		$count_reviews = mysqli_num_rows($run_buyer_reviews);

		$select_favorites = "select * from favorites where proposal_id='$proposal_id' AND seller_id='$login_seller_id'";

		$run_favorites = mysqli_query($con, $select_favorites);

		$count_favorites = mysqli_num_rows($run_favorites);

		if ($count_favorites == 0) {

			$show_favorite_id = "favorite_$proposal_id";

			$show_favorite_class = "favorite";
		} else {

			$show_favorite_id = "unfavorite_$proposal_id";

			$show_favorite_class = "favorited";
		}

		?>


<!-- col-lg-4 col-md-6 col-sm-6 starts -->
<div class="col-lg-4 col-md-6 col-sm-6">

    <!--- proposal-div starts -->
    <div class="proposal-div">

        <!-- proposal_nav starts -->
        <div class="proposal_nav">

            <span class="float-left mt-2">

                <strong class="ml-2 mr-1">

                    By

                </strong>

                <?php echo $seller_user_name; ?>

            </span>

            <!-- float-right mt-2 starts -->
            <span class="float-right mt-2">

                <?php

				for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

					echo " <img class='rating' src='images/user_rate_full.png' > ";
				}

				for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

					echo " <img class='rating' src='images/user_rate_blank.png' > ";
				}


				?>

                <span class="ml-1 mr-2">(<?php echo $count_reviews; ?>) Reviews </span>

            </span>
            <!-- float-right mt-2 ends -->

            <div class="clearfix mb-2"> </div>

        </div>
        <!-- proposal_nav ends -->

        <a href="proposals/<?php echo $proposal_url; ?>">

            <hr class="m-0 p-0">

            <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">

        </a>

        <!-- text starts -->
        <div class="text">

            <h4>

                <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                    <?php echo $proposal_title; ?>

                </a>

            </h4>

            <hr>

            <!-- buttons clearfix starts -->
            <p class="buttons clearfix">

                <?php if (!isset($_SESSION['seller_user_name'])) { ?>

                <a href="login.php" class="favorite mt-2 float-left" data-toggle="tooltip" title="Add To Favorites">

                    <i class="fa fa-heart fa-lg"></i>

                </a>

                <?php 
			} else { ?>

                <a href="#" id="<?php echo $show_favorite_id; ?>" class="<?php echo $show_favorite_class; ?> mt-2 float-left" data-toggle="tooltip" title="Favorites">

                    <i class="fa fa-heart fa-lg"></i>

                </a>

                <?php 
			} ?>

                <span class="float-right"> STARTING AT <strong class="price">₹<?php echo $proposal_price; ?></strong> </span>

            </p>
            <!-- buttons clearfix ends -->

        </div>
        <!-- text ends -->

        <?php if ($proposal_featured == "yes") { ?>

        <!-- ribbon starts -->
        <div class="ribbon">

            <div class="theribbon"> Featured </div>

            <div class="ribbon-background"> </div>

        </div>
        <!-- ribbon ends -->

        <?php 
	} ?>

        <?php if (isset($_SESSION['seller_user_name'])) { ?>

        <script>
            $(document).on("click", "#favorite_<?php echo $proposal_id; ?>", function(event) {

                event.preventDefault();

                var seller_id = "<?php echo $login_seller_id; ?>";

                var proposal_id = "<?php echo $proposal_id; ?>";

                $.ajax({

                    type: "POST",
                    url: "includes/add_delete_favorite.php",
                    data: {
                        seller_id: seller_id,
                        proposal_id: proposal_id,
                        favorite: "add_favorite"
                    },
                    success: function() {

                        $("#favorite_<?php echo $proposal_id; ?>").attr({

                            id: "unfavorite_<?php echo $proposal_id; ?>",
                            class: "favorited mt-2 float-left"


                        });

                    }

                });


            });

            $(document).on("click", "#unfavorite_<?php echo $proposal_id; ?>", function(event) {

                event.preventDefault();

                var seller_id = "<?php echo $login_seller_id; ?>";

                var proposal_id = "<?php echo $proposal_id; ?>";

                $.ajax({

                    type: "POST",
                    url: "includes/add_delete_favorite.php",
                    data: {
                        seller_id: seller_id,
                        proposal_id: proposal_id,
                        favorite: "delete_favorite"
                    },
                    success: function() {

                        $("#unfavorite_<?php echo $proposal_id; ?>").attr({

                            id: "favorite_<?php echo $proposal_id; ?>",
                            class: "favorite mt-2 float-left"


                        });

                    }


                });


            });
        </script>

        <?php 
	} ?>

    </div>
    <!--- proposal-div ends -->

</div>
<!-- col-lg-4 col-md-6 col-sm-6 ends -->

<?php	
}
}

/// get_search_proposals Function Ends ///


/// get_search_pagination Function Starts ///

function get_search_pagination()
{

	global $con;

	$search_query = $_SESSION['search_query'];

	$online_sellers = array();

	$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_title like '%$search_query%' AND proposal_status='active'";

	$run_proposals = mysqli_query($con, $get_proposals);

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_status = $row_seller['seller_status'];

		if ($seller_status == "online") {

			array_push($online_sellers, $proposal_seller_id);
		}
	}

	$where_online = array();

	$where_cat = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	$where_path = "";

	if (isset($_REQUEST['online_sellers'])) {

		foreach ($_REQUEST['online_sellers'] as $value) {

			if ($value != 0) {

				foreach ($online_sellers as $seller_id) {

					$where_online[] = "proposal_seller_id=" . $seller_id;
				}

				$where_path .= "online_sellers[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['cat_id'])) {

		foreach ($_REQUEST['cat_id'] as $value) {

			if ($value != 0) {

				$where_cat[] = "proposal_cat_id=" . $value;

				$where_path .= "cat_id[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['delivery_time'])) {

		foreach ($_REQUEST['delivery_time'] as $value) {

			if ($value != 0) {

				$where_delivery_times[] = "delivery_id=" . $value;

				$where_path .= "delivery_time[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['seller_level'])) {

		foreach ($_REQUEST['seller_level'] as $value) {

			if ($value != 0) {

				$where_level[] = "level_id=" . $value;

				$where_path .= "seller_level[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['seller_language'])) {

		foreach ($_REQUEST['seller_language'] as $value) {

			if ($value != 0) {

				$where_language[] = "language_id=" . $value;

				$where_path .= "seller_language[]=" . $value . "&";
			}
		}
	}

	$query_where = "where proposal_title like '%$search_query%' AND proposal_status='active' ";

	if (count($where_online) > 0) {

		$query_where .= " and (" . implode(" or ", $where_online) . ")";
	}

	if (count($where_cat) > 0) {

		$query_where .= " and (" . implode(" or ", $where_cat) . ")";
	}

	if (count($where_delivery_times) > 0) {

		$query_where .= " and (" . implode(" or ", $where_delivery_times) . ")";
	}

	if (count($where_level) > 0) {

		$query_where .= " and (" . implode(" or ", $where_level) . ")";
	}

	if (count($where_language) > 0) {

		$query_where .= " and (" . implode(" or ", $where_language) . ")";
	}

	$per_page = 9;

	$get_proposals = "select * from proposals " . $query_where;

	$run_proposals = mysqli_query($con, $get_proposals);

	$count_proposals = mysqli_num_rows($run_proposals);

	if ($count_proposals > 0) {

		$total_pages = ceil($count_proposals / $per_page);

		echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='search.php?page=1&$where_path'>
	
	First Page
	
	</a>
	
	</li>
	
	";

		for ($i = 1; $i <= $total_pages; $i++) {

			if ($i == @$_GET['page']) {

				$active = "active";
			} else {

				$active = "";
			}

			echo "
	
	<li class='page-item $active'>
	
	<a class='page-link' href='search.php?page=$i&$where_path'>
	
	$i
	
	</a>
	
	</li>
	
	";
		}

		echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='search.php?page=$total_pages&$where_path'>
	
	Last Page
	
	</a>
	
	</li>
	
	";
	}
}


/// get_search_pagination Function ends ///



/// get_category_proposals Function starts ///

function get_category_proposals()
{

	global $con;

	global $login_seller_id;

	$online_sellers = array();

	if (isset($_SESSION['cat_id'])) {

		$session_cat_id = $_SESSION['cat_id'];

		$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_cat_id='$session_cat_id' AND proposal_status='active'";
	} elseif (isset($_SESSION['cat_child_id'])) {

		$session_cat_child_id = $_SESSION['cat_child_id'];

		$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_child_id='$session_cat_child_id' AND proposal_status='active'";
	}

	$run_proposals = mysqli_query($con, $get_proposals);

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_status = $row_seller['seller_status'];

		if ($seller_status == "online") {

			array_push($online_sellers, $proposal_seller_id);
		}
	}

	$where_online = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	if (isset($_REQUEST['online_sellers'])) {

		foreach ($_REQUEST['online_sellers'] as $value) {

			if ($value != 0) {

				foreach ($online_sellers as $seller_id) {

					$where_online[] = "proposal_seller_id=" . $seller_id;
				}
			}
		}
	}

	if (isset($_REQUEST['delivery_time'])) {

		foreach ($_REQUEST['delivery_time'] as $value) {

			if ($value != 0) {

				$where_delivery_times[] = "delivery_id=" . $value;
			}
		}
	}

	if (isset($_REQUEST['seller_level'])) {

		foreach ($_REQUEST['seller_level'] as $value) {

			if ($value != 0) {

				$where_level[] = "level_id=" . $value;
			}
		}
	}

	if (isset($_REQUEST['seller_language'])) {

		foreach ($_REQUEST['seller_language'] as $value) {

			if ($value != 0) {

				$where_language[] = "language_id=" . $value;
			}
		}
	}

	if (isset($_SESSION['cat_id'])) {

		$query_where = "where proposal_cat_id='$session_cat_id' AND proposal_status='active' ";
	} elseif (isset($_SESSION['cat_child_id'])) {

		$query_where = "where proposal_child_id='$session_cat_child_id' AND proposal_status='active' ";
	}

	if (count($where_online) > 0) {

		$query_where .= " and (" . implode(" or ", $where_online) . ")";
	}

	if (count($where_delivery_times) > 0) {

		$query_where .= " and (" . implode(" or ", $where_delivery_times) . ")";
	}

	if (count($where_level) > 0) {

		$query_where .= " and (" . implode(" or ", $where_level) . ")";
	}

	if (count($where_language) > 0) {

		$query_where .= " and (" . implode(" or ", $where_language) . ")";
	}

	$per_page = 9;

	if (isset($_GET['page'])) {

		$page = $_GET['page'];
	} else {

		$page = 1;
	}

	$start_from = ($page - 1) * $per_page;

	$where_limit = " order by proposal_featured='yes' DESC LIMIT $start_from,$per_page";

	$get_proposals = "select * from proposals " . $query_where . $where_limit;

	$run_proposals = mysqli_query($con, $get_proposals);

	$count_proposals = mysqli_num_rows($run_proposals);

	if ($count_proposals == 0) {

		if (isset($_SESSION['cat_id'])) {

			echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'> We Have Not Found Any Proposals In This Category. </h1>
	
	</div>
	
	
	";
		} elseif (isset($_SESSION['cat_child_id'])) {

			echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'> We Have Not Found Any Proposals In This Sub Category. </h1>
	
	</div>
	
	
	";
		}
	}

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {


		$proposal_id = $row_proposals['proposal_id'];

		$proposal_title = $row_proposals['proposal_title'];

		$proposal_price = $row_proposals['proposal_price'];

		$proposal_img1 = $row_proposals['proposal_img1'];

		$proposal_video = $row_proposals['proposal_video'];

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$proposal_rating = $row_proposals['proposal_rating'];

		$proposal_url = $row_proposals['proposal_url'];

		$proposal_featured = $row_proposals['proposal_featured'];

		if (empty($proposal_video)) {

			$video_class = "";
		} else {

			$video_class = "video-img";
		}

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_user_name = $row_seller['seller_user_name'];

		$select_buyer_reviews = "select * from buyer_reviews where proposal_id='$proposal_id'";

		$run_buyer_reviews = mysqli_query($con, $select_buyer_reviews);

		$count_reviews = mysqli_num_rows($run_buyer_reviews);

		$select_favorites = "select * from favorites where proposal_id='$proposal_id' AND seller_id='$login_seller_id'";

		$run_favorites = mysqli_query($con, $select_favorites);

		$count_favorites = mysqli_num_rows($run_favorites);

		if ($count_favorites == 0) {

			$show_favorite_id = "favorite_$proposal_id";

			$show_favorite_class = "favorite";
		} else {

			$show_favorite_id = "unfavorite_$proposal_id";

			$show_favorite_class = "favorited";
		}

		?>

<!-- col-lg-4 col-md-6 col-sm-6 starts -->
<div class="col-lg-4 col-md-6 col-sm-6">

    <!--- proposal-div starts -->
    <div class="proposal-div">

        <!-- proposal_nav starts -->
        <div class="proposal_nav">

            <span class="float-left mt-2">

                <strong class="ml-2 mr-1">

                    By

                </strong>

                <?php echo $seller_user_name; ?>

            </span>


            <!-- float-right mt-2 starts -->
            <span class="float-right mt-2">

                <?php

				for ($proposal_i = 0; $proposal_i < $proposal_rating; $proposal_i++) {

					echo " <img class='rating' src='images/user_rate_full.png' > ";
				}

				for ($proposal_i = $proposal_rating; $proposal_i < 5; $proposal_i++) {

					echo " <img class='rating' src='images/user_rate_blank.png' > ";
				}


				?>

                <span class="ml-1 mr-2">(<?php echo $count_reviews; ?>) Reviews
                </span>

            </span>
            <!-- float-right mt-2 ends -->

            <div class="clearfix mb-2"> </div>

        </div>
        <!-- proposal_nav ends -->

        <a href="proposals/<?php echo $proposal_url; ?>">

            <hr class="m-0 p-0">

            <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="resp-img">

        </a>

        <!-- text starts -->
        <div class="text">

            <h4>

                <a href="proposals/<?php echo $proposal_url; ?>" class="<?php echo $video_class; ?>">

                    <?php echo $proposal_title; ?>

                </a>

            </h4>

            <hr>

            <!-- buttons clearfix starts -->
            <p class="buttons clearfix">

                <?php if (!isset($_SESSION['seller_user_name'])) { ?>

                <a href="login.php" class="favorite mt-2 float-left" data-toggle="tooltip" title="Favorites">

                    <i class="fa fa-heart fa-lg"></i>

                </a>

                <?php 
			} else { ?>

                <a href="#" id="<?php echo $show_favorite_id; ?>" class="<?php echo $show_favorite_class; ?> mt-2 float-left" data-toggle="tooltip" title="Favorites">

                    <i class="fa fa-heart fa-lg"></i>

                </a>

                <?php 
			} ?>

                <span class="float-right"> STARTING AT <strong class="price">₹<?php echo $proposal_price; ?></strong> </span>

            </p><!-- buttons clearfix Ends -->

        </div><!-- text Ends -->

        <?php if ($proposal_featured == "yes") { ?>

        <div class="ribbon">
            <!-- ribbon Starts -->

            <div class="theribbon"> Featured </div>

            <div class="ribbon-background"> </div>

        </div><!-- ribbon Ends -->

        <?php 
	} ?>

        <?php if (isset($_SESSION['seller_user_name'])) { ?>

        <script>
            $(document).on("click", "#favorite_<?php echo $proposal_id; ?>", function(event) {

                event.preventDefault();

                var seller_id = "<?php echo $login_seller_id; ?>";

                var proposal_id = "<?php echo $proposal_id; ?>";

                $.ajax({

                    type: "POST",
                    url: "includes/add_delete_favorite.php",
                    data: {
                        seller_id: seller_id,
                        proposal_id: proposal_id,
                        favorite: "add_favorite"
                    },
                    success: function() {

                        $("#favorite_<?php echo $proposal_id; ?>").attr({

                            id: "unfavorite_<?php echo $proposal_id; ?>",
                            class: "favorited mt-2 float-left"


                        });

                    }

                });

            });

            $(document).on("click", "#unfavorite_<?php echo $proposal_id; ?>", function(event) {

                event.preventDefault();

                var seller_id = "<?php echo $login_seller_id; ?>";

                var proposal_id = "<?php echo $proposal_id; ?>";

                $.ajax({

                    type: "POST",
                    url: "includes/add_delete_favorite.php",
                    data: {
                        seller_id: seller_id,
                        proposal_id: proposal_id,
                        favorite: "delete_favorite"
                    },
                    success: function() {

                        $("#unfavorite_<?php echo $proposal_id; ?>").attr({

                            id: "favorite_<?php echo $proposal_id; ?>",
                            class: "favorite mt-2 float-left"


                        });

                    }

                });

            });
        </script>

        <?php 
	} ?>

    </div>
    <!--- proposal-div ends -->

</div>
<!-- col-lg-4 col-md-6 col-sm-6 ends -->

<?php	
}
}

/// get_category_proposals Function ends ///


/// get_category_pagination Function starts ///

function get_category_pagination()
{

	global $con;

	$online_sellers = array();

	if (isset($_SESSION['cat_id'])) {

		$session_cat_id = $_SESSION['cat_id'];

		$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_cat_id='$session_cat_id' AND proposal_status='active'";
	} elseif (isset($_SESSION['cat_child_id'])) {

		$session_cat_child_id = $_SESSION['cat_child_id'];

		$get_proposals = "select DISTINCT proposal_seller_id from proposals where proposal_child_id='$session_cat_child_id' AND proposal_status='active'";
	}

	$run_proposals = mysqli_query($con, $get_proposals);

	while ($row_proposals = mysqli_fetch_array($run_proposals)) {

		$proposal_seller_id = $row_proposals['proposal_seller_id'];

		$select_seller = "select * from sellers where seller_id='$proposal_seller_id'";

		$run_seller = mysqli_query($con, $select_seller);

		$row_seller = mysqli_fetch_array($run_seller);

		$seller_status = $row_seller['seller_status'];

		if ($seller_status == "online") {

			array_push($online_sellers, $proposal_seller_id);
		}
	}

	$where_online = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	$where_path = "";

	if (isset($_REQUEST['online_sellers'])) {

		foreach ($_REQUEST['online_sellers'] as $value) {

			if ($value != 0) {

				foreach ($online_sellers as $seller_id) {

					$where_online[] = "proposal_seller_id=" . $seller_id;
				}

				$where_path .= "online_sellers[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['delivery_time'])) {

		foreach ($_REQUEST['delivery_time'] as $value) {

			if ($value != 0) {

				$where_delivery_times[] = "delivery_id=" . $value;

				$where_path .= "delivery_time[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['seller_level'])) {

		foreach ($_REQUEST['seller_level'] as $value) {

			if ($value != 0) {

				$where_level[] = "level_id=" . $value;

				$where_path .= "seller_level[]=" . $value . "&";
			}
		}
	}

	if (isset($_REQUEST['seller_language'])) {

		foreach ($_REQUEST['seller_language'] as $value) {

			if ($value != 0) {

				$where_language[] = "language_id=" . $value;

				$where_path .= "seller_language[]=" . $value . "&";
			}
		}
	}

	if (isset($_SESSION['cat_id'])) {

		$query_where = "where proposal_cat_id='$session_cat_id' AND proposal_status='active' ";
	} elseif (isset($_SESSION['cat_child_id'])) {

		$query_where = "where proposal_child_id='$session_cat_child_id' AND proposal_status='active' ";
	}

	if (count($where_online) > 0) {

		$query_where .= " and (" . implode(" or ", $where_online) . ")";
	}

	if (count($where_delivery_times) > 0) {

		$query_where .= " and (" . implode(" or ", $where_delivery_times) . ")";
	}

	if (count($where_level) > 0) {

		$query_where .= " and (" . implode(" or ", $where_level) . ")";
	}

	if (count($where_language) > 0) {

		$query_where .= " and (" . implode(" or ", $where_language) . ")";
	}

	$per_page = 9;

	$get_proposals = "select * from proposals " . $query_where;

	$run_proposals = mysqli_query($con, $get_proposals);

	$count_proposals = mysqli_num_rows($run_proposals);

	if ($count_proposals > 0) {

		$total_pages = ceil($count_proposals / $per_page);

		echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='category.php?page=1&$where_path'>
	
	First Page
	
	</a>
	
	</li>
	
	";

		for ($i = 1; $i <= $total_pages; $i++) {

			if ($i == @$_GET['page']) {

				$active = "active";
			} else {

				$active = "";
			}

			echo "
	
	<li class='page-item $active'>
	
	<a class='page-link' href='category.php?page=$i&$where_path'>
	
	$i
	
	</a>
	
	</li>
	
	";
		}

		echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='category.php?page=$total_pages&$where_path'>
	
	Last Page
	
	</a>
	
	</li>
	
	";
	}
}

/// get_category_pagination Function ends ///

?> 