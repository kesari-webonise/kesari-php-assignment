<?php

use PHPUnit\Framework\TestCase;

require "carts.php";

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
* @coversDefaultClass carts
* @requires PHP 5.5
*/

class CartsTest extends TestCase {
	static private $cartsInstance=null;

	/**
	* @author kesari
	* @beforeClass
	*/
	public static function setUpCartsObject(){
		CartsTest::$cartsInstance=new Carts();
	}

	/**
	* @author kesari
	*/

	public function testInstanceOfCarts(){
		echo "1";
		$this->assertInstanceOf(Carts::class,CartsTest::$cartsInstance);
	}

	/**
	* @author kesari
	* @group showAllCartsDetails
	*/

	public function testshowAllCartsDetailsExists(){
		echo "2";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'showAllCartsDetails'),"showAllCartsDetails method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group showAllCartsDetails
	*/
	public function testshowAllCartsDetails(){
		echo "2";
		$this->assertNull(CartsTest::$cartsInstance->showAllCartsDetails());
	}

	/**
	* @author kesari
	* @group addCartDetails
	* @test
	*/
	public function addCartDetailsExists(){
		echo "3";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'addCartDetails'),"addCartDetails method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group deleteCartDetails
	* @test
	*/
	public function deleteCartDetailsExists(){
		echo "4";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'deleteCartDetails'),"deleteCartDetails method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group isProductExistInCart
	*@test
	*/
	public function isProductExistInCartExists(){
		echo "5";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'isProductExistInCart'),"isProductExistInCart method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group addProductToCart
	* @test
	*/
	public function addProductToCartExists(){
		echo "6";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'addProductToCart'),"addProductToCart method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group deleteProductFromCart
	* @test
	*/
	public function deleteProductFromCartExists(){
		echo "7";
		$this->assertTrue(method_exists(CartsTest::$cartsInstance, 'deleteProductFromCart'),"deleteProductFromCart method is not present in Carts.");
	}

	/**
	* @author kesari
	* @group addCartDetails
	* @dataProvider cartDetailsProvider
	*/
	public function testCartDetailsCount($cartDetails=array()){
		echo "8\n";
		$this->assertCount(5,$cartDetails,"Invalid count of cartDetails");
		/*echo "success of test case";
		var_dump($cartDetails);*/
		$cartData=$cartDetails;
		return $cartData;
	}

	/**
	* @author kesari
	* @group addCartDetails
	* @depends testCartDetailsCount 
	*/
	public function testAddCartDetails($cartData=array()){
		echo "9";	
		var_dump($cartData);	
		$this->assertNull(CartsTest::$cartsInstance->addCartDetails($cartData));
	}


	/**
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Cart id should be integer
	*/
	public function testDeleteCartDetailsWithoutCartId(){
		echo "10";
		CartsTest::$cartsInstance->deleteCartDetails('1');
	}

	/**
	* @author kesari
	* @group deleteCartDetails
	* @dataProvider cartIdProvider
	*/
	public function testDeleteCartDetails($cartId){
		echo "11";
		$this->assertNull(CartsTest::$cartsInstance->deleteCartDetails($cartId));
	}


	/**
	* @author kesari
	* @group isProductExistInCart
	* @dataProvider cartIdProductIdProvider
	*/
	public function testIsProductExistInCart($cartId,$productId){
		echo "12";
		$this->assertContains(CartsTest::$cartsInstance->isProductExistInCart($cartId,$productId),[1],"Product is not present in cart.");
	}

	/**
	* @author kesari
	* @group addProductToCart
	* @dataProvider cartIdProductIdProvider
	*/
	public function testAddProductToCart($cartId,$productId){
		echo "13";
		$this->assertNull(CartsTest::$cartsInstance->addProductToCart($cartId,$productId));
	}

	/**
	* @author kesari
	* @group deleteProductFromCart
	* @dataProvider cartIdProductIdProvider
	*/
	public function testDeleteProductFromCart($cartId,$productId){
		echo "14";
		$this->assertNull(CartsTest::$cartsInstance->deleteProductFromCart($cartId,$productId));
	}

	/**
	* @author kesari
	* @group isProductExistInCart
	*/
	public function cartIdProductIdProvider(){
		return array(
			array(40,4),
			array(29,1)
			);
	}

	/**
	* @author kesari
	* @group deleteCartDetails
	*/
	public function cartIdProvider(){
		return array(
			array(21),
			array(22),
			array(23)
			);
	}

	/**
	* @author kesari
	* @group addCartDetails
	*/
	public function cartDetailsProvider(){

		return array(
				array(array("total"=>0,"total_discount"=>0,"total_with_discount"=>0,"total_tax"=>0,'grand_total'=>0)),
				array(array("total"=>0,"total_discount"=>0,"total_with_discount"=>0,"total_tax"=>0,'grand_total'=>0)),
				array(array("total"=>0,"total_discount"=>0,"total_with_discount"=>0,"total_tax"=>0))
			);
	}

	public static function tearDownAfterClass(){
		CartsTest::$cartsInstance=null;
	}
}
?>