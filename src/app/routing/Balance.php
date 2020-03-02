<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PangzLab\Lib\Routing\Route;

class Balance extends Route
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function getStakeVsRewards(Request $request, Response $response, $args): Response
    {
        $testData = [
            ["name" => "Current Balance", "value" => "70"],
            ["name" => "Stake Rewards", "value" => "30"],
        ];
        $payload = json_encode([ 'data' => $testData ]);

        $response->getBody()->write($payload);
        $r = $response->withHeader('Access-Control-Allow-Origin','*');
        return $r->withHeader('Content-Type','application/json');
    }
}