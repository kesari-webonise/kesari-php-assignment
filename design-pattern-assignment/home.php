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
}

?>

<html>
	<head>
		<title>Home Page</title>
	</head>
	<body>
		<form method="post" action="checkout.php">
			<table style="border:1px solid black">
				 <caption><h1>BOOK DETAILS</h1></caption>
				<tr>
					<th>ID</th>
					<th>NAME</th>
					<th>AUTHOR</th>
					<th>AVAILABLE QUANTITY</th>
					<th>PRICE IN RUPEE</th>
					<th>PRICE IN USD</th>
					<th>PRICE IN EURO</th>
				</tr>
				<?php 
				$bookDetails=$dbInstance->getAllBooksDetail();
				for($bookPointer=0;$bookPointer<sizeof($bookDetails);$bookPointer++){?>
				<tr>					
					<td name="id"><?php echo $bookDetails[$bookPointer]['id'];?></td>
					<td><?php echo $bookDetails[$bookPointer]['name'];?></td>
					<td><?php echo $bookDetails[$bookPointer]['author'];?></td>
					<td><?php echo $bookDetails[$bookPointer]['quantity'];?></td>
					<td><?php echo $bookDetails[$bookPointer]['price'];?></td>
					<td><?php echo $bookDetails[$bookPointer]['price']*0.016;?></td>
					<td><?php echo $bookDetails[$bookPointer]['price']*0.013;?></td>
				</tr>
				<?php } ?>
			</table>
		</form>
		<form method="post" action="checkout.php">
			<h1>Buy Book</h1>
			Book Name : <select name="bookName">
							<option value="none" selected>Select Book</option>
							<?php for($bookPointer=0;$bookPointer<sizeof($bookDetails);$bookPointer++) { ?>
								<option value="<?php echo $bookDetails[$bookPointer]['name'];?>"><?php echo $bookDetails[$bookPointer]['name'];?></option>
							<?php } ?>
						</select>
			Book Quantity : <input type="text" value="0" name="bookQuantity">
			<input type="submit" value="Buy">
		</form>
		<form method="post" action="priceUpdate.php"> 
			<h1>Update Book Price</h1>
			Book Name : <select name="bookName">
							<option value="none" selected>Select Book</option>
							<?php for($bookPointer=0;$bookPointer<sizeof($bookDetails);$bookPointer++) { ?>
								<option value="<?php echo $bookDetails[$bookPointer]['name'];?>"><?php echo $bookDetails[$bookPointer]['name'];?></option>
							<?php } ?>
						</select>
			New Price : <input type="text" value="0" name="bookPrice">
			<input type="submit" value="Update In Rupees" name="buttonRupee">
			<input type="submit" value="Update In USD" name="buttonUSD">
			<input type="submit" value="Update In EURO" name="buttonEuro">
		</form>
		<form method="post" action="logoutHandle.php">
			<input type="submit" value="Logout">
		</form>
	</body>
</html>

<?php
	$dbInstance->disconnect();
?>