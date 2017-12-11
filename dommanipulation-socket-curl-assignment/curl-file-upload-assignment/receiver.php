<?php
$uploaddir = "/var/www/html/curl-file-upload-assignment/";

$uploadfile = $uploaddir.$_FILES['file_contents']['name'];

echo "<pre>";
$status_code=http_response_code();

echo "Request type : ".$_SERVER['REQUEST_METHOD']."\n";

switch ($status_code) {
	case 200:
		echo "Status Message : Success.\n";
		if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
	    	echo "File was successfully uploaded.\n";
		} else {
	    	echo "Unable to upload\n";
		}	
		break;
	case 500:
		echo "Status Message : Error.\n";
		break;
	case 400:
		echo "Status Message : Bad Request.\n";
		break;
	case 404:
		echo "Status Message : Resource not found.\n";
		break;
	default:
		echo "Status code : ".$status_code."\n";
		break;
}
echo "</pre>";
?>