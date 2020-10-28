<?php
use DI\Container;
// use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpInternalServerErrorException;

use PangzLab\App\Module;
use PangzLab\App\Middleware\ErrorHandlerRenderer\ErrorRequestHandler;
use PangzLab\App\Middleware\ErrorHandlerRenderer\ErrorRequestRenderer;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add Routing Middleware --For error handling
$app->addRoutingMiddleware();

Module::deploy($app, $container);

/////////////////////////////////////////////////////////
//For CORS Preflight -- @TODO setup a new middleware for cors preflight
//http://www.slimframework.com/docs/v3/cookbook/enable-cors.html
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//For CORS Preflight
$app->add(function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    // $origin = 'http://localhost:4200';
    // $origin = 'http://localhost';
    $origin = 'http://localhost:9900';
    // $origin = 'http://localhost/dudezmobi_staking/web-ui/dudezmobi-staking';
    // $allowedOriginList = [
    //     'http://localhost:4200'
    // ];

    // if ($request->hasHeader('Origin') && in_array($request->getHeader("Origin"), $allowedOriginList)) {
    //     $origin = $request->getHeader("Origin");
    // }

    return $response
        ->withHeader('Access-Control-Allow-Origin', $origin)
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

//Handler for all routes should there be an error
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpInternalServerErrorException($request);
});
//End CORS
/////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////
// Define Custom Error Handler - this is for error handling
//Improve this
// ref http://www.slimframework.com/docs/v4/middleware/error-handling.html

$customErrorHandler = new ErrorRequestHandler(
    $app->getCallableResolver(),
    $app->getResponseFactory()
);

// // Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
// $errorHandler->registerErrorRenderer('text/html', ErrorRequestRenderer::class);
$errorHandler->registerErrorRenderer('application/json', ErrorRequestRenderer::class);
$errorHandler->forceContentType('application/json');

//this is for error handling - end 
/////////////////////////////////////////////////////////////

$app->run();