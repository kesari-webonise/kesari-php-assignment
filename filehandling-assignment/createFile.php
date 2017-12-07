<?php
	$fp=fopen($_POST['filename'], "w");
	if($fp==false){
		echo "Unable to create file";
	}
	else{
		fclose($fp);
		echo "File created";
	}
?>