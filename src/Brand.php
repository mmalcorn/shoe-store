<?php
  class Brand {
    private $name;
    private $style;
    private $id;

    function __construct($name, $style, $id = null)
    {
      $this->name = $name;
      $this->style = $style;
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

    function setStyle($new_style)
    {
      $this->style = (string) $new_style;
    }

    function getStyle()
    {
      return $this->style;
    }

    function getId()
    {
      return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO brands (name, style) VALUES ('{$this->getName()}', '{$this->getStyle()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function addStore($new_store)
    {
        $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$new_store->getId()});");
    }

    function getStores()
      {
      $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
          JOIN brands_stores ON (brands_stores.brand_id = brands.id)
          JOIN stores ON (stores.id = brands_stores.store_id)
          WHERE brands.id = {$this->getId()};");
      $stores = array();
          foreach ($returned_stores as $store)
          {
          $name = $store['name'];
          $id = $store['id'];
          $new_store = new store($name, $id);
          array_push($stores, $new_store);
          }
          return $stores;
      }

    static function getAll()
    {
        $all_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
        $brands = [];
        foreach($all_brands as $brand)
        {
          $name = $brand['name'];
          $style = $brand['style'];
          $id = $brand['id'];
          $new_brand = new Brand($name, $style, $id);
          array_push($brands, $new_brand);
        }
        return $brands;
      }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM brands;");
    }

    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
    }

    static function find($id)
  {
    $found_id = null;
    $brands = Brand::getAll();
    foreach($brands as $brand) {
        $brand_id = $brand->getId();
        $brand_style = $brand->getStyle();
        if ($brand_id == $id) {
        $found_id = $brand;
        }
    }
    return $found_id;
    }
}
 ?>
