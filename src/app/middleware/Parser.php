<?php
declare(strict_types=1);
namespace PangzLab\App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

use PangzLab\Lib\Middleware\MiddlewareInterface;

class Parser implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        file_put_contents("tl.log","Data >> ".serialize($request), FILE_APPEND);
        file_put_contents('tl.log','Parser,', FILE_APPEND);
        return $handler->handle($request);
    }
}