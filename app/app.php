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
          'brands_sold_in_store' => $current_store->getBrands()
      ));
    });

        $app->delete("/stores/{store_id_to_delete}", function($store_id_to_delete) use($app) {
        $store_to_delete = Store::find($store_id_to_delete);
        $store_to_delete->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });


    //BRANDS

        $app->get("/brands", function() use($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post("/brands", function() use($app) {
        $brand = $_POST['brand'];
        $style = $_POST['style'];
        $id = null;
        $new_brand = new Brand($brand, $style, $id);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    return $app;
?>
