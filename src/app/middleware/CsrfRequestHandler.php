<?php
declare(strict_types=1);
namespace PangzLab\App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use PangzLab\Lib\Middleware\MiddlewareInterface;

class CsrfRequestHandler implements MiddlewareInterface
{
    public function methodName(Request $request, RequestHandler $handler): Response
    {
        /**
        * your code here....
        */
        return $handler->handle($request);
    }
}