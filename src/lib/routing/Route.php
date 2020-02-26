<?php
declare(strict_types=1);
namespace PangzLab\Lib\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class Route
{
    protected $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}