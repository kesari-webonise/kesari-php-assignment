<?php
	$_FILES['filename']['name'];
	$tmp=$_FILES['filename']['tmp_name'];
	if($_FILES['filename']["error"]>0){
			echo $_FILES['filename']["error"];
	} else{
		$dst="/var/www/html/filehandling-assignment/{$_FILES['filename']['name']}";
			if(move_uploaded_file($tmp, $dst)){
				$fp=fopen($_FILES['filename']['name'],'a');
				if($fp==false){
					echo "unable to append";
				}else{
					fwrite($fp,$_POST['data']);
					echo "Data appended";
					fclose($fp);
				}
			} else{
				echo "Unable to upload";
			}
	}
?>