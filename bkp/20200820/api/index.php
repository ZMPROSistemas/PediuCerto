<?php

 use Psr\Http\Message\ServerRequestInterface as Request;
 use Psr\Http\Message\ResponseInterface as Response;
    require_once "vendor/autoload.php";

    $configuration = [
        'settings' => [
            'displayErrorDetails' => true,
        ],
    ];
    $configuration = new \Slim\Container($configuration);


    $midd1 = function(Request $request, Response $response, $next) : Response{
        $response->getBody()->write("Middiware 1");

        $response = $next($request, $response);

        $response->getBody()->write("Middiware 2");

        return $response;
    };

    $app->group('produto', function() use($app){
        $app->get('/produto',);
        $app->post('/produto',);
        
    })->add($midd1);
    
    $app = new \Slim\App($configuration);

    $app->get('/', function($request, $response, $args){
        return $response->getBody()->write("Certo");
    })->add($midd1);
    
    $app->get('/produto[/{token}]', function(Request $request, Response $response, array $args): Response{
       //$limit = $request ->getQueryParams()['limit'] ?? 10;
       $token = $args['token']??'';

       $response->getBody()->write("Certo {$token}");

        return $response;
    })->add($midd1);

    $app->post('/produto/{token}', function(Request $request, Response $response, array $args) {
        $token = $args['token']??'';
        $data = $request->getParsedBody();
        
        $nome = $data['nome'] ?? null;

         //return $response->getBody()->write("{$limit} Certo {$token}");
     })->add($midd1);

    $app->run();