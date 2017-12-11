<?php
	$error_no=$_FILES['filename']['error'];
	
	switch ($error_no) {
		case 0:
			echo "File uploaded successfully";
			$tmp = $_FILES['upload']['tmp_name'];
			if (file_exists($tmp) && is_file($tmp)){
				unlink($tmp);
			}
			echo "temp file deleted";
			break;
		case 1:
			echo "File upload size exceeds";
			break;
		case 2:
			echo "File size exceeds max_file_size in form";
			break;
		case 3:
			echo "3";
			break;
		case 4:
			echo "No file was uploaded";
			break;
		default:
			echo $error_no;
			break;
	}
?>