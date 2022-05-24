<?php

session_start();

include("includes/db.php");

include("functions/functions.php");

switch($_REQUEST['zAction']){
	
	default:
	
	get_search_proposals();
	
	break;
	
	case "get_search_pagination":
	
	get_search_pagination();
	
	break;
	
}

?>