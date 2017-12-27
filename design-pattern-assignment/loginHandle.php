<?php
require 'databaseHandle.php';

$username=$_POST['username'];
$password=$_POST['password'];

/*$dbDetails=array("dbName"=>"book_management","dbHost"=>"localhost","dbUser"=>"root","dbPassword"=>"db123");

$mysqlDBInstance=MysqlDBConnection::connect($dbDetails);

if($mysqlDBInstance->isValidUsernamePassword($username,$password)){
	$mysqlDBInstance->disConnect();
	session_start();
	$_SESSION['session_id']=session_id();
	$_SESSION['db_instance']=$mysqlDBInstance;
	header('Location:http://127.0.0.1/design-pattern-assignment/home.php');
} else{
	$mysqlDBInstance->disConnect();
	header('Location:http://127.0.0.1/design-pattern-assignment/index.php');
}*/

$dbDetails=array("dbName"=>"book_management","dbHost"=>"localhost","dbUser"=>"postgres","dbPassword"=>"123");

$pgsqlDBInstance=PgsqlDBConnection::connect($dbDetails);
if($pgsqlDBInstance->isValidUsernamePassword($username,$password)){
	$pgsqlDBInstance->disConnect();
	session_start();
	$_SESSION['session_id']=session_id();
	$_SESSION['db_instance']=$pgsqlDBInstance;
	header('Location:http://127.0.0.1/design-pattern-assignment/home.php');
} else{
	$mysqlDBInstance->disConnect();
	header('Location:http://127.0.0.1/design-pattern-assignment/index.php');
}

?>