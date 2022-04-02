<?PHP
    $loader = require 'vendor/autoload.php';

    $app = new \Slim\Slim(array(
        'templates.path' => 'templates'
    ));

    $app->get('/produto/', function() use ($app){
        (new \controllers\Produto($app))->getListaProduto();
    });

    $app->run();    