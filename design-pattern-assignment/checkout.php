<?php
require "databaseHandle.php";
$dbInstance=null;
session_start();
if(!isset($_SESSION['session_id'])){
	session_destroy();
	header('Location:http://127.0.0.1/design-pattern-assignment/index.php');
} else {
	if(is_a($_SESSION['db_instance'],"MysqlDBConnection")){
		$dbDetails=array("dbName"=>"book_management","dbHost"=>"localhost","dbUser"=>"root","dbPassword"=>"db123");
		$dbInstance=MysqlDBConnection::connect($dbDetails);
	} else if(is_a($_SESSION['db_instance'],"PgsqlDBConnection")){
		$dbDetails=array("dbName"=>"book_management","dbHost"=>"localhost","dbUser"=>"postgres","dbPassword"=>"123");
		$dbInstance=PgsqlDBConnection::connect($dbDetails);
	}
	else{
		echo "Invalid database instance";
		header('Location:http://127.0.0.1/design-pattern-assignment/index.php');
	}

	$bookName=$_POST['bookName'];
	$bookQuantity=$_POST['bookQuantity'];

	if($bookName=="none" or $bookQuantity<=0){
		echo "Please select book name or proper quantity";
	} else if($bookQuantity>$dbInstance->getBookQuantity($bookName)){
		echo $bookQuantity." quantity not available";
	} else {
		$price=$dbInstance->getPrice($bookName);
		$dbInstance->reduceQuantity($bookName,$bookQuantity);
		echo "<pre>";
		echo ":----------Bill----------:\n";
		echo "Book Name   : ".$bookName."\n";
		echo "Quantity    : ".$bookQuantity."\n";
		echo "Total Price : ".$price*$bookQuantity."\n";
		echo "</pre>";
	}
}
?>
<html>
	<head>
		<title>Billing Page</title>
	</head>
	<body>
		<a href="home.php">Back to Home</a>
		<form method="post" action="logoutHandle.php">
			<input type="submit" value="Logout">
		</form>
	</body>
</html>