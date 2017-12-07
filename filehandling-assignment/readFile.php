<?php
	$fp=fopen($_POST['filename'], "r");
	if($fp==false){
		echo "Unable to read file";
	}
	else{
		echo fread($fp,filesize($_POST['filename']));
		fclose($fp);
	}
?>