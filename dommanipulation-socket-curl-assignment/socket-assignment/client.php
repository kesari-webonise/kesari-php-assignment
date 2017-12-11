<?php
$host    = "127.0.0.1";
$port    = 2000;

$message = "ana, I hate you. alice";

echo "Message To server :".$message;

if(($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))==false){
	echo "Could not create socket\n";
	exit(1);
} 
echo "Socket created\n";

if(socket_connect($socket, $host, $port)==false){
	echo "Could not connect to server\n";
	exit(1);
}  
echo "Server Connected\n";

if(socket_write($socket, $message, strlen($message))==false){
	echo "Could not send data to server\n";
	exit(1);
} 
echo "Data sent to server\n";

if(($result = socket_read ($socket, 1024))==false){
	echo "Could not read server response\n";
	exit(1);
}
echo "Reply From Server  :".$result."\n";

socket_close($socket);
?>