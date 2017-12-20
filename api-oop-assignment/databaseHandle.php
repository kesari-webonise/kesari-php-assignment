<?php

class DatabaseConnection{
	private $host=null,$databaseName=null,$user=null,$password=null,$connection=null;
	private static $instance=null;

	private function __construct(){
		$this->host="localhost";
		$this->databaseName="shopping_cart";
		$this->user="root";
		$this->password="db123";

		try{
			$this->connection=new PDO("mysql:host=$this->host;dbname=$this->databaseName",$this->user,$this->password);	
		} catch(PDOException $exception){
			echo "Exception - ".$exception->getMessage();
		}
	}

	public static function connection() {
		if(!isset(self::$instance)){
			self::$instance = new DatabaseConnection();
		}
		return self::$instance;
	}

	public function showAllCategories(){
		try{
			$selectQry=$this->connection->prepare("select name,description,tax from categories");
			$selectQry->execute();
			while($row=$selectQry->fetch(PDO::FETCH_ASSOC)){
				$result[]=$row;
			}
			echo json_encode($result);
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function addCategory($categoryDetails=array()){
		try{
			$result=0;
			$insertQry=$this->connection->prepare("insert into categories(name,description,tax) values(?,?,?)");
			$result=$insertQry->execute(array($categoryDetails['name'],$categoryDetails['description'],$categoryDetails['tax']));
			if(1==$result){
				echo "Category added\n";
			} else{
				echo "Unable to add category\n";
			}
		}catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function updateCategory($categoryDetails=array()){
		try{
			$result=0;
			$updateQry=$this->connection->prepare("update categories set name=?,description=?,tax=? where id=?");
			$updateQry->execute(array($categoryDetails['name'],$categoryDetails['description'],$categoryDetails['tax'],$categoryDetails['id']));
			if(1==$updateQry->rowCount()){
				echo "Category updated\n";
			} else{
				echo "Unable to update category\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function deleteCategory($categoryId){
		try{
			$deleteQry=$this->connection->prepare("delete from categories where id=?");
			$result=$deleteQry->execute(array($categoryId));
			if(1==$result){
				echo "Category deleted\n";
			} else{
				echo "Unable to delete category\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function showAllProducts(){
		try{
			$selectQry=$this->connection->prepare("select name,description,price,discount,category_id from products");
			$selectQry->execute();
			while($row=$selectQry->fetch(PDO::FETCH_ASSOC)){
				$result[]=$row;
			}
			echo json_encode($result);
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function addProduct($ProductDetails=array()){
		try{
			$result=0;
			$insertQry=$this->connection->prepare("insert into products(name,description,price,discount,category_id) values(?,?,?,?,?)");
			$result=$insertQry->execute(array($ProductDetails['name'],$ProductDetails['description'],$ProductDetails['price'],$ProductDetails['discount'],$ProductDetails['category_id']));
			if(1==$result){
				echo $result;
				echo "Product added\n";
			} else{
				echo $result;
				echo "Unable to add product\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}

	}

	public function updateProduct($updateProduct=array()){
		try{
			$result=0;
			$updateQry=$this->connection->prepare("update products set name=?,description=?,price=?,discount=?,category_id=? where id=?");
			$result=$updateQry->execute(array($updateProduct['name'],$updateProduct['description'],$updateProduct['price'],$updateProduct['discount'],$updateProduct['category_id'],$updateProduct['id']));
			if(1==$result){
				echo "Product updated\n";
			} else{
					echo "Unable to update product\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function deleteProduct($productId){
		try{
			$deleteQry=$this->connection->prepare("delete from products where id=?");
			$result=$deleteQry->execute(array($productId));
			if(1==$result){
				echo "Product deleted\n";
			} else{
				echo "Unable to delete product\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function showAllCarts(){
		try{
			$selectQry=$this->connection->prepare("select c.id,p.name,total,total_discount,total_with_discount,total_tax,grand_total from carts c,products p,carts_products cp where c.id=cp.carts_id and p.id=cp.products_id");
			$selectQry->execute();
			while($row=$selectQry->fetch(PDO::FETCH_ASSOC)){
				$result[]=$row;
			}
			echo json_encode($result);
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function addCart($cartDetails=array()){
		try{
			$result=0;
			$insertQry=$this->connection->prepare("insert into carts(total,total_discount,total_with_discount,total_tax,grand_total) values(?,?,?,?,?)");
			$result=$insertQry->execute(array($cartDetails['total'],$cartDetails['total_discount'],$cartDetails['total_with_discount'],$cartDetails['total_tax'],$cartDetails['grand_total']));
			if(1==$result){
				echo "Cart added\n";
			} else{
				echo "Unable to add cart\n";
			}
		}catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function deleteCart($cartId){
		try{
			$result=0;
			$deleteQry=$this->connection->prepare("delete from carts where id=?");
			$result=$deleteQry->execute(array($cartId));
			if(1==$result){
				echo "Cart deleted\n";
			} else{
				echo "Unable to delete cart\n";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function getPriceDiscountTax($productId){
		$productPriceDiscountTax=array();
		try{
			$selectQry=$this->connection->prepare("select price,discount,tax from products p,categories c where p.id=? and p.category_id=c.id");
			$selectQry->execute(array($productId));
			$row=$selectQry->fetch(PDO::FETCH_ASSOC);
			$productPriceDiscountTax=array("price"=>$row['price'],"discount"=>$row['discount'],"tax"=>$row['tax']);
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
		return $productPriceDiscountTax;
	}

	public function isProductExistInCart($cartId,$productId){
		$exists=0;
		try{
			$selectQry=$this->connection->prepare("select * from carts_products where carts_id=? and products_id=?");
			$selectQry->execute(array($cartId,$productId));
			$rowCount=$selectQry->rowCount();
			if($rowCount){
				$exists=1;
			} 
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
		return $exists;
	}

	public function addProductToCart($cartId,$productId){
		try{
			$insertQry=$this->connection->prepare("insert into carts_products values(?,?)");
			
			if($result=$insertQry->execute(array($cartId,$productId))){
				$productPriceDiscountTax=$this->getPriceDiscountTax($productId);
				$discount=$productPriceDiscountTax['price']*$productPriceDiscountTax['discount']/100;
				$tax=$productPriceDiscountTax['price']*$productPriceDiscountTax['tax']/100;
				
				$updateQry=$this->connection->prepare("update carts set total=total+?, total_discount=total_discount+?, total_with_discount=total-total_discount, total_tax=total_tax+?, grand_total=total_with_discount+total_tax where id=?");
				$result=$updateQry->execute(array($productPriceDiscountTax['price'],$discount,$tax,$cartId));
				if(1==$result){
					echo json_encode("Product Added.");
				} else{
					$deleteQry=$this->connection->prepare("delete from carts_products where carts_id=? and products_id=?");
					$result=$deleteQry->execute(array($cartId,$productId));
					if(1==$result){
						echo json_encode("Unable to add product to cart.");
					} else{
						echo "Unable to delete data from carts_products";
					}
				}
			} else{
				echo "Unable to add product to cart.";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();	
		}
	}

	public function deleteProductFromCart($cartId,$productId){
		try{
			$productPriceDiscountTax=$this->getPriceDiscountTax($productId);
			$discount=$productPriceDiscountTax['price']*$productPriceDiscountTax['discount']/100;
			$tax=$productPriceDiscountTax['price']*$productPriceDiscountTax['tax']/100;

			$updateQry=$this->connection->prepare("update carts set total=total-?, total_discount=total_discount-?, total_with_discount=total-total_discount, total_tax=total_tax-?, grand_total=total_with_discount+total_tax where id=?");
			$result=$updateQry->execute(array($productPriceDiscountTax['price'],$discount,$tax,$cartId));
			if(1==$result){
				$deleteQry=$this->connection->prepare("delete from carts_products where carts_id=? and products_id=?");
				$result=$deleteQry->execute(array($cartId,$productId));
				if(1==$result){
					echo json_encode("Product removed.");
				} else{
					echo json_encode("Unable to remove product.");
				}
			} else{
				echo "unable to update";
			}
		} catch(PDOException $exception){
			echo "Exception ".$exception->getMessage();
		}
	}

	public function disConnection() {
			$this->connection=null;
	}

	public function __destruct(){
		 self::$instance=null;
	}
}
?>