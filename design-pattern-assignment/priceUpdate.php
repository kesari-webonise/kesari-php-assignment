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
	$bookPrice=$_POST['bookPrice'];

	if($bookName=="none" or $bookPrice<=0){
		echo "Please select book name or enter valid price";
	} else {
		if(isset($_POST['buttonUSD'])) {
			$bookPrice/=0.016;
		} else if(isset($_POST['buttonEuro'])) {
			$bookPrice/=0.013;
		}
		$dbInstance->setPrice($bookName,$bookPrice);
		header('Location:http://127.0.0.1/design-pattern-assignment/home.php');
	}
}
?>

<html>
	<head>
		<title>Error</title>
	</head>
	<body>
		<a href="home.php">Back to Home</a>
		<form method="post" action="logoutHandle.php">
			<input type="submit" value="Logout">
		</form>
	</body>
</html>