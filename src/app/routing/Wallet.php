<?php
declare(strict_types=1);
namespace PangzLab\App\Routing;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use PangzLab\Lib\Routing\Route;

class Wallet extends Route
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function getSummary(Request $request, Response $response, $args)
    {
        $payload = json_encode([
            'data' => [
                [
                    'walletAddress' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'verusID' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'openingBalance' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'deposits' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'withdrawals' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'stakingBalance' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'currentPercentage' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'stakingPercentage' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'stakeReward' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'depositStake' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'currentBalance' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                    'stakeRewardAmount' => 'FA4NL2KN3124L3N6J2N3J62NB3K56BJ3K256BB',
                ]
            ]
        ]);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type','application/json');
        // return $response;
    }
}