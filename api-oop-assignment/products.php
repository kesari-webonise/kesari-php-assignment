<?php

require "databaseHandle.php";

class Products{
	private $dbInstance;

	public function __construct(){
		$this->dbInstance = DatabaseConnection::connection();
	}

	public function showAllProductsDetails(){
		$this->dbInstance->showAllProducts();
	}
	public function addProductDetails($productDetails=array()){
		$this->dbInstance->addProduct($productDetails);
	}
	public function updateProductDetails($productDetails=array()){
		$this->dbInstance->updateProduct($productDetails);
	}
	public function deleteProductDetails($productId){
		$this->dbInstance->deleteProduct($productId);
	}
	public function __destruct(){
		$this->dbInstance->disConnection();
		$this->dbInstance=null;
	}

}

$product=new Products();

$method=$_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$product->showAllProductsDetails();
		break;
	case 'POST':
		$productDetails=array("name"=>$_POST['name'],"description"=>$_POST['description'],"price"=>$_POST['price'],"discount"=>$_POST['discount'],'category_id'=>$_POST['category_id']);
		$product->addProductDetails($productDetails);
		break;
	case 'PUT':
		$productId=basename($_SERVER['REQUEST_URI']);
		parse_str(file_get_contents("php://input"),$post_vars);
		$newProductName=$post_vars['name'];
		$productDescription=$post_vars['description'];
		$productPrice=$post_vars['price'];
		$productDiscount=$post_vars['discount'];
		$productCategoryId=$post_vars['category_id'];
		$productDetails=array('id'=>$productId,'name'=>$newProductName,'description'=>$productDescription,'price'=>$productPrice,'discount'=>$productDiscount,'category_id'=>$productCategoryId);
		$product->updateProductDetails($productDetails);
		break;
	case 'DELETE':
		$productId=basename($_SERVER['REQUEST_URI']);
		$product->deleteProductDetails($productId);
		break;
	default:
		ECHO "Invalid method";
		break;
}

?>