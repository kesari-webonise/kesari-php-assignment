<?php

use PHPUnit\Framework\TestCase;

require 'categories.php';

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
* @coversDefaultClass Categories
* @requires PHP 5.5
*/
class CategoriesTest extends TestCase {
	private static $categoryInstance=null;

	/**
	* @author kesari
	* @beforeClass
	*/
	public static function getCategoryObject(){
		echo "\nIn before class";
		CategoriesTest::$categoryInstance=new Categories();
	}

	/**
	* @author kesari
	* @covers ::showAllCategoriesDetails
	* @group showAllCategoriesDetails
	* @test
	*/
	public function showAllCategoriesDetailsExists(){
		echo "\n1-1";
		$this->assertTrue(method_exists(CategoriesTest::$categoryInstance, 'showAllCategoriesDetails'),"showAllCategoriesDetails method is not defined in Categories class");
	}

	/**
	* @author kesari
	* @covers ::showAllCategoriesDetails
	* @group showAllCategoriesDetails
	*/

	public function testShowAllCategoriesDetails(){
		echo "\n1-2";
		$this->assertNull(CategoriesTest::$categoryInstance->showAllCategoriesDetails());
	}

	/**
	* @author kesari
	* @covers ::addCategoryDetails
	* @group addCategoryDetails
	* @test
	*/
	public function addCategoryDetailsExists(){
		echo "\n2-1";
		$this->assertTrue(method_exists(CategoriesTest::$categoryInstance, 'addCategoryDetails'),"addCategoryDetails method is not defined in Categories class");
	}

	/**
	* @author kesari
	* @covers ::addCategoryDetails
	* @group addCategoryDetails
	* @expectedException InvalidArgumentException
	* @expectedExceptionCode 1
	*/
	public function testAddCategoryDetailsWithNoParameter(){
		echo "\n2-2";
		CategoriesTest::$categoryInstance->addCategoryDetails();
	}

	/**
	* @author kesari
	* @covers ::addCategoryDetails
	* @group addCategoryDetails
	* @dataProvider categoryDetailProvider
	*/
	public function testAddCategoryDetails($categoryDetail=array()){
		echo "\n2-3";
		$this->assertNull(CategoriesTest::$categoryInstance->addCategoryDetails($categoryDetail));
	}

	/**
	* @author kesari
	* @covers ::updateCategoryDetails
	* @group updateCategoryDetails
	* @test
	*/
	public function updateCategoryDetailsExists(){
		echo "\n3-1";
		$this->assertTrue(method_exists(CategoriesTest::$categoryInstance, 'updateCategoryDetails'),"updateCategoryDetails method is not defined in Categories class");
	}

	/**
	* @author kesari
	* @covers ::updateCategoryDetails
	* @group updateCategoryDetails
	* @dataProvider updateCategoryDetailProvider
	*/
	public function testUpdateCategoryDetails($categoryDetail=array()){
		echo "\n3-2";
		$this->assertCount(4,$categoryDetail,"4 parameters are required.");
		$this->assertNull(CategoriesTest::$categoryInstance->updateCategoryDetails($categoryDetail[0],$categoryDetail[1],$categoryDetail[2],$categoryDetail[3]));
	}

	/**
	* @author kesari
	* @covers ::deleteCategoryDetails
	* @group deleteCategoryDetails
	* @test
	*/
	public function deleteCategoryDetailsExists(){
		echo "\n4-1";
		$this->assertTrue(method_exists(CategoriesTest::$categoryInstance, 'deleteCategoryDetails'),"deleteCategoryDetails method is not defined in Categories class");
	}

	/**
	* @author kesari
	* @covers ::deleteCategoryDetails
	* @group deleteCategoryDetails
	* @dataProvider categoryIdProvider
	*/
	public function testdeleteCategoryDetails($categoryId=0){
		echo "\n4-2";
		$this->assertNotContains($categoryId,[0],"Empty category id passed");
		$this->assertNull(CategoriesTest::$categoryInstance->deleteCategoryDetails($categoryId));
	}

	/**
	* @author kesari
	* @covers ::addCategoryDetails
	* @group addCategoryDetails
	*/
	public function categoryDetailProvider(){
		return array(
			array(array("name"=>"grosary","description"=>"grosary","tax"=>8)),
			array(array("name"=>"grosary","description"=>"grosary"))
			);
	}

	/**
	* @author kesari
	* @covers ::updateCategoryDetails
	* @group updateCategoryDetails
	*/
	public function updateCategoryDetailProvider(){
		return array(
				array(array(6,"kidsware","kidsware",7)),
				array(array(6,"kidsware",7))
			);
	}

	/**
	* @author kesari
	* @covers ::deleteCategoryDetails
	* @group deleteCategoryDetails
	*/
	public function categoryIdProvider(){
		return [
			[5],
			[],
			[22]
		];
	}

	/**
	* @author kesari
	* @afterClass
	*/
	public static function removeCategoryObjectExists(){
		echo "\nIn after class";
		CategoriesTest::$categoryInstance=null;
	}
}
?>