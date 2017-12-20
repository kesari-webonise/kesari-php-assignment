<?php

require "databaseHandle.php";

class Categories{
	private $dbInstance;

	public function __construct(){
		$this->dbInstance = DatabaseConnection::connection();
	}

	public function showAllCategoriesDetails(){
		$this->dbInstance->showAllCategories();
	}
	public function addCategoryDetails($categoryDetails=array()){
		$this->dbInstance->addCategory($categoryDetails);
	}
	public function updateCategoryDetails($categoryDetails=array()){
		$this->dbInstance->updateCategory($categoryDetails);
	}
	public function deleteCategoryDetails($categoryId){
		$this->dbInstance->deleteCategory($categoryId);
	}
	public function __destruct(){
		$this->dbInstance->disConnection();
		$this->dbInstance=null;
	}

}

$category=new Categories();

$method=$_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$category->showAllCategoriesDetails();
		break;
	case 'POST':
		$categoryDetails=array("name"=>$_POST['name'],"description"=>$_POST['description'],"tax"=>$_POST['tax']);
		$category->addCategoryDetails($categoryDetails);
		break;
	case 'PUT':
		$categoryId=basename($_SERVER['REQUEST_URI']);
		parse_str(file_get_contents("php://input"),$post_vars);
		$newCategoryName=$post_vars['name'];
		$categoryDescription=$post_vars['description'];
		$categoryTax=$post_vars['tax'];
		$categoryDetails=array('id'=>$categoryId,'name'=>$newCategoryName,'description'=>$categoryDescription,'tax'=>$categoryTax);
		$category->updateCategoryDetails($categoryDetails);
		break;
	case 'DELETE':
		$categoryId=basename($_SERVER['REQUEST_URI']);
		$category->deleteCategoryDetails($categoryId);
		break;
	default:
		ECHO "Invalid method";
		break;
}

?>