<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PangzLab\Lib\Routing\Route;

class History extends Route
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function getUpdateEventSummary(Request $request, Response $response, $args)
    {
        $testData = [];
        for($x = 1; $x <= 100; $x++) {
            $testData[] = [
                "id" => $x,
                "date" => 'January 19, 2020',
                "description" => "Stake found $x",
                "remarks" => "remarks $x" ,
                "author" => "author $x"
            ];
        }
        $payload = json_encode([ 'data' => $testData ]);

        $response->getBody()->write($payload);
        $r = $response->withHeader('Access-Control-Allow-Origin','*');
        return $r->withHeader('Content-Type','application/json');
    }
}