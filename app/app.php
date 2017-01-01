<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array ('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

//STORES

    $app->get("/", function() use($app){
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/stores/{store_id}", function($store_id) use($app) {
      $current_store = Store::find($store_id);
      return $app['twig']->render('store.html.twig', array(
          'single_store' => $current_store,
          'all_brands' => Brand::getAll(),
          'brands_sold_in_this_store' => $current_store->getBrands()
      ));
    });

    $app->get("/stores", function() use($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //Adds a new store
    $app->post("/stores", function() use($app) {
        $store = $_POST['store'];
        $id = null;
        $new_store = new Store($store, $id);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    //Deletes a single store
        $app->delete("/stores/{store_id_to_delete}", function($store_id_to_delete) use($app) {
        $store_to_delete = Store::find($store_id_to_delete);
        $store_to_delete->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    //Adds a brand to a store
        $app->post("/stores/{store_id}", function($store_id) use($app) {
          $new_brand_in_store = Brand::find($_POST['brand_id']);
          $current_store = Store::find($_POST['current_store_id']);
          $current_store->addBrand($new_brand_in_store);
          return $app['twig']->render('store.html.twig', array(
              'single_store' => $current_store,
              'brands_sold_in_this_store' => $current_store->getBrands(),
              'all_brands' => Brand::getAll()
          ));
        });

//BRANDS

        $app->get("/brands", function() use($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Adds a new brand
    $app->post("/brands", function() use($app) {
        $brand = $_POST['brand'];
        $style = $_POST['style'];
        $id = null;
        $new_brand = new Brand($brand, $style, $id);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Gets individual brand
    $app->get("/brands/{brand_id}", function($brand_id) use($app) {
      $current_brand = Brand::find($brand_id);
      return $app['twig']->render('brand.html.twig', array(
        'single_brand' => $current_brand,
        'all_stores' => Store::getAll(),
        'stores_selling_brand' => $current_brand->getStores()
      ));
    });

    //Delete a single brand
    $app->delete("/brands/{brand_id_to_delete}", function($brand_id_to_delete) use($app) {
      $brand_to_delete = Brand::find($brand_id_to_delete);
      $brand_to_delete->delete();
      return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //Adds a store to a brand
        $app->post("/brands/{brand_id}", function($brand_id) use($app) {
        $new_brand_in_store = Store::find($_POST['store_id']);
        $current_brand = Brand::find($_POST['current_brand_id']);
        $current_brand->addStore($new_brand_in_store);
        return $app['twig']->render('brand.html.twig', array(
            'single_brand' => $current_brand,
            'stores_carrying_brand' => $current_brand->getStores(),
            'all_stores' => Store::getAll()
        ));
      });



    return $app;
?>
