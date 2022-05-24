<?php

session_start();

include("includes/db.php");

$get_general_settings = "select * from general_settings";

$run_general_settings = mysqli_query($con, $get_general_settings);

$row_general_settings = mysqli_fetch_array($run_general_settings);

$site_title = $row_general_settings["site_title"];

$site_desc = $row_general_settings["site_desc"];

$site_keywords = $row_general_settings["site_keywords"];

$site_author = $row_general_settings["site_author"];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title> <?php echo $site_title; ?> </title>

    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="Author" content="<?php echo $site_author; ?>">

    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <link href="styles/category_nav_style.css" rel="stylesheet">
    <!-- Stylesheet With Modifications -->
    <link href="styles/custom.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <script src="js/jquery.min.js"> </script>
</head>

<body>
    <?php include("includes/header.php"); ?>

    <?php

    if (!isset($_SESSION['seller_user_name'])) {

        include("home.php");
    } else {

        include("user_home.php");
    }

    ?>

    <?php include("includes/footer.php"); ?>


</body>

</html>