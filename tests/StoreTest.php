<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

  require_once "src/Store.php";
  require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

  class StoreTest extends PHPUnit_Framework_TestCase {

    protected function teardown()
    {
        Store::deleteAll();
        // Brand::deleteAll();
    }

    function test_getName()
    {
      $name = "Neiman Marcus";
      $test_store = new Store($name);

      //Act
      $result = $test_store->getName();
      //Assert
      $this->assertEquals($name, $result);
    }

    function test_getId()
    {
      $name = "Neiman Marcus";
      $id = 1;
      $test_store = new Store($name, $id);

      //Act
      $result = $test_store->getId();
      //Assert
      $this->assertEquals($id, $result);
    }

    function test_save()
    {
      //Arrange
      $name = "Neiman Marcus";
      $id  = 1;
      $test_store = new Store($name, $id);

      //Act
      $test_store->save();

      //assert
      $result = Store::getAll();
      $this->assertEquals($test_store, $result[0]);
    }

    function test_getAll()
    {
      $name = "Neiman Marcus";
      $name2 = "Lyst";
      $test_store = new Store($name);
      $test_store->save();
      $test_store2 = new Store($name2);
      $test_store2->save();

      //Act
      $result = Store::getAll();

      //Assert
      $this->assertEquals([$test_store, $test_store2], $result);
    }

    function test_deleteAll()
    {
      $name = "Neiman Marcus";
      $name2 = "Lyst";
      $test_store = new Store($name);
      $test_store->save();
      $test_store2 = new Store($name2);
      $test_store2->save();

      //Act
      Store::deleteAll();
      $result = Store::getAll();

      //Assert
      $this->assertEquals([], $result);
    }

    function test_find()
    {
    //Arrange
    $name = "Neiman Marcus";
    $name2 = "Lyst";
    $test_store = new Store($name);
    $test_store->save();
    $test_store2 = new Store($name2);
    $test_store2->save();

    //Act
    $id = $test_store->getId();
    $result = Store::find($id);

    //Assert
    $this->assertEquals($test_store, $result);
    }

  function test_addBrand()
  {
      // Arrange
      $store_name = "Emilio Pucci";
      $test_store = new Store($store_name);
      $test_store->save();

      $brand_name = "Aquatalia";
      $brand_style = "boot";
      $test_brand = new Brand($brand_name, $brand_style);
      $test_brand->save();

      // Act
      $test_store->addBrand($test_brand);

      // Assert
      $this->assertEquals([$test_brand], $test_store->getBrands());
    }


        function test_getBrands()
        {
        $name = "Prada";
        $id = null;
        $test_store = new Store($name, $id);
        $test_store->save();

        $name = "Joie";
        $style = "bootie";
        $id = null;
        $test_brand = new Brand($name, $style, $id);
        $test_brand->save();
        $test_store->addBrand($test_brand);

        $name2 = "Emilio Pucci";
        $style2 = "boot";
        $id = null;
        $test_brand2 = new Brand($name2, $style2, $id);
        $test_brand2->save();
        $test_store->addBrand($test_brand2);

        // Act
        $result = $test_store->getBrands();

        // Assert
        $this->assertEquals([$test_brand, $test_brand2], $result);
        }

    function testUpdate()
    {
    //Arrange
    $name = "Neiman Marcus";
    $id = null;
    $test_store = new Store($name, $id);
    $test_store->save();

    $new_name = "Lyst";

    //Act
    $test_store->update($new_name);

    //Assert
    $this->assertEquals("Lyst", $test_store->getName());
    }

    function testDelete()
    {
      //Arrange
      $name = "Neiman Marcus";
      $id= null;
      $test_store = new Store($name, $id);
      $test_store->save();

      $name2 = "Lyst";
      $id= null;
      $test_store2 = new Store($name2, $id);
      $test_store2->save();

      //Act
      $test_store->delete();

      //Assert
      $this->assertEquals([$test_store2], Store::getAll());
    }

    function testDeleteBrand()
  {
    //ARRANGE
    $name = "Prada";
    $style = "sandal";
    $id = null;
    $test_brand = new Brand($name, $style);
    $test_brand->save();

    $name = "Lyst";
    $id = null;
    $test_store = new Store($name);
    $test_store->save();

    $test_store->addBrand($test_brand);

    //ACT
    $test_store->deleteBrand($test_brand->getId());
    //ASSERT
    $this->assertEquals([], $test_store->getBrands());
  }

  }

 ?>
