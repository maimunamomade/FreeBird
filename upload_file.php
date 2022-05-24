<?php

if(isset($_FILES["file"]["name"])){
	
$file = $_FILES["file"]["name"];

$file_tmp = $_FILES["file"]["tmp_name"];
	

$allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
	
$file_extension = pathinfo($file, PATHINFO_EXTENSION);

if(!in_array($file_extension,$allowed)){
	
echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	
}else{
	
	move_uploaded_file($file_tmp, "order_files/$file");
	
}
	
	
}


?>