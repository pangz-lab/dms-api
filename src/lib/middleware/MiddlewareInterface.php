<?php
declare(strict_types=1);
namespace PangzLab\Lib\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface MiddlewareInterface extends \Psr\Http\Server\MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response;
}