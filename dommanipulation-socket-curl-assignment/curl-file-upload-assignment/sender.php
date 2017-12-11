<?php

$target_url = 'http://127.0.0.1/curl-file-upload-assignment/receiver.php';

$file_name_with_full_path = "/home/webonise/flower.jpeg";
$post = array('file_contents'=>'@'.$file_name_with_full_path);
        
$ch = curl_init();
        
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

$result=curl_exec ($ch);
curl_close ($ch);
echo $result;
?>