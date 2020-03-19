<?php
declare(strict_types=1);
namespace PangzLab\Lib\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

use PangzLab\Lib\Interfaces\ExecutionContextInterface;

class Middleware
{
    const NAMESPACE = 'PangzLab\\App\\Middleware\\';
    private static $slimApp;
    private static $httpMethod;
    private static $collection;
    
    public static function deploy(
        App $app,
        ExecutionContextInterface $collection,
        string $method
    ) {
        static::$slimApp    = $app;
        static::$httpMethod = $method;
        static::$collection = $collection;
        static::resolveSequence();
        static::process();
    }

    private static function resolveSequence()
    {
        $methodMiddleware = 'method'.\ucfirst(static::$httpMethod);
        static::$collection = \array_merge(
            static::$collection::app(),
            static::$collection::{$methodMiddleware}()
        );
        
        if(empty(static::$collection)) { return;}
    }

    private static function process()
    {
        $middleWareDefinition = static::resolveDefinitionToObject(static::$collection);
        foreach($middleWareDefinition as $currentMiddleWare) {
            static::$slimApp->add(static::createWrapperClass($currentMiddleWare));
        }
    }

    private static function resolveDefinitionToObject(array $classes)
    {
        $className    = '';
        $definition   = [];
        $instanceList = [];
        foreach($classes as $currentClass) {
            if(!isset($instanceList[$currentClass])) {
                $className = static::NAMESPACE.$currentClass;
                $instanceList[$currentClass] = new $className();
            }
            $definition[] = [
                'instance' => $instanceList[$currentClass]
            ];
        }

        return $definition;
    }

    private static function createWrapperClass($definition)
    {
        return new class($definition) {

            private $definition = [];

            public function __construct($definition)
            {
                $this->definition = $definition;
            }

            public function __invoke(
                Request $request,
                RequestHandler $handler
            ): Response {
                return $this->definition['instance']->process(
                    $request,
                    $handler
                );
            }
        };
    }
}