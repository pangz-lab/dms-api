<?php
declare(strict_types=1);
namespace PangzLab\Lib\Routing;

use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\App;

class RouteProvider
{   
    const NAMESPACE = 'PangzLab\\App\\Routing\\';
    private static $slimApp;
    private static $container;
    private static $httpMethod;
    private static $methodCaps;
    
    public static function deploy(
        App $app,
        Container $container,
        RouteMethodCollectionInterface $collection,
        string $method
    ) {
        static::$slimApp    = $app;
        static::$container  = $container;
        static::$httpMethod = \strtolower($method);
        static::$methodCaps = \strtoupper($method);
        $definition = \array_merge(
            $collection::{static::$httpMethod}(),
            $collection::any()
        );

        foreach($definition as $item) {
            if($item->getMethodCount() === 1) {
                static::runSingle($item);
            } else {
                static::runMultiple($item);
            }
        }
        return $app;
    }

    private static function runSingle(RouteUnit $routeItem)
    {
        return static::$slimApp->map(
            [static::$methodCaps],
            $routeItem->getRoute(),
            static::NAMESPACE.$routeItem->getMethod()
        )->setName($routeItem->getName());
    }

    private static function runMultiple(RouteUnit $routeItem)
    {
        $methods = $routeItem->getMethodList();
        static::$slimApp->map(
            [static::$methodCaps],
            $routeItem->getRoute(),
            static::resolveDefinitionToObject($methods)
        )->setName($routeItem->getName());
    }

    private static function resolveDefinitionToObject(array $methods)
    {        
        $class  = '';
        $method = '';
        $className    = '';
        $definition   = [];
        $instanceList = [];
        foreach($methods as $currentMethod) {
            list($class, $method) = explode(':', $currentMethod);
            if(!isset($instanceList[$class])) {
                $className = static::NAMESPACE.$class;
                $instanceList[$class] = new $className(static::$container);
            }
            $definition[] = [
                'instance' => $instanceList[$class],
                'method' => $method
            ];
        }

        return new class($definition) {

            private static $definition;

            public function __construct($definition)
            {
                static::$definition = $definition;
            }

            public function __invoke($request, $response, $args)
            {
                foreach(static::$definition as $currentDef) {                   
                    $currentDef['instance']->{$currentDef['method']}(
                        $request,
                        $response,
                        $args
                    );
                }

                return $response;
            }
        };
    }
}