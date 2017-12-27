<?php
abstract class DatabaseConnection{
	protected $dbName=null,$dbHost=null,$dbUser=null,$dbPassword=null,$dbConnection=null;
	
	abstract public static function connect($dbDetails=array());
}

class MysqlDBConnection extends DatabaseConnection{
	private static $dbInstance=null;

	private function __construct($dbDetails=array()){
		$this->dbName=$dbDetails['dbName'];
		$this->dbHost=$dbDetails['dbHost'];
		$this->dbUser=$dbDetails['dbUser'];
		$this->dbPassword=$dbDetails['dbPassword'];
		try{
			$this->dbConnection=new PDO("mysql:host=$this->dbHost;dbname=$this->dbName",$this->dbUser,$this->dbPassword);
		} catch(PDOException $exception){
			echo "Unable to connect.".$exception->getMessage();
		}
	}
	public static function connect($dbDetails=array()){
		if(self::$dbInstance==null){
			self::$dbInstance=new MysqlDBConnection($dbDetails);
		}
		return self::$dbInstance;
	}
	
	private function __clone(){
	}

	public function isValidUsernamePassword($username,$password){
		$valid=false;
		try{
			$selectQry=$this->dbConnection->prepare('select id from user_login_details where username=? and password=?');
			$selectQry->execute(array($username,$password));
			if(1==$selectQry->rowCount()){
				$valid=true;
			} else{
				$valid=false;
			}
		} catch(PDOException $exception){
			echo "Exception:".$exception->getMessage();
		}
		return $valid;
	}

	public function getAllBooksDetail(){
		$bookDetails=array();
		try{
			$selectQry=$this->dbConnection->prepare('select * from book_details');
			$selectQry->execute();

			while($row=$selectQry->fetch(PDO::FETCH_ASSOC)){
				$bookDetails[]=array('id'=>$row['id'],'name'=>$row['book_name'],'author'=>$row['book_author'],'price'=>$row['book_price'],'quantity'=>$row['book_quantity']);
			}
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $bookDetails;
	}

	public function getBookQuantity($bookName){
		$quantity=0;
		try{
			$selectQry=$this->dbConnection->prepare("select book_quantity from book_details where book_name=?");
			$selectQry->execute(array($bookName));
			$row=$selectQry->fetch(PDO::FETCH_ASSOC);
			$quantity=$row['book_quantity'];
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $quantity;
	}

	public function setPrice($bookName,$price){
		try{
			$updateQry=$this->dbConnection->prepare("update book_details set book_price=? where book_name=?");
			$updateQry->execute(array($price,$bookName));
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
	}

	public function getPrice($bookName){
		$price=0;
		try{
			$selectQry=$this->dbConnection->prepare("select book_price from book_details where book_name=?");
			$selectQry->execute(array($bookName));
			$row=$selectQry->fetch(PDO::FETCH_ASSOC);
			$price=$row['book_price'];
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $price;
	}

	public function reduceQuantity($bookName,$bookQuantity){
		try{
			$updateQry=$this->dbConnection->prepare("update book_details set book_quantity=book_quantity-? where book_name=?");
			$updateQry->execute(array($bookQuantity,$bookName));
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
	}

	public function disConnect(){
		if(self::$dbInstance!=null){
			$this->dbConnection=null;	
		}
	}
}

class PgsqlDBConnection extends DatabaseConnection{

	private static $dbInstance=null;

	private function __construct($dbDetails=array()){
		$this->dbName=$dbDetails['dbName'];
		$this->dbHost=$dbDetails['dbHost'];
		$this->dbUser=$dbDetails['dbUser'];
		$this->dbPassword=$dbDetails['dbPassword'];
		try{
			$this->dbConnection=new PDO("pgsql:host=$this->dbHost;dbname=$this->dbName",$this->dbUser,$this->dbPassword);
		} catch(PDOException $exception){
			echo "Unable to connect.".$exception->getMessage();
		}
	}

	public static function connect($dbDetails=array()){
		if(self::$dbInstance==null){
			self::$dbInstance=new PgsqlDBConnection($dbDetails);
		}
		return self::$dbInstance;
	}

	private function __clone(){
	}

	public function isValidUsernamePassword($username,$password){
		$valid=false;
		try{
			$selectQry=$this->dbConnection->prepare('select id from user_login_details where username=? and password=?');
			$selectQry->execute(array($username,$password));
			if(1==$selectQry->rowCount()){
				$valid=true;
			} else{
				$valid=false;
			}
		} catch(PDOException $exception){
			echo "Exception:".$exception->getMessage();
		}
		return $valid;
	}

	public function getAllBooksDetail(){
		$bookDetails=array();
		try{
			$selectQry=$this->dbConnection->prepare('select * from book_details');
			$selectQry->execute();

			while($row=$selectQry->fetch(PDO::FETCH_ASSOC)){
				$bookDetails[]=array('id'=>$row['id'],'name'=>$row['book_name'],'author'=>$row['book_author'],'price'=>$row['book_price'],'quantity'=>$row['book_quantity']);
			}
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $bookDetails;
	}

	public function getBookQuantity($bookName){
		$quantity=0;
		try{
			$selectQry=$this->dbConnection->prepare("select book_quantity from book_details where book_name=?");
			$selectQry->execute(array($bookName));
			$row=$selectQry->fetch(PDO::FETCH_ASSOC);
			$quantity=$row['book_quantity'];
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $quantity;
	}

	public function setPrice($bookName,$price){
		try{
			$updateQry=$this->dbConnection->prepare("update book_details set book_price=? where book_name=?");
			$updateQry->execute(array($price,$bookName));
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
	}

	public function getPrice($bookName){
		$price=0;
		try{
			$selectQry=$this->dbConnection->prepare("select book_price from book_details where book_name=?");
			$selectQry->execute(array($bookName));
			$row=$selectQry->fetch(PDO::FETCH_ASSOC);
			$price=$row['book_price'];
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
		return $price;
	}

	public function reduceQuantity($bookName,$bookQuantity){
		try{
			$updateQry=$this->dbConnection->prepare("update book_details set book_quantity=book_quantity-? where book_name=?");
			$updateQry->execute(array($bookQuantity,$bookName));
		} catch(PDOException $exception){
			echo "Exception : ".$exception->getMessage();
		}
	}

	public function disConnect(){
		if(self::$dbInstance!=null){
			$this->dbConnection=null;	
		}
	}
}
?>