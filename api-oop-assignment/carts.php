<?php

require "databaseHandle.php";

class Carts{
	private $dbInstance;

	public function __construct(){
		$this->dbInstance = DatabaseConnection::connection();
	}

	public function showAllCartsDetails(){
		$this->dbInstance->showAllCarts();
	}
	public function addCartDetails($cartDetails=array()){
		$this->dbInstance->addCart($cartDetails);
	}
	
	public function deleteCartDetails($cartId){
		$this->dbInstance->deleteCart($cartId);
	}

	public function isProductExistInCart($cartId,$productId){
		return $this->dbInstance->isProductExistInCart($cartId,$productId);
	}

	public function addProductToCart($cartId,$productId){
		$this->dbInstance->addProductToCart($cartId,$productId);
	}

	public function deleteProductFromCart($cartId,$productId){
		$this->dbInstance->deleteProductFromCart($cartId,$productId);
	}
	public function __destruct(){
		$this->dbInstance->disConnection();
		$this->dbInstance=null;
	}

}

$cart=new Carts();

$method=$_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cart->showAllCartsDetails();
		break;
	case 'POST':
		$cartDetails=array("total"=>$_POST['total'],"total_discount"=>$_POST['total_discount'],"total_with_discount"=>$_POST['total_with_discount'],"total_tax"=>$_POST['total_tax'],'grand_total'=>$_POST['grand_total']);
		$cart->addCartDetails($cartDetails);
		break;
	case 'PUT':
		$cartId=basename($_SERVER['REQUEST_URI']);
		parse_str(file_get_contents("php://input"),$post_vars);
		$productId=$post_vars['product_id'];

		if($cart->isProductExistInCart($cartId,$productId)){
			$cart->deleteProductFromCart($cartId,$productId);
		} else{
			$cart->addProductToCart($cartId,$productId);
		}
		break;
	case 'DELETE':
		$cartId=basename($_SERVER['REQUEST_URI']);
		$cart->deleteCartDetails($cartId);
		break;
	default:
		ECHO "Invalid method";
		break;
}

?>