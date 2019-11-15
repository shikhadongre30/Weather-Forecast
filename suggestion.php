<?php
	include 'classes.php';
	$suggest = new Classes;
	$city = $_POST['city_name'];
	if(strlen($city)>=4){
			$suggest->suggestionJSON($city);
	}
?>