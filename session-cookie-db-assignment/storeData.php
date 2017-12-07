<?php
	session_start();

	if(!isset($_SESSION['session_id'])){
		header("Location:http://127.0.0.1/session-cookie-db-assignment/index.php");
	} else {
		$dboption=$_POST['databases'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];

		$dbname="user_management";
		$tablename="user_name_details";

		$servername="localhost";
		
		$conn;

		if($dboption=="mysql"){
			$dbusername="root";
			$dbpassword="db123";
			
			try{
				$conn=new PDO("mysql:host=$servername;dbname=$dbname",$dbusername,$dbpassword);
			} catch(PDOException $exception){
				echo "Connection failed".$exception->getMessage();
			}
		} else {
			$dbusername="postgres";
			$dbpassword="123";
			try{
				$conn=new PDO("pgsql:host=$servername;dbname=$dbname",$dbusername,$dbpassword);
			} catch(PDOException $exception){
				echo "Connection failed".$exception->getMessage();
			}
		}
		try{
			$insertqry=$conn->prepare("insert into ".$tablename."(firstname,lastname) values(?,?)");
			$res=$insertqry->execute(array($firstname,$lastname));
			$conn=null;
			header('Location:http://127.0.0.1/session-cookie-db-assignment/home.php');
		} catch(PDOException $exception) {
			echo "Unable to disconnect".$exception->getMessage();
		}
	}	
?>