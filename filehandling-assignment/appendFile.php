<?php
	$fp=fopen($_POST['filename'], "a");
	if($fp==false){
		echo "Unable to append data";
	}
	else{
		fwrite($fp, $_POST['data']);
		fclose($fp);
		echo "Data appended";
	}
?>