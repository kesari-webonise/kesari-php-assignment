<?php

$host = "127.0.0.1";
$port = 2000;
set_time_limit(0);

if(($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))==false){
	echo "Could not create socket\n";
	exit(1);
} 
echo "Socket created\n";

if(($bind = socket_bind($socket, $host, $port))==false){
	echo "Could not bind to socket\n";
	exit(1);
}
echo "Socket binded\n";

if(($bind = socket_listen($socket, 3))==false){
	echo "Could not set up socket listener\n";
	exit(1);
} 
echo "Server listening\n";

if(($connection = socket_accept($socket))==false){
	echo "Could not accept incoming connection\n";
	exit(1);
} 
echo "Client connected\n";

if(($input = socket_read($connection, 1024))==false){
	echo "Could not read input\n";
	exit(1);
} 
//echo "Client Message : ".$input;
$input=trim($input);
$output = $input;
$characters=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$key=3;
for($ptrToData=0;$ptrToData<strlen($input);$ptrToData++) {
		if(in_array($input[$ptrToData], $characters)) {
			$index=array_search($input[$ptrToData], $characters);
			$output[$ptrToData]=$characters[($index+$key)%26];
		} else {
			$output[$ptrToData]=$input[$ptrToData];
		}
	}
// print_r( $output);

if(socket_write($connection, $output, strlen ($output))==false){
	echo "Could not write output\n";
	exit(1);
} 

socket_close($connection);
socket_close($socket);
?>