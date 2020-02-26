<?php
declare(strict_types=1);
namespace PangzLab\Lib\Middleware;

use PangzLab\Lib\Interfaces\ExecutionContextInterface;

use Slim\App;

class MiddlewareProvider
{
    public static function deploy(
        App $app,
        ExecutionContextInterface $collection,
        string $method
    ) {
        Middleware::deploy($app, $collection, \strtolower($method));
    }
}