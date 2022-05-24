<?php

session_start();

include("includes/db.php");

include("functions/functions.php");

switch ($_REQUEST['zAction']) {

	default:

		get_category_proposals();

		break;

	case "get_category_pagination":

		get_category_pagination();

		break;
}
 