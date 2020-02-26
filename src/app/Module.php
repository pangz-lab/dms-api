<?php
namespace PangzLab\App;
use DI\Container;
use PangzLab\Lib\Routing\RouteProvider;
use PangzLab\Lib\Middleware\MiddlewareProvider;
use PangzLab\Lib\Service\ServiceProvider;
use PangzLab\App\RouteSetting;
use PangzLab\App\MiddlewareSetting;
use PangzLab\App\ServiceSetting;
use Slim\App;

class Module
{
    private static $container;
    public static function deploy(App $app, Container $container)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        MiddlewareProvider::deploy($app, new MiddlewareSetting(), $method);
        ServiceProvider::deploy($app, $container, new ServiceSetting(), $method);
        RouteProvider::deploy($app, $container, new RouteSetting(), $method);
    }

    private static function prepareServices()
    {
        self::$container->set('services', function() {

        });
    }
}