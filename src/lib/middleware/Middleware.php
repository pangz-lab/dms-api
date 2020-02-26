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
        $methodName = 'method'.\ucfirst(static::$httpMethod);
        static::$collection = \array_merge(
            static::$collection::app(),
            static::$collection::{$methodName}()
        );
        if(empty(static::$collection)) { return;}
    }

    private static function process()
    {
        static::$slimApp->add(
            static::resolveDefinitionToObject(static::$collection)
        );
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

        return new class($definition) {

            private static $definition = [];

            public function __construct($definition)
            {
                static::$definition = $definition;
            }

            public function __invoke(
                Request $request,
                RequestHandler $handler
            ): Response {
                foreach(static::$definition as $currentDef) {
                    $currentDef['instance']->process(
                        $request,
                        $handler
                    );
                }
                return $handler->handle($request);
            }
        };
    }
}