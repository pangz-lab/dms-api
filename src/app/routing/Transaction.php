<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PangzLab\Lib\Routing\Route;

class Transaction extends Route
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function getSummary(Request $request, Response $response, $args)
    {
        $testData = [];
        for($x = 1; $x <= 100; $x++) {
            $testData[] = [
                'id' => $x,
                'walletAddress' => 'AASFA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                'verusID' => 'Pdudezmobi@',
                'openingBalance' => 123.123,
                'deposits' => 0.0243,
                'withdrawals' => 0.04234,
                'stakingBalance' => 123.32,
                'currentPercentage' => 0.00587,
                'stakingPercentage' => 0.58,
                'stakeReward' => 0.1233213,
                'depositStake' => 116.12,
                'currentBalance' => 208.3232,
                'stakeRewardAmount' => 92.242342,
            ];
        }
        $payload = json_encode([ 'data' => $testData ]);

        $response->getBody()->write($payload);
        $r = $response->withHeader('Access-Control-Allow-Origin','*');
        return $r->withHeader('Content-Type','application/json');
    }
}