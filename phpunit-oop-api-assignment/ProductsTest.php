<?php
use PHPUnit\Framework\TestCase;

require "products.php";
/**
* @author kesari
* @backupGlobals disabled
* @backupStaticAttributes disabled
* @coversDefaultClass Products
* @requires PHP 5.5
*/
class ProductsTest extends TestCase{
	private static $productInstance=null;

	/**
	* @beforeClass
	*/
	public static function setProductInstance(){
		ProductsTest::$productInstance=new Products();
	}

	/**
	* @covers ::showAllProductsDetails
	* @group showAllProductsDetails
	* @test
	*/
	public function showAllProductsDetailsExists(){
		echo "\n1-1";
		$this->assertTrue(method_exists(ProductsTest::$productInstance, 'showAllProductsDetails'),"showAllProductsDetails method is not defined in Categories class");
	}

	/**
	* @covers ::showAllProductsDetails
	* @group showAllProductsDetails
	*/
	public function testShowAllProductsDetails(){
		echo "\n1-2";
		$this->assertNull(ProductsTest::$productInstance->showAllProductsDetails());
	}

	/**
	* @covers ::addProductDetails
	* @group addProductDetails
	* @test
	*/
	public function addProductDetailsExists(){
		echo "\n2-1";
		$this->assertTrue(method_exists(ProductsTest::$productInstance, 'addProductDetails'),"addProductDetails method is not defined in Categories class");
	}

	/**
	* @covers ::addProductDetails
	* @group addProductDetails
	* @dataProvider addProductDetailsProvider
	*/
	public function testAddProductDetails($productDetails=array()){
		echo "\n2-2";
		$this->assertNull(ProductsTest::$productInstance->addProductDetails($productDetails));
	}

	/**
	* @covers ::updateProductDetails
	* @group updateProductDetails
	* @test
	*/
	public function updateProductDetailsExists(){
		echo "\n3-1";
		$this->assertTrue(method_exists(ProductsTest::$productInstance, 'updateProductDetails'),"updateProductDetails method is not defined in Categories class");
	}

	/**
	* @covers ::updateProductDetails
	* @group updateProductDetails
	* @dataProvider updateProductDetailsProvider
	*/
	public function testUpdateProductDetails($productDetails=array()){
		echo "\n3-2";
		$this->assertCount(6,$productDetails,"6 parameters required to update product details.");
		$this->assertNull(ProductsTest::$productInstance->updateProductDetails($productDetails[0],$productDetails[1],$productDetails[2],$productDetails[3],$productDetails[4],$productDetails[5]));
	}

	/**
	* @covers ::deleteProductDetails
	* @group deleteProductDetails
	* @test
	*/
	public function deleteProductDetailsExists(){
		echo "\n4-1";
		$this->assertTrue(method_exists(ProductsTest::$productInstance, 'deleteProductDetails'),"deleteProductDetails method is not defined in Categories class");
	}

	/**
	* @covers ::deleteProductDetails
	* @group deleteProductDetails
	* @dataProvider productIdProvider
	*/
	public function testDeleteProductDetails($productId=0){
		echo "\n4-2";
		$this->assertNotEquals(0,$productId,"Product id is not mentioned or Product id can't be zero");
		$this->assertInternalType('integer',$productId,"Product id should be integer.");
		$this->assertNull(ProductsTest::$productInstance->deleteProductDetails($productId));
	}

	/**
	* @covers ::addProductDetails
	* @group addProductDetails
	* @dataProvider addProductDetailsProvider
	*/
	public function addProductDetailsProvider(){
		return array(
				array(array("name"=>'shirt',"description"=>'shirt',"price"=>200,"discount"=>5,'category_id'=>6)),
				array(array("name"=>'wheat',"description"=>'wheat',"price"=>45,"discount"=>0,'category_id'=>8))
				);
	}

	/**
	* @covers ::updateProductDetails
	* @group updateProductDetails
	*/
	public function updateProductDetailsProvider(){
		return array(
				array(array(9,'pant','pant',100,5,6)),
				array(array(10,'rice','rice',50,0,8))
			);
	}

	/**
	* @covers ::deleteProductDetails
	* @group deleteProductDetails
	*/
	public function productIdProvider(){
		return [
			[13],
			[14],
			[],
			['2']
		];
	}

	/**
	* @afterClass
	*/
	public static function resetProductInstance(){
		ProductsTest::$productInstance=null;
	}
}
?>