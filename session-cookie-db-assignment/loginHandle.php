<?php
$servername="localhost";
$dbusername="root";
$dbpassword="db123";
$dbname="login_details_db";

$username=$_POST['username'];
$password=$_POST['password'];

try{
	$conn=new PDO("mysql:host=$servername;dbname=$dbname",$dbusername,$dbpassword);
	$selectqry=$conn->prepare('select id from login_details where username=:username and password=:password');
	$selectqry->execute(array(':username'=>$username,':password'=>$password));
	if(1==$selectqry->rowCount()){
		$id=$selectqry->fetchColumn();
		session_start();
		$_SESSION['session_id']=session_id();
		setcookie('session_id',$_SESSION['session_id'],0);
		header('Location:http://127.0.0.1/session-cookie-db-assignment/home.php');
	}
	else{
		echo "Incorrect Username or Password";
		header('Location:http://127.0.0.1/session-cookie-db-assignment/index.php');
	}
	$conn=null;	
}
catch(PDOException $exception){
	echo "Connection failed. Try again".$exception->getMessage();
}
?>