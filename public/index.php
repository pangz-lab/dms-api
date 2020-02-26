<?php
use DI\Container;
// use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;

use PangzLab\App\Module;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// $beforeMiddleware = function (Request $request, RequestHandler $handler) {
//     file_put_contents('tl.log','B3,', FILE_APPEND);
//     $response = $handler->handle($request);
//     $existingContent = (string) $response->getBody();

//     $response = new Response();
//     $response->getBody()->write('BEFORE' . $existingContent);
    

//     return $response;
// };

// $afterMiddleware = function ($request, $handler) {
    
//     file_put_contents('tl.log','A2,', FILE_APPEND);
//     $response = $handler->handle($request);
//     $response->getBody()->write('AFTER');
//     return $response;
// };

// $routeMW = function ($request, $handler) {    
//     file_put_contents('tl.log','RM0,', FILE_APPEND);
//     $response = $handler->handle($request);
//     $response->getBody()->write('AFTER');
//     return $response;
// };

// $app->get('/', function (Request $request, Response $response, $args) {
//     // print "3\n";
//     file_put_contents('tl.log','1,', FILE_APPEND);
//     $response->getBody()->write('Hello World');
// 	return $response;
// })->add($routeMW);

// $container->set('db',new  \PangzLab\App\Service\DatabaseService);

// $app->get('/testser', function (Request $request, Response $response, $args) {
//     // print "3\n";
//     file_put_contents('tl.log','1,', FILE_APPEND);
//     $response->getBody()->write('Hello World '. $this->get('db')->getDBName());
// 	return $response;
// });

// $app->add($beforeMiddleware);
// $app->add($afterMiddleware);
// $app->add($beforeMiddleware);
// $app->add($afterMiddleware);

// $app->head('/books', function (Request $request, Response $response, $args) {
//     // print "3\n";
//     file_put_contents('tl.log','1,', FILE_APPEND);
//     $response->getBody()->write('Hello World');
// 	return $response;
// })->add($routeMW);


Module::deploy($app, $container);
$app->run();