<?php
declare(strict_types=1);
namespace PangzLab\Lib\Service;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

use PangzLab\Lib\Interfaces\ExecutionContextInterface;

class ServiceProvider
{   
    const NAMESPACE = 'PangzLab\\App\\Service\\';
    private static $slimApp;
    private static $container;
    private static $httpMethod;
    private static $collection;
    
    public static function deploy(
        App $app,
        Container $container,
        ExecutionContextInterface $collection,
        string $method
    ) {
        static::$slimApp    = $app;
        static::$container  = $container;
        static::$httpMethod = $method;
        $methodName = 'method'.ucfirst(static::$httpMethod);
        static::$collection = \array_merge(
            $collection::app(),
            $collection::{$methodName}()
        );
        
        if(empty(static::$collection)) { return;}
        static::instantiateServices();
    }

    private static function instantiateServices()
    {
        $classes   = static::$collection;
        $className = "";
        foreach($classes as $currentClass) {
            $className = static::NAMESPACE.$currentClass;
            static::$container->set($currentClass, new $className());
        }
    }
}