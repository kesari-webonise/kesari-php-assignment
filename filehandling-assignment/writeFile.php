<?php
	$fp=fopen($_POST['filename'], "w");
	if($fp==false){
		echo "Unable to write data";
	}
	else{
		fwrite($fp, $_POST['data']);
		fclose($fp);
		echo "Data written";
	}
?>