<?php
declare(strict_types=1);
namespace PangzLab\App\Middleware\ErrorHandlerRenderer;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//use PangzLab\Lib\Middleware\MiddlewareInterface;
use Slim\Handlers\ErrorHandler;

class ErrorRequestHandler extends ErrorHandler
{
    // public function methodName(Request $request, RequestHandler $handler): Response
    // {
    //     /**
    //     * your code here....
    //     */
    //     return $handler->handle($request);
    // }
    protected function logError(string $error): void
    {
        file_put_contents("error.log", $error, FILE_APPEND);
    }
}