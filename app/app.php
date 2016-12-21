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


    $app->get("/", function() use($app){
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/stores/{store_id}", function($store_id) use($app) {
      $current_store = Store::find($store_id);
      return $app['twig']->render('store.html.twig', array(
          'single_store' => $current_store,
          'all_store' => Store::getAll(),
          'brands_sold_in_store' => $current_store->getBrands()
      ));
    }); 

    return $app;
?>
