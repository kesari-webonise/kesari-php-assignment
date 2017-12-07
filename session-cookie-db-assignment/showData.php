<?php
	session_start();

	if(!isset($_SESSION['session_id'])){
		header("Location:http://127.0.0.1/session-cookie-db-assignment/index.php");
	} else {

		$dboption=$_POST['databases'];

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
			$selectqry=$conn->prepare("select firstname,lastname from ".$tablename.";");
			$selectqry->execute();
			while($row=$selectqry->fetch(PDO::FETCH_ASSOC)){
				echo "First Name = ".$row[firstname]." Last Name = ".$row[lastname]."\r\t";
			}
			$conn=null;
			//header('Location:http://127.0.0.1/session-cookie-db-assignment/home.php');
		} catch(PDOException $exception) {
			echo "Unable to disconnect".$exception->getMessage();
		}
	}
?>