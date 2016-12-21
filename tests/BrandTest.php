<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

  class BrandTest extends PHPUnit_Framework_TestCase
  {

    protected function tearDown()
    {
      Brand::deleteAll();
      Store::deleteAll();
    }

    function test_getName(){
      $name = "Emilio Pucci";
      $style = "boot";
      $test_brand = new Brand($name, $style);

      //Act
      $result = $test_brand->getName();
      //Assert
      $this->assertEquals($name, $result);
    }

    function test_getId()
    {
      $name = "Prada";
      $style = "boot";
      $id = 1;
      $test_brand = new Brand($name, $style, $id);

      //Act
      $result = $test_brand->getId();
      //Assert
      $this->assertEquals($id, $result);
    }

    function test_save()
    {
      //Arrange
      $name = "Emilio Pucci";
      $style = "boot";
      $id = null;
      $test_brand = new Brand($name, $style, $id);

      //Act
      $test_brand->save();
      // var_dump($test_brand);

      //assert
      $this->assertEquals([$test_brand], Brand::getAll());
    }

    function test_getAll()
    {
      $name = "Neiman Marcus";
      $style = "boot";
      $test_brand = new Brand($name, $style);
      $test_brand->save();
      $name2 = "Emilio Pucci";
      $style2 = "bootie";
      $test_brand2 = new Brand($name2, $style2);
      $test_brand2->save();

      //Act
      $result = Brand::getAll();

      //Assert
      $this->assertEquals([$test_brand, $test_brand2], $result);
    }

    function test_deleteAll()
    {
      $name = "Emilio Pucci";
      $style = "boot";
      $test_brand = new Brand($name, $style);
      $test_brand->save();

      $name2 = "Joie";
      $style2 = "bootie";
      $test_brand2 = new Brand($name2, $style2);
      $test_brand2->save();

      //Act
      Brand::deleteAll();

      //Assert
      $this->assertEquals([], Brand::getAll());
    }

    function test_addStore()
    {
      // Arrange
      $brand_name = "Emilio Pucci";
      $style = "boots";
      $test_brand = new Brand($brand_name, $style);
      $test_brand->save();

      $store_name = "Lyst";
      $test_store = new Store($store_name);
      $test_store->save();

      // Act
      $test_brand->addStore($test_store);

      // Assert
      $this->assertEquals([$test_store], $test_brand->getStores());
    }

    function test_getStores()
    {
      // Arrange
      $name = "Prada";
      $style = "sandals";
      $id = null;
      $test_brand = new Brand($name, $style, $id);
      $test_brand->save();

      $name = "Neiman Marcus";
      $id = null;
      $test_store = new Store($name, $id);
      $test_store->save();
      $test_brand->addStore($test_store);

      $name2 = "Lyst";
      $id = null;
      $test_store2 = new Store($name2, $id);
      $test_store2->save();
      $test_brand->addStore($test_store2);

      // Act
      $result = $test_brand->getStores();

      // Assert
      $this->assertEquals([$test_store, $test_store2], $result);
    }
  }

 ?>
