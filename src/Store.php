<?php
class Store
{
  private $name;
  private $id;

  function __construct($name, $id = null)
  {
    $this->name = $name;
    $this->id = $id;
  }

  function setName($new_name)
  {
    $this->name = (string) $new_name;
  }

  function getName()
  {
      return $this->name;
  }

  function getId()
  {
    return $this->id;
  }

  function save()
  {
    $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
    $this->id = $GLOBALS['DB']->lastInsertId();
  }

  static function getAll()
  {
    $all_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
    $stores = array();
    foreach($all_stores as $store)
    {
        $name = $store['name'];
        $id = $store['id'];
        $new_store = new Store($name, $id);
        array_push($stores, $new_store);
    }
    return $stores;
  }

  static function deleteAll()
  {
     $GLOBALS['DB']->exec("DELETE FROM stores;");
  }

  static function find($id)
  {
    $found_id = null;
    $stores = Store::getAll();
    foreach($stores as $store) {
    $store_id = $store->getId();
      if ($store_id == $id) {
      $found_id = $store;
      }
    }
    return $found_id;
  }

  function getBrands()
  {
    $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores
    JOIN brands_stores ON (brands_stores.store_id = stores.id)
    JOIN brands ON (brands.id = brands_stores.brand_id)
    WHERE stores.id = {$this->getId()};");
    $brands = array();
    foreach ($returned_brands as $brand) {
        $name = $brand['name'];
        $style = $brand['style'];
        $id = $brand['id'];
        $new_brand = new Brand($name, $style, $id);
        array_push($brands, $new_brand);
    }
    return $brands;
  }

  function addBrand($new_brand)
  {
    $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$new_brand->getId()}, {$this->getId()});");
  }

  function delete()
  {
    $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
  }

  function update($new_name)
  {
    $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
    $this->setName($new_name);
  }

  function deleteBrand($brand_id)
  {
    $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()} AND brand_id = $brand_id;");
  }
}
?>
