<?php
session_start();
if(!isset($_SESSION['session_id'])){
	//session_destroy();
	header("Location:http://127.0.0.1/session-cookie-db-assignment/index.php");
}
?>

<html>
	<head>
		<title>Home</title>
	</head>
	<body>
		<form method="post" action="storeData.php">
			<select name="databases">
				<option value="mysql">MYSQL</option>
				<option value="pgsql">PGSQL</option>
			</select>
			First name <input type="text" name="firstname">
			Last name <input type="text" name="lastname">
			<input type="submit" value="Save">
		</form>
		<form method="post" action="showData.php">
			<select name="databases">
				<option value="mysql">MYSQL</option>
				<option value="pgsql">PGSQL</option>
			</select>
			<input type="submit" value="Show Data">
		</form>
		<form method="post" action="logoutHandle.php">
			<input type="submit" value="Logout">
		</form>
	</body>
</html>